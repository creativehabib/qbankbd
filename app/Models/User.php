<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'xp', 'password', 'registration_role', 'institution_name', 'institution_type', 'institution_address', 'academic_class_id', 'department', 'is_active'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    protected string $guard_name = 'web';

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

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    public function isJobSeeker(): bool
    {
        return $this->hasRole('job_seeker');
    }

    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function hasAccessToModelTest(ModelTest $test): bool
    {
        if (! $test->is_premium && ! $test->package_id) {
            return true;
        }

        // Admin/Super Admin bypass
        if ($this->isAdmin()) {
            return true;
        }

        if ($test->package_id) {
            // Requires specific course package
            return $this->subscriptions()
                ->where('package_id', $test->package_id)
                ->where('status', 'active')
                ->where('expires_at', '>', now())
                ->exists();
        }

        if ($test->is_premium) {
            // Requires any active 'subscription' type package
            return $this->subscriptions()
                ->whereHas('package', function ($q) {
                    $q->where('type', 'subscription');
                })
                ->where('status', 'active')
                ->where('expires_at', '>', now())
                ->exists();
        }

        return false;
    }

    public function hasPermission(string $permissionSlug): bool
    {
        return $this->can($permissionSlug);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(UserSubscription::class)->where('status', 'active')->latestOfMany();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->whereHas('package', function ($q) {
                $q->where('type', 'subscription');
            })
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->exists();
    }

    public function hasActivePackage($packageId): bool
    {
        return $this->subscriptions()
            ->where('package_id', $packageId)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->exists();
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    public function mockTests()
    {
        return $this->hasMany(MockTest::class);
    }

    public function getLeagueNameAttribute(): string
    {
        if ($this->xp >= 5000) {
            return 'Gold League';
        }
        if ($this->xp >= 2000) {
            return 'Silver League';
        }

        return 'Bronze League';
    }

    public function getLeagueIconAttribute(): string
    {
        if ($this->xp >= 5000) {
            return 'text-yellow-500';
        } // Gold color
        if ($this->xp >= 2000) {
            return 'text-gray-400';
        } // Silver color

        return 'text-amber-600';
    }
}
