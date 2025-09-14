<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Middleware\IsSuspendedMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListingController extends Controller implements HasMiddleware
{
	public static function middleware(): array
	{
		return [
			new Middleware(
				['auth', 'verified', IsSuspendedMiddleware::class], except: ['index', 'show']
			),
		];
	}

    public function index(Request $request)
    {
		$listings = Listing::whereHas('user', function (Builder $query) {
			$query->where('role', '!=', 'suspended');
		})
		->with('user')
		->where('approved', true)
		->listingFilter(request(['search', 'userId', 'tag']))
		->latest()
		->paginate(8)
		->withQueryString();
		return Inertia::render('Home', [
			'listings' => $listings,
			'searchTerm' => request('search')
		]);
    }

    public function create()
    {
		Gate::authorize('create', Listing::class);
        return Inertia::render('Listing/Create');
    }

    public function store(Request $request)
    {
		Gate::authorize('create', Listing::class);
        $data = $request->validate([
			'title' => 'required|max:255',
			'desc' => 'required',
			'tags' => 'nullable|string',
			'email' => 'nullable|email',
			'link' => 'nullable|url',
			'image' => 'nullable|file|max:3072|mimes:jpeg,jpg,png'
		]);
		if ($request->hasFile('image')) {
			$data['image'] = Storage::disk('public')->put('images/listing', $request->image);
		}
		$data['tags'] = str_replace(' ', '', implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags))))));
		$request->user()->listings()->create($data);
		return redirect()->route('dashboard')->with('status', 'Listing created successfully');
    }

    public function show(Listing $listing)
    {
		Gate::authorize('view', $listing);
        return Inertia::render('Listing/Show', [
			'listing' => $listing,
			'user' => $listing->user->only('id', 'name'),
			'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : false
		]);
    }

    public function edit(Listing $listing)
    {
		Gate::authorize('modify', $listing);
        return Inertia::render('Listing/Edit', [
			'listing' => $listing
		]);
    }

    public function update(Request $request, Listing $listing)
    {
		Gate::authorize('modify', $listing);
		$data = $request->validate([
			'title' => 'required|max:255',
			'desc' => 'required',
			'tags' => 'nullable|string',
			'email' => 'nullable|email',
			'link' => 'nullable|url',
			'image' => 'nullable|file|max:3072|mimes:jpeg,jpg,png'
		]);
		if ($request->hasFile('image')) {
			if ($listing->image) {
				Storage::disk('public')->delete($listing->image);
			}
			$data['image'] = Storage::disk('public')->put('images/listing', $request->image);
		} else {
			$data['image'] = $listing->image;
		}
		$data['tags'] = str_replace(' ', '', implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags))))));
		$listing->update([
			...$data,
			'approved' => false
		]);
		return redirect()->route('dashboard')->with('status', 'Listing updated successfully');
    }

    public function destroy(Listing $listing)
    {
		Gate::authorize('modify', $listing);
		if ($listing->image) {
			Storage::disk('public')->delete($listing->image);
		}
        $listing->delete();
		return redirect()->route('dashboard')->with('status', 'Listing deleted successfully');
    }
}
