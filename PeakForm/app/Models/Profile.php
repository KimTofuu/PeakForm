<?php

// app/Models/Profile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Profile extends Model
{
    use HasFactory;


    protected $table = 'profiles';
    protected $fillable = ['user_id', 'Fname', 'Lname', 'age', 'gender', 'weight'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

