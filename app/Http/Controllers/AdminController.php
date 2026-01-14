<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\Articlecomment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentApprovalNotification;
use App\Models\BlogComment;
use App\Models\Message;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        // $blogCommets = BlogComment::latest()->get();
        // $blogCommetsCount = $blogCommets->count();
        $data = Setting::first();
        $rooms = Hotel::count();

        $setting = Setting::first();
        return view('admin.dashboard',[
            // 'blogCommetsCount' =>$blogCommetsCount,
            'users'=>$users,
            'data'=>$data,
            'setting'=>$setting,
            'rooms'=>$rooms,
        ]);
    }

    /**
     * Display users page - accessible only to admins (role == 1)
     * Only super admin (email = admin@iremetech.com) can see admin users (role == 1)
     * Regular admins can only see regular users (role != 1)
     */
    public function users(Request $request){
        $query = User::withCount(['properties', 'hotelBookings']);
        
        // Check if current user is super admin (email = admin@iremetech.com)
        // Note: role == 1 means admin, role != 1 or null means regular user
        $isSuperAdmin = Auth::check() && Auth::user()->email === 'admin@iremetech.com';
        
        // Filter by admin status
        $filter = $request->input('filter', 'all'); // all, admins, users
        
        // Only super admin can view admins filter
        if ($filter === 'admins' && !$isSuperAdmin) {
            $filter = 'all'; // Reset to all if non-super-admin tries to access admins
        }
        
        if ($filter === 'admins' && $isSuperAdmin) {
            // Super admin viewing admins only (role == 1)
            $query->where('role', 1);
        } elseif ($filter === 'users') {
            // Viewing regular users only (role != 1 or null)
            $query->where(function($q) {
                $q->where('role', '!=', 1)->orWhereNull('role');
            });
        } elseif ($filter === 'all') {
            // View all - but exclude admins (role == 1) for non-super-admins
            if (!$isSuperAdmin) {
                // Regular admins should not see other admins (role == 1) in "all" view
                $query->where(function($q) {
                    $q->where('role', '!=', 1)->orWhereNull('role');
                });
            }
            // Super admin can see everyone including admins (no filter needed)
        }
        
        // Search functionality - search in both name and email
        $search = $request->input('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        $users = $query->latest()->get();
        $setting = Setting::first();
        
        return view('admin.users',[
            'users'=>$users,
            'setting'=>$setting,
            'filter'=>$filter,
            'search'=>$search,
            'isSuperAdmin'=>$isSuperAdmin
        ]);
    }

    public function showUser($id){
        $user = User::with(['properties' => function($query) {
            $query->with('category', 'images')->latest();
        }, 'hotelBookings' => function($query) {
            $query->with('property', 'unit')->latest();
        }])->findOrFail($id);
        
        // Check if current user is super admin (email = admin@iremetech.com)
        // Note: role == 1 means admin
        $isSuperAdmin = Auth::check() && Auth::user()->email === 'admin@iremetech.com';
        
        // If viewing an admin user (role == 1) and current user is not super admin, deny access
        if ($user->role == 1 && !$isSuperAdmin) {
            return redirect()->route('users')
                ->with('error', 'You do not have permission to view admin user details.');
        }
        
        $setting = Setting::first();
        return view('admin.users.show', [
            'user' => $user,
            'setting' => $setting,
            'isSuperAdmin' => $isSuperAdmin
        ]);
    }

    public function verifyUserEmail($id){
        $user = User::findOrFail($id);
        
        // Check if current user is super admin (email = admin@iremetech.com)
        // Note: role == 1 means admin
        $isSuperAdmin = Auth::check() && Auth::user()->email === 'admin@iremetech.com';
        
        // If trying to verify an admin user (role == 1) and current user is not super admin, deny access
        if ($user->role == 1 && !$isSuperAdmin) {
            return redirect()->route('users')
                ->with('error', 'You do not have permission to verify admin user emails.');
        }
        
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return redirect()->back()->with('success', 'User email has been verified successfully.');
        }
        
        return redirect()->back()->with('info', 'User email is already verified.');
    }

    public function makeAdmin($id){
        // Check if current user is super admin (email = admin@iremetech.com)
        // Only super admin can grant admin privileges (role == 1)
        $isSuperAdmin = Auth::check() && Auth::user()->email === 'admin@iremetech.com';
        
        if (!$isSuperAdmin) {
            return redirect()->back()->with('error', 'Only the super admin can grant admin privileges.');
        }
        
        $user = User::findOrFail($id);
        $user->role = 1; // Set role to 1 (admin)
        $user->save();

        return redirect()->back()->with('success','User is now an admin');
    }

    
    public function deleteUser($id)
    {
        // Check if current user is super admin (email = admin@iremetech.com)
        // Only super admin can delete admin users (role == 1)
        $isSuperAdmin = Auth::check() && Auth::user()->email === 'admin@iremetech.com';
        
        $post = User::findOrFail($id);
        
        // Prevent deleting admin users (role == 1) unless super admin
        if ($post->role == 1 && !$isSuperAdmin) {
            return redirect()->back()->with('error', 'You do not have permission to delete admin users.');
        }
        
        $post->delete();

        return redirect()->back()->with('success', 'User has been deleted');
    }


    public function blogsComment(Request $request)
    {
        $filter = $request->input('filter', 'all'); // Get the filter type, default to 'all'
    
        $comments = BlogComment::query();
    
        if ($filter === 'published') {
            $comments->where('status', 'Published');
        } elseif ($filter === 'unpublished') {
            $comments->where('status', 'Unpublished');
        }
    
        $comments = $comments->latest()->paginate(2);
    
        return view('admin.posts.comments', [
            'comments' => $comments,
            'filter' => $filter, // Pass the current filter to the view
        ]);
    }
    

    public function commentApprove(BlogComment $comment){

        if($comment->status !=='Published'){
            $comment->status='Published';
            $comment->save();

            $user = $comment->user;

            if($user){
                $details = [
                    'greeting' => 'Hello ' . $user->name . '!',
                    'body' => 'Thank you so much for your helpful comment',
                    'lastline' => 'Blessings!',
                ];
                Mail::to($user->email)->queue(new CommentApprovalNotification($details));
                return redirect()->route('blogsComment')->with('success', 'Comment approved successfully');
            }
        }
        return redirect()->back()->with('error', 'Unable to approve comment');

    }

    public function destroyBlogComment($id)
    {
        $comment = BlogComment::find($id); 
        $comment->delete($id);
        return back()
            ->with('success', 'Comment deleted successfully');
    }

    public function subscribers(){
        $setting = Setting::first();
        $subscribers = Subscriber::latest()->paginate(20);
        return view('admin.posts.subscribers',[
            'subscribers'=>$subscribers,
            'setting'=>$setting,
        ]);
    }

    
    public function destroySub($id)
    {
        $subscriber = Subscriber::find($id); 
        $subscriber->delete($id);
        return back()
            ->with('success', 'Subscriber deleted successfully');
    }
    public function getMessages(){
        $messages = Message::latest()->paginate(10);
        return view('admin.posts.messages',[
            'messages'=>$messages,
        ]);
    }

    
    public function deleteMessages($id)
    {
        $subscriber = Message::find($id); 
        $subscriber->delete($id);
        return back()
            ->with('success', 'Message deleted successfully');
    }

    // public function visits()
    // {
    //     $totalVisits = DB::table('visits')->count();
    //     $uniqueVisitors = DB::table('visits')->distinct('ip_address')->count();


    //     return view('admin.dashboard',[
    //         'totalVisits'=>$totalVisits,
    //         'uniqueVisitors'=>$uniqueVisitors,
    //     ]);
    // }

    /**
     * Logout the authenticated user
     */
    public function logouts()
    {
        Auth::logout();
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

}
