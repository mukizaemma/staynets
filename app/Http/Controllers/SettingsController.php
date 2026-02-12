<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Term;
use App\Models\Leftbag;
use App\Models\Ticketing;
use App\Models\About;
use App\Models\Aboutus;
use App\Models\Setting;
use App\Models\CarRentalContent;
use App\Models\Getinvolved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function setting(){
        $data = Setting::first();
        $setting = Setting::first();
        if($data===null)
        {
            $data = new Setting();
            $data->title = 'Company Name';
            $data->user_id = Auth()->user()->id;
            $data->company = 'Company Name';
            $data->keywords = 'Community development in Rwanda';
            $data->save();
            $data = Setting::first();
        }

        return view('admin.setting', ['data'=>$data,'setting'=>$setting]);
    }



    public function saveSetting(Request $request){
        $data = Setting::first();
        $data->company = $request->input('company');
        $data->address = $request->input('address');
        $data->phone = $request->input('phone');
        $data->email = $request->input('email');
        $data->facebook = $request->input('facebook');
        $data->instagram = $request->input('instagram');
        $data->youtube = $request->input('youtube');
        $data->linkedin = $request->input('linkedin');
        $data->linktree = $request->input('linktree');
        $data->keywords = $request->input('keywords');
        $data->quote = $request->input('quote');
        $data->user_id = Auth()->user()->id;


        if ($request->hasFile('logo') && request('logo') != '') {
            $dir = 'public/images';

            if (File::exists($dir)) {
                unlink($dir);
            }
            $path = $request->file('logo')->store($dir);
            $fileName = str_replace($dir, '', $path);

            $data->logo = $fileName;
        }


        if ($request->hasFile('donate') && request('donate') != '') {
            $dir = 'public/images';

            if (File::exists($dir)) {
                unlink($dir);
            }
            $path = $request->file('donate')->store($dir);
            $fileNameLogo2 = str_replace($dir, '', $path);

            $data->donate = $fileNameLogo2;
        }

        $saved = $data->update();

        if($saved){
            return redirect()->back()->with('success', 'Setting has been updated successfully');
        }
        else{
            abort(404);
        }
    }

    public function aboutPage(){
        $data = About::first();
        $setting = Setting::first();
        $terms = Term::first();
        if($data===null)
        {
            $data = new About();
            $data->title = 'About Us';
            $data->welcomeMessage = 'About Us';
            $data->user_id = 1;
            $data->save();
            $data = About::first();
        }
        if($terms===null)
        {
            $terms = new Term();
            $terms->terms = 'Our Terms and conditions';
            $terms->privacy = 'Our Privacy policies';
            $terms->privacy_details = 'We do not share or use your data for third-party marketing.';
            $terms->cookies = 'We use cookies to improve site experience.';
            $terms->refunds = 'Refund policy details.';
            $terms->booking_cancellation = 'Booking cancellation policy.';
            $terms->listing_commission = 'Listing commission policy.';
            $terms->payment_methods = 'Accepted payment methods.';
            $terms->return = 'Our Return policies';
            $terms->support = 'Our Support policies';
            $terms->added_by = Auth()->user()->id;
            $terms->save();
            $terms = Term::first();
        }

        return view('admin.pages.about', ['data'=>$data,'setting'=>$setting,'terms'=>$terms]);
    }

    public function saveAbout(Request $request){
        $data = About::first();
        $title = [];
        $subTitle = [];
        $welcomeMessage = [];
        $terms = [];
        $WhyChooseUs = [];
        $vision = [];
        $image1 = [];
        $image2 = [];
        $image3 = [];
        $image4 = [];
        $storyImage = [];
        $backImageText = [];
    
        if ($data->welcomeMessage != $request->input('welcomeMessage')) {
            $data->welcomeMessage = $request->input('welcomeMessage');
            $welcomeMessage[] = 'welcomeMessage';
        }
    
        if ($data->WhyChooseUs != $request->input('WhyChooseUs')) {
            $data->WhyChooseUs = $request->input('WhyChooseUs');
            $WhyChooseUs[] = 'WhyChooseUs';
        }
    
        if ($data->terms != $request->input('terms')) {
            $data->terms = $request->input('terms');
            $terms[] = 'terms';
        }
    
        if ($data->mission != $request->input('mission')) {
            $data->mission = $request->input('mission');
            $mission[] = 'mission';
        }
    
        if ($data->subTitle != $request->input('subTitle')) {
            $data->subTitle = $request->input('subTitle');
            $subTitle[] = 'subTitle';
        }
        // Handle file uploads
        $dir = 'public/images/about/';
    
        if ($request->hasFile('image1') && request('image1') != '') {
            // Delete old file
            File::delete($dir . $data->image1);
            // Store new file
            $fileName = $request->file('image1')->store($dir);
            $data->image1 = str_replace($dir, '', $fileName);
            $image1[] = 'image1';
        }

        if ($request->hasFile('image2') && request('image2') != '') {
            // Delete old file
            File::delete($dir . $data->image2);
            // Store new file
            $fileName2 = $request->file('image2')->store($dir);
            $data->image2 = str_replace($dir, '', $fileName2);
            $image2[] = 'image2';
        }

        if ($request->hasFile('image3') && request('image3') != '') {
            // Delete old file
            File::delete($dir . $data->image3);
            // Store new file
            $fileName3 = $request->file('image3')->store($dir);
            $data->image3 = str_replace($dir, '', $fileName3);
            $image3[] = 'image3';
        }

        if ($request->hasFile('image4') && request('image4') != '') {
            // Delete old file
            File::delete($dir . $data->image4);
            // Store new file
            $fileName4 = $request->file('image4')->store($dir);
            $data->image4 = str_replace($dir, '', $fileName4);
            $image4[] = 'image4';
        }

    
        $saved = $data->update();
    
        if($saved){
            return redirect()->back()->with('success', 'About us Page fields have been updated successfully');

        }

        return redirect()->back()->with('error', 'No fields were updated');
    }
    public function getLeftBags(){
        $data = Leftbag::first();
        $setting = Setting::first();
        if($data===null)
        {
            $data = new Leftbag();
            $data->heading = 'About Us';
            $data->description = 'About Us';
            $data->user_id = 1;
            $data->save();
            $data = Leftbag::first();
        }

        return view('admin.pages.leftBags', ['data'=>$data,'setting'=>$setting]);
    }

    public function updateBags(Request $request){
        $data = Leftbag::first();
        $heading = [];
        $description = [];
    
        if ($data->heading != $request->input('heading')) {
            $data->heading = $request->input('heading');
            $heading[] = 'heading';
        }
    
        if ($data->description != $request->input('description')) {
            $data->description = $request->input('description');
            $description[] = 'description';
        }

        // Handle file uploads
        $dir = 'public/images/leftbags/';
    
        if ($request->hasFile('image') && request('image') != '') {
            // Delete old file
            File::delete($dir . $data->image);
            // Store new file
            $fileName = $request->file('image')->store($dir);
            $data->image = str_replace($dir, '', $fileName);
            $image[] = 'image';
        }

    
        $saved = $data->update();
    
        if($saved){
            return redirect()->back()->with('success', 'Page fields have been updated successfully');

        }

        return redirect()->back()->with('error', 'No fields were updated');
    }
    public function getTicketing(){
        $data = Ticketing::first();
        $setting = Setting::first();
        if($data===null)
        {
            $data = new Ticketing();
            $data->heading = 'About Us';
            $data->description = 'About Us';
            $data->user_id = 1;
            $data->save();
            $data = Leftbag::first();
        }

        return view('admin.pages.ticketing', ['data'=>$data,'setting'=>$setting]);
    }

    public function updateTicketing(Request $request){
        $data = Ticketing::first();
        $heading = [];
        $description = [];
    
        if ($data->heading != $request->input('heading')) {
            $data->heading = $request->input('heading');
            $heading[] = 'heading';
        }
    
        if ($data->description != $request->input('description')) {
            $data->description = $request->input('description');
            $description[] = 'description';
        }

        // Handle file uploads
        $dir = 'public/images/ticketing/';
    
        if ($request->hasFile('image') && request('image') != '') {
            // Delete old file
            File::delete($dir . $data->image);
            // Store new file
            $fileName = $request->file('image')->store($dir);
            $data->image = str_replace($dir, '', $fileName);
            $image[] = 'image';
        }

    
        $saved = $data->update();
    
        if($saved){
            return redirect()->back()->with('success', 'Page fields have been updated successfully');

        }

        return redirect()->back()->with('error', 'No fields were updated');
    }

    // Car rental content
    public function getCarRental()
    {
        $setting = Setting::first();
        $data = CarRentalContent::first();
        if ($data === null) {
            $data = CarRentalContent::create([
                'heading' => 'Stay Nets Car Rental Services',
                'subheading' => 'Reliable, Comfortable, and Flexible Car Rental in Rwanda',
                'description' => 'Travel Rwanda and East Africa with ease and comfort through Stay Nets Car Rental Services.',
                'fleet_content' => '',
                'why_content' => '',
                'services_content' => '',
                'booking_content' => '',
                'cta_book_label' => 'Book Your Car',
                'cta_quote_label' => 'Request a Quote',
            ]);
        }

        return view('admin.pages.carRental', ['data' => $data, 'setting' => $setting]);
    }

    public function updateCarRental(Request $request)
    {
        $data = CarRentalContent::firstOrFail();

        $data->heading = $request->input('heading');
        $data->subheading = $request->input('subheading');
        $data->description = $request->input('description');
        $data->fleet_content = $request->input('fleet_content');
        $data->why_content = $request->input('why_content');
        $data->services_content = $request->input('services_content');
        $data->booking_content = $request->input('booking_content');
        $data->cta_book_label = $request->input('cta_book_label');
        $data->cta_quote_label = $request->input('cta_quote_label');

        // Handle hero image upload
        $dir = 'public/images/car-rental/';
        if ($request->hasFile('hero_image') && $request->file('hero_image')->isValid()) {
            if ($data->hero_image) {
                \Illuminate\Support\Facades\File::delete($dir . $data->hero_image);
            }
            $stored = $request->file('hero_image')->store($dir);
            $data->hero_image = str_replace($dir, '', $stored);
        }

        $data->save();

        return redirect()->back()->with('success', 'Car rental content updated successfully');
    }



    // Terms and policies

    public function getTerms(){
        $data = Term::first();
        if($data===null)
        {
            $data = new Term();
            $data->terms = 'Our Terms and conditions';
            $data->privacy = 'Our Privacy policies';
            $data->privacy_details = 'We do not share or use your data for third-party marketing.';
            $data->cookies = 'We use cookies to improve site experience.';
            $data->refunds = 'Refund policy details.';
            $data->booking_cancellation = 'Booking cancellation policy.';
            $data->listing_commission = 'Listing commission policy.';
            $data->payment_methods = 'Accepted payment methods.';
            $data->return = 'Our Return policies';
            $data->support = 'Our Support policies';
            $data->added_by = Auth()->user()->id;
            $data->save();
            $data = Term::first();
        }

        return view('admin.terms', ['data'=>$data]);
    }

    
    public function saveTerms(Request $request){
        $data = Term::first();
        $data->privacy = $request->input('privacy');
        $data->privacy_details = $request->input('privacy_details');
        $data->cookies = $request->input('cookies');
        $data->refunds = $request->input('refunds');
        $data->booking_cancellation = $request->input('booking_cancellation');
        $data->listing_commission = $request->input('listing_commission');
        $data->payment_methods = $request->input('payment_methods');
        $data->return = $request->input('return');
        $data->terms = $request->input('terms');
        $data->support = $request->input('support');


        $data->update();

        return redirect()->back()->with('success', 'Terms and policies has been updated successfully');
    }
}
