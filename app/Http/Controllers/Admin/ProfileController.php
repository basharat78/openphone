<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest as RequestsProfileUpdateRequest;
use App\Models\User;
use Auth;
use Illuminate\View\View;
use flash;

class ProfileController extends Controller
{

    use FileUploadTrait;

    public function index(){
     
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));

    }

    public function update(RequestsProfileUpdateRequest $request ) : RedirectResponse { //ProfileUpdateRequest $request , string $id for what user


        $avatarPath = $this->uploadImage($request, 'avatar' ,$request->old_avatar); //uploadImage is a function in FileUploadTrait


        $user = Auth::user();//User::find($id);
        $user->avatar = !empty($avatarPath) ? $avatarPath : $request->old_avatar;//if the avatarPath is not empty then use the avatarPath else use the old_avatar
        $user->name = $request->name;//if the name is not empty then use the name
        $user->email = $request->email;
    

        $user->save();

        // toastr()->success('Updated Successfully!');//this is a package for notification

    flash('Data saved successfully!')->success();
        return redirect()->back();


            
    }
function  PasswordUpdate(Request $request) : RedirectResponse { //redirdectResponse is a return type for redirecting to the same page
    $request->validate([
        'password' => 'required|confirmed|min:8',
    ]);

    $user = Auth::user();
    $user->password = bcrypt($request->password);
    $user->save();

    // toastr()->success('Updated Successfully!');//this is a package for notification

    return redirect()->back();
}
}