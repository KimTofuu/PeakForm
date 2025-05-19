<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressEntry extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'progress';
    // Fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'date_recorded',
        'weight',
        'body_fat_percentage',
        'muscle_mass',
    ];

    // Relationship: A progress entry belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
