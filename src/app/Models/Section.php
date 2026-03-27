<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['name'];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon_class',
        'display_order',
    ];

    protected $casts = [
        'name' => 'array',
        'display_order' => 'integer',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    /**
     * Get the members for the section.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
    
    /**
     * Get all images for the section.
     */
    public function images(): HasMany
    {
        return $this->hasMany(SectionImage::class)->orderBy('display_order', 'asc');
    }
}
