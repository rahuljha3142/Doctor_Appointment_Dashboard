<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function DocLogin(Request $request){
        // dd($request->all());
        // $valid = $this->rules($request->all());
        // if($valid->fails()){
        //     return redirect()->back();
        // }
        // else{
            $email = $request->get('email');
            $password = $request->get('password');
            if(Auth::attempt(['email'=>$email, 'password'=>$password])){
                return redirect()->intended('/doctor/dashboard');
            }
            else{
                return redirect()->back();
            }
            // $users->save();
        // }
    }

    public function rules($data){
        $messages = [
            'email-required' => 'Please enter your email address',
            'email-exists' => 'Email already Exists',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be atleast 6 characters'
        ];

        $valid = validator::make($data,[
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ], $messages);
    }

    public function savedoc(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|min:6',
            'password_confirmation' => 'sometimes|required_with:password'
        ]);

        $users = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'user_type' => 'doctor',
            'spl' => $request->get('spl')
        ]);
        $users->save();

        return redirect()->intended('/doctor/dashboard');
    }
}
