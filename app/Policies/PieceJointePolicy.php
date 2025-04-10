<?php

namespace App\Policies;

use App\Models\PieceJointe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PieceJointePolicy
{
    public function view(User $user, PieceJointe $piece)
    {
        return $user->id === $piece->courrier->created_by
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette pièce jointe.');
    }

    public function download(User $user, PieceJointe $piece)
    {
        return $this->view($user, $piece);
    }
}
