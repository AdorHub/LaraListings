<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
	{
		return Inertia::render('Auth/Login');
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'email' => 'required|email|lowercase|max:255',
			'password' => 'required|min:6|max:255'
		]);
		if (Auth::attempt($data, $request->remember)) {
			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		} else {
			return back()->withErrors(['password' => 'Email or Password is wrong'])->onlyInput('email');
		}
	}

	public function destroy(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('home');
	}
}
