<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function create()
	{
		return Inertia::render('Auth/Register');
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|max:255|min:3',
			'email' => 'required|email|lowercase|max:255',
			'password' => 'required|confirmed|min:6|max:255'
		]);
		$user = User::create($data);
		event(new Registered($user));
		return Inertia::render('Auth/Login');
	}
}
