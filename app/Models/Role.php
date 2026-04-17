<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    // Helpers
    public static function admin(): self   { return self::where('name', 'admin')->firstOrFail(); }
    public static function doctor(): self  { return self::where('name', 'doctor')->firstOrFail(); }
    public static function staff(): self   { return self::where('name', 'staff')->firstOrFail(); }
    public static function patient(): self { return self::where('name', 'patient')->firstOrFail(); }
}
