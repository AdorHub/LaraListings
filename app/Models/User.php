<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
		'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

	public function listings(): HasMany
	{
		return $this->hasMany(Listing::class);
	}

	public function isAdmin(): bool
	{
		return $this->role === 'admin';
	}

	public function scopeUserFilter($query, array $filters)
	{
		if ($filters['search'] ?? false) {
			$query->where(function ($q) use ($filters) {
				$q->where('name', 'like', '%' . $filters['search'] . '%')->orWhere('email', 'like', '%' . $filters['search'] . '%');
			});
		}
		if ($filters['user_role'] ?? false) {
			$query->where('role', $filters['user_role']);
		}
	}
}
