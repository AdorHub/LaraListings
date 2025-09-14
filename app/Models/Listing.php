<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

	protected $fillable = [
		'title',
		'desc',
		'tags',
		'email',
		'link',
		'image',
		'approved'
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function scopeListingFilter($query, array $filters)
	{
		if ($filters['search'] ?? false) {
			$query->where(function ($q) use ($filters) {
				$q->where('title', 'like', '%' . $filters['search'] . '%')->orWhere('desc', 'like', '%' . $filters['search'] . '%');
			});
		}
		if ($filters['userId'] ?? false) {
			$query->where('user_id', $filters['userId']);
		}
		if ($filters['tag'] ?? false) {
			$query->where('tags', 'like', '%' . $filters['tag'] . '%');
		}
	}
}
