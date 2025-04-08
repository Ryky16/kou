<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'responsable_id',
        'email',
        'telephone'
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}