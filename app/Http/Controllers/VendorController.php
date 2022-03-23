<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $vendor = Vendor::create($data);
        Auth::guard('vendor')->login($vendor);
        return redirect()->route('vendor.home');
    }

    public function login(Request $request)
    {
       $credentials = $request->only('email', 'password');
        if(Auth::guard('vendor')->attempt($credentials))
        {
            return redirect()->intended('vendor/home');

        }
        return redirect()->back()->withInput($request->only('email'));

    }

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login.show');
    }
}
