<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectBasedOnRole($request->user());
    }

    /**
     * Rediriger l'utilisateur en fonction de son rôle.
     */
    protected function redirectBasedOnRole($user): RedirectResponse
    {
        switch ($user->role->name) {
            case 'Administrateur':
                return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
            case 'Secretaire_Municipal':
                return redirect()->intended(route('secretaire.dashboard', absolute: false).'?verified=1');
            case 'Agent':
                return redirect()->intended(route('agent.dashboard', absolute: false).'?verified=1');
            default:
                return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }
    }
}