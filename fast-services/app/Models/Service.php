<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Rating;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    public $primaryKey = 'id';

    public function rating() {
        return $this->hasMany(Rating::class);
    }

    protected $fillable = [
        'name',
    ];
}
