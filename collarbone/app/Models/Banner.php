<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'image_path',
        'title',
        'subtitle',
        'text_color'
    ];

    /**
     * Get the formatted image URL.
     * Checks if it's an external URL or handles storage link.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('img/Wallpaper.jpeg'); // Default fallback
        }

        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }

        // Check if it's in storage or local public folder
        if (file_exists(public_path('storage/' . $this->image_path))) {
             return asset('storage/' . $this->image_path);
        }
        
        // Also check direct public path (e.g. 'img/...')
        return asset($this->image_path);
    }
}
