<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ClinicSetting extends Model
{
    protected $table = 'clinic_settings';

    protected $fillable = ['key', 'value', 'type', 'group', 'description'];

    public $timestamps = true;

    // ─── Static helpers ───────────────────────────────────────

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return $default;
        return static::cast($setting->value, $setting->type);
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrInsert(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );
    }

    public static function group(string $group): \Illuminate\Support\Collection
    {
        return static::where('group', $group)->get()->mapWithKeys(
            fn($s) => [$s->key => static::cast($s->value, $s->type)]
        );
    }

    public static function allKeyed(): \Illuminate\Support\Collection
    {
        return static::all()->mapWithKeys(
            fn($s) => [$s->key => static::cast($s->value, $s->type)]
        );
    }

    private static function cast(mixed $value, string $type): mixed
    {
        return match ($type) {
            'integer' => (int)   $value,
            'boolean' => (bool)  (int) $value,
            'json'    => json_decode($value, true),
            default   => $value,
        };
    }
}
