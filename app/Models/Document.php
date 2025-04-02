<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'courrier_id',
        'file_name',
        'file_path',
    ];

    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }
}
