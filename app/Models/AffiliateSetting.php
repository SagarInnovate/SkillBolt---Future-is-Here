<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateSetting extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
        'description',
        'type',
    ];
    
    /**
     * Get the typed value of the setting.
     */
    public function getTypedValueAttribute()
    {
        return match ($this->type) {
            'number' => (float) $this->value,
            'boolean' => $this->value === 'true',
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
    
    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        return $setting->typed_value;
    }
    
    /**
     * Set a setting value by key.
     */
    public static function set(string $key, $value, string $type = null): void
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return;
        }
        
        // Convert value to string based on type
        if ($type === 'json' || ($setting->type === 'json' && $type === null)) {
            $value = json_encode($value);
        } elseif (is_bool($value) || ($setting->type === 'boolean' && $type === null)) {
            $value = $value ? 'true' : 'false';
        } else {
            $value = (string) $value;
        }
        
        $setting->value = $value;
        
        if ($type) {
            $setting->type = $type;
        }
        
        $setting->save();
    }
}

