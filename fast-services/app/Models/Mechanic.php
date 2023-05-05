<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Rating;

class Mechanic extends Model
{
    use HasFactory;

    protected $table = 'mechanics';

    public $primaryKey = 'id';

    public function rating() {
        return $this->hasMany(Rating::class);
    }

    protected $fillable = [
        'name',
        'phone_number',
        'years_of_experience',
        'email'
    ];
}
