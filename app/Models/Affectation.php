<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'courrier_id',
        'user_id',
        'service_id',
        'statut',
    ];

    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
