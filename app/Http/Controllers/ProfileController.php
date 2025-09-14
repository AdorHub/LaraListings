<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
	{
		return Inertia::render('Profile/Edit', [
			'user' => $request->user(),
			'status' => session('status')
		]);
	}

	public function updateInfo(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|max:255|min:3',
			'email' => 'required|email|lowercase|max:255|' . Rule::unique(User::class)->ignore($request->user()->id)
		]);
		$request->user()->fill($data);
		if ($request->user()->isDirty('email')) {
			$request->user()->email_verified_at = null;
		}
		$request->user()->save();
		return redirect()->route('profile.edit')->with('status', 'Verification link sent!');
	}

	public function updatePassword(Request $request)
	{
		$data = $request->validate([
			'current_password' => 'required|current_password',
			'password' => 'required|min:6|max:255|confirmed'
		]);
		$request->user()->update([
			'password' => Hash::make($data['password'])
		]);
		return redirect()->route('profile.edit');
	}

	public function deleteAccount(Request $request)
	{
		$request->validate([
			'password' => 'required|current_password'
		]);
		$request->user()->delete();
		$request->session()->invalidate();
		$request->session->regenerateToken();
		return redirect()->route('home');
	}
}
