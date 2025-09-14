<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PasswordConfirmController extends Controller
{
    public function create()
	{
		return Inertia::render('Auth/ConfirmPassword');
	}

	public function store(Request $request)
	{
		if (! Hash::check($request->password, $request->user()->password)) {
			return back()->withErrors(['password' => 'The provided password does not match our records']);
		}
		$request->session()->passwordConfirmed();
		return redirect()->intended();
	}
}
