<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourrierLog extends Model
{
    use HasFactory;

    protected $fillable = ['courrier_id', 'user_id', 'agent_id', 'action'];

    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
