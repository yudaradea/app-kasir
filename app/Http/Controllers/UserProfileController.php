<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index() {

        return view('pages.profile.index');
    }

    // Change user profile detail

    public function changeProfile(Request $request) {
        $id = Auth::user()->id;
        $user = User::find($id);

        $validateData = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,'.$id,
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'name.max' => 'nama maximal 50 karakter',
            'email.required' => 'email tidak boleh kosong',
            'email.email' => 'invalid email',
            'email.unique' => 'email sudah terdaftar'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success');

            return redirect()->back()->with($notification);
    }

     // update password method
     public function updatePassword(Request $request) {

        $validateData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',

        ],[
            'current_password.required' => 'current password tidak boleh kosong',
            'new_password.required' => 'new password tidak boleh kosong',
            'new_password.min' => 'password minimal 5 karakter',
            'confirm_password' => 'password tidak sama'
        ]);

        $hashedPassword = Auth::user()->password;


        if(Hash::check($request->current_password, $hashedPassword)) {
            $users = User::find(Auth::id());
            $users->password = ($request->new_password);
            $users->save();


            return redirect()->route('user-logout');
        } else {
            return redirect()->back()->with('password', 'error message')->withErrors('current password is not match!');

        }

    }//End

    // Logout for afte reset password
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', "Update password successfuly!, Silakan Login kembali");

    }

     // change profile picture
     public function changeProfilePicture(Request $request){
        $id = Auth::user()->id;
        $user = User::find($id);
        $path = "uploads/user_images/";
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $new_filename = 'AIMG'.'_'.$user->name.time().'.png';



        $upload = $file->move($path,$new_filename);

        if($upload){
            $old_image = $user->getAttributes()['foto'];
            $nama_old_image = $path.$old_image;
            if(!empty($old_image)){
                unlink($nama_old_image);
            }

           $user->update([
                'foto' => $new_filename
            ]);
            return response()->json(['status'=>1, 'msg'=>'Profile Picture berhasil diganti']);
        }else {
            return response()->json(['status'=>0, 'msg'=>'Gagal mengganti profile picture']);
        }
    }
}
