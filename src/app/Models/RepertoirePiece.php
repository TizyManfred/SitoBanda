<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepertoirePiece extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repertoire_pieces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'repertoire_program_id',
        'title',
        'composer',
        'arranger',
        'display_order',
    ];

    /**
     * Get the program that this piece belongs to.
     */
    public function program()
    {
        return $this->belongsTo(RepertoireProgram::class, 'repertoire_program_id');
    }

    /**
     * Scope a query to order by the display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }
}
