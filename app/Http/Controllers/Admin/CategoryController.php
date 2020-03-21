<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required|image|max:5120',
        ], [
            'image.max' => "Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB"
        ]);

        //get image from form
        $image = $request->file('image');
        $slug = Str::slug($request->name);

        if (isset($image)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //Check category dir is exists or not
            if (!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
            //resize image for category and upload it
            $category = Image::make($image)->resize(1600,479)->save();
            Storage::disk('public')->put('category/'.$imagename,$category);


            //Check category slider dir is exists or not
            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }

            //resize image for category slider and upload it
            $slider = Image::make($image)->resize(500,333)->save();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);
        }else {
            $imagename = "default.png";
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->image = $imagename;
        $category->save();

        Toastr::success('Category Successfully Saved :)', 'Success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|mimes:jpeg, bmp, png, jpg',
        ]);

        //get image from form
        $image = $request->file('image');
        $slug = Str::slug($request->name);

        $category = Category::find($id);

        if (isset($image)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //Check category dir is exists or not
            if (!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }

            //delete old image from category directory
            if (Storage::disk('public')->exists('category/'.$category->image)){
                Storage::disk('public')->delete('category/'.$category->image);
            }

            //resize image for category and upload it
            $categoryimage = Image::make($image)->resize(1600,479)->save();
            Storage::disk('public')->put('category/'.$imagename,$categoryimage);


            //Check category slider dir is exists or not
            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }

            //delete old image from slider directory
            if (Storage::disk('public')->exists('category/slider/'.$category->image)){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }

            //resize image for category slider and upload it
            $slider = Image::make($image)->resize(500,333)->save();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);
        }else {
            $imagename = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();

        Toastr::success('Category Successfully Updated :)', 'Success');
        return redirect(route('admin.category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        //check category image exists or not
        if (Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }

        //check slider image exists or not
        if (Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }

        $category->delete();
        Toastr::success('Category Successfully Deleted :)', 'Success');

        return back();
    }
}
