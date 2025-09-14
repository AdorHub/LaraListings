<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerifyController extends Controller
{
    public function notice()
	{
		return Inertia::render('Auth/VerifyEmail', [
			'status' => session('status')
		]);
	}

	public function verify(EmailVerificationRequest $request)
	{
		$request->fulfill();
		return redirect()->route('home');
	}

	public function resend(Request $request)
	{
		$request->user()->sendEmailVerificationNotification();
		return back()->with('status', 'Verification link sent!');
	}
}
