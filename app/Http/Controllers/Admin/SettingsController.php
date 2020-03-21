<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function updateProfile(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|image|max:3096',

        ], [
            'image.max' => "Maximum file size to upload is 3MB (3096 KB). If you are uploading a photo, try to reduce its resolution to make it under 3MB"
        ]);

        $image = $request->file('image');
        $slug = Str::slug($request->name);
        $user = User::findOrFail(Auth::id());

        if (isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('profile')){
                Storage::disk('public')->makeDirectory('profile');
            }

            //delete old image from slider directory
            if (Storage::disk('public')->exists('profile/'.$user->image)){
                Storage::disk('public')->delete('profile/'.$user->image);
            }

            $profile = Image::make($image)->resize(500,500)->save();
            Storage::disk('public')->put('profile/'.$imagename,$profile);
        }else {
            $imagename = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imagename;
        $user->about = $request->about;
        $user->save();

        Toastr::success('Profile Successfully Updated :)', 'Success');

        return back();
    }


    public function updatePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->getAuthPassword();
        if (Hash::check($request->old_password, $hashedPassword)){
            if (!Hash::check($request->password, $hashedPassword)){
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();


                Auth::logout();
                Toastr::success('Password Successfully Changed', 'Success');
                return back();
            }else {
                Toastr::error('New password can\'t be the same as old password !', 'Error');
                return back();
            }
        }else {
            Toastr::error('Current password does not matched !', 'Error');
            return back();
        }
    }
}
