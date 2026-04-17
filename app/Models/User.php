<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUlids, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
        'phone', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'is_active'         => 'boolean',
            'password'          => 'hashed',
        ];
    }

    // ─── Relationships ────────────────────────────────────────

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withPivot('granted');
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    public function doctorProfile(): HasOne
    {
        return $this->hasOne(DoctorProfile::class);
    }

    // ─── Role helpers ─────────────────────────────────────────

    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    public function isAdmin(): bool   { return $this->hasRole('admin'); }
    public function isDoctor(): bool  { return $this->hasRole('doctor'); }
    public function isStaff(): bool   { return $this->hasRole('staff'); }
    public function isPatient(): bool { return $this->hasRole('patient'); }

    // ─── Permission check ─────────────────────────────────────

    public function can($abilities, $arguments = []): bool
    {
        if (is_string($abilities)) {
            // Check explicit user override first
            $override = $this->permissions->firstWhere('name', $abilities);
            if ($override) {
                return (bool) $override->pivot->granted;
            }
            // Then check role permissions
            foreach ($this->roles as $role) {
                if ($role->permissions->contains('name', $abilities)) {
                    return true;
                }
            }
            // Admin bypasses everything
            if ($this->isAdmin()) {
                return true;
            }
            return false;
        }
        return parent::can($abilities, $arguments);
    }

    // ─── Dashboard redirect ───────────────────────────────────

    public function dashboardRoute(): string
    {
        return match (true) {
            $this->isAdmin()   => route('admin.dashboard'),
            $this->isDoctor()  => route('doctor.dashboard'),
            $this->isStaff()   => route('staff.dashboard'),
            $this->isPatient() => route('patient.dashboard'),
            default            => route('home'),
        };
    }

    // ─── Avatar URL ───────────────────────────────────────────

    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        $initials = urlencode(substr($this->name, 0, 1));
        return "https://ui-avatars.com/api/?name={$initials}&background=1e7eec&color=fff&size=128";
    }
}
