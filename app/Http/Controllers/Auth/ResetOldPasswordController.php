<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ResetOldPasswordController extends Controller
{

    public function PasswordResetForm()
    {
            return view('auth.passwords.oldPasswordReset');
    }


    public function ResetPassword(Request $request)
    {
        $user_details = User::where('id', auth()->id())->pluck('password');
        $password_hash = Hash::check($request->old_password, $user_details[0]);

        if($password_hash){
            if($request->new_password == $request->confirm_password){
                $data['password'] = Hash::make(trim($request->confirm_password));
                User::where('id', auth()->id())->update($data);
                return redirect()->back()->with('message', 'Password has been updated successfully');
            }else{
                return redirect()->back()->with('message', 'Confirm Password does not match');
            }
        }else{
            return redirect()->back()->with('message', 'Old Password does not Exists');
        }
    }
}
