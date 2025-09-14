<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Inertia\Inertia;

class PasswordResetController extends Controller
{
    public function sendIndex()
	{
		return Inertia::render('Auth/ForgotPassword', [
			'status' => session('status')
		]);
	}

	public function send(Request $request)
	{
		$request->validate([
			'email' => 'required|email|lowercase|max:255'
		]);
		$status = Password::sendResetLink($request->only('email'));
		return $status === Password::ResetLinkSent
			? back()->with(['status' => __($status)])
			: back()->withErrors(['email' => __($status)]);
	}

	public function resetIndex(Request $request)
	{
		return Inertia::render('Auth/ResetPassword', [
			'token' => $request->route('token'),
			'email' => $request->email
		]);
	}

	public function reset(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email|lowercase|max:255',
			'password' => 'required|min:6|max:255|confirmed',
		]);
		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function (User $user, string $password) {
				$user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
				$user->save();
				event(new PasswordReset($user));
			}
		);
		return $status === Password::PasswordReset
			? redirect()->route('login')->with('status', __($status))
			: back()->withErrors(['email' => [__($status)]]);
	}
}
