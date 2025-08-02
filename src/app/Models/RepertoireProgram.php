<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepertoireProgram extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repertoire_programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'year_id',
        'title',
        'subtitle',
        'description',
        'display_order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the year that the program belongs to.
     */
    public function year(): BelongsTo
    {
        return $this->belongsTo(RepertoireYear::class, 'year_id');
    }

    /**
     * Get the pieces for the repertoire program.
     */
    public function pieces(): HasMany
    {
        return $this->hasMany(RepertoirePiece::class, 'program_id');
    }
}
