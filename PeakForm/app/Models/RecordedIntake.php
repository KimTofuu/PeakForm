<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecordedIntake extends Model
{
    use HasFactory;

    protected $table = 'recorded_intakes'; // Optional if the table name matches Laravel's convention

    protected $fillable = [
        'user_id',
        'date',
        'protein',
        'carbs',
        'fat',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Optional: Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
