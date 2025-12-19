<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Car;
use App\Models\Program;
use Illuminate\Support\Str;
use App\Models\Tripimage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CarsController extends Controller
{
        public function index()
    {
    
        $cars = Car::latest()->get();
        $programs = Program::all();
        return view('admin.cars.cars', [
            'cars' => $cars,
            'programs' => $programs,
        ]);
    }
    


    public function store(Request $request): RedirectResponse
    {

        $fileName = '';

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = $file->store('public/images/cars');
                $fileName = basename($path);
                break; 
            }
        }
    
        $slug = Str::of($request->input('name'))->slug();
    
        $blog = new Car();
        $blog->name = $request->input('name');
        $blog->model = $request->input('model');
        $blog->fuel_type = $request->input('fuel_type');
        $blog->seats = $request->input('seats');
        $blog->transmission = $request->input('transmission');
        $blog->price_per_day = $request->input('price_per_day');
        $blog->program_id = $request->input('program_id');
        $blog->images = $fileName;
        $blog->slug = $slug;
        $blog->added_by = $request->user()->id;
        $saved = $blog->save();
    
       if($saved){
         return redirect()->route('getCars')->with('success', 'New Car has been saved successfully');
       }
       else 
         return redirect()->route('getCars')->with('error', 'Something went wrong');
    }

    
    public function edit($id)
    {
        $car = Car::find($id);
        $images = collect($car->images ?? []);
        $totalImages = $images->count();

        return view('admin.cars.carUpdate', [
            'car'=>$car,
            'images'=>$images,
            'totalImages'=>$totalImages,
        ]);
    }
    public function view($id)
    {
        $car = Trip::find($id);
        $program= Trip::all();
        return view('admin.posts.blogView', [
            'service'=>$car,
            'program'=>$program,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $car = Car::findOrFail($id);
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('public/images/cars');
                Storage::delete('public/images/cars/' . $car->image);
                $car->image = basename($path);
            }
    
            $fields = [
                'name', 'description', 'status','model','fuel_type','seats','transmission',
                'price_per_day','price_per_month','price_to_buy','images','added_by','program_id',
                ];
            foreach ($fields as $field) {
                if ($request->has($field) && $request->input($field) !== $car->$field) {
                    $car->$field = $request->input($field);
                }
            }
    
            if ($car->isDirty('name')) {
                $slug = Str::of($car->name)->slug();
                if (Trip::where('slug', $slug)->where('id', '!=', $car->id)->exists()) {
                    $slug .= '-' . uniqid();
                }
                $car->slug = $slug;
            }
    
            $car->save();
    
            return redirect()->route('getCars')->with('success', 'Trip has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    


    public function destroy($id)
    {
        $car = Car::find($id); 
        if (!$car) {
            return back()->with('error', 'Content not found');
        }
        if ($car->image) {
            Storage::delete('public/images/cars/' . $car->image);
        }
        $car->delete($id);
        return back()
            ->with('success', 'Story deleted successfully');
    }
}
