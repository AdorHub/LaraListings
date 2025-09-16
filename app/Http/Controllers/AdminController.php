<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
	{
		$users = User::with('listings')->userFilter(request(['search', 'user_role']))->latest()->paginate(8)->withQueryString()	;
		return Inertia::render('Admin/AdminDashboard', [
			'users' => $users,
			'status' => session('status')
		]);
	}

	public function show(User $user)
	{
		$listings = $user->listings()->listingFilter(request(['search', 'disapproved']))->latest()->paginate(8)->withQueryString();
		return Inertia::render('Admin/UserPage', [
			'user' => $user,
			'listings' => $listings,
			'status' => session('status')
		]);
	}

	public function role(User $user, Request $request)
	{
		Gate::authorize('modifyRole', $user);
	 	$request->validate([
			'role' => 'required|string|in:admin,general,suspended'
		]);
		$user->update([
			'role' => $request->role
		]);
		return redirect()->route('admin.index')->with('status', "Role updated successfully");
	}

	public function approve(Listing $listing)
	{
		Gate::authorize('approve', $listing);
		$listing->update([
			'approved' => !$listing->approved
		]);
		$action = $listing->approved ? 'Approved' : 'Disapproved';
		return back()->with('status', "Listing $action successfully");
	}
}
