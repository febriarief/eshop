<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/admin');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $input = $request->only(['email', 'password']);
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required'
        ];

        $errorMessages = [
            'email.required'    => 'Kolom isian email tidak boleh kosong',
            'email.email'       => 'Kolom isian email harus berupa email',
            'password.required' => 'Kolom isian password tidak boleh kosong'
        ];

        $validator = Validator::make($input, $rules, $errorMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $validator->errors()->first()])->withInput($request->input());
        }

        if (!Auth::Attempt($input)) {
            return redirect()->back()->withErrors(['msg' => 'Kombinasi email dan password tidak cocok.'])->withInput($request->input());
        }

        return redirect('/admin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
