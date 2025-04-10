<?php

namespace App\Providers;

use App\Models\PieceJointe;
use App\Policies\PieceJointePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PieceJointe::class => PieceJointePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}