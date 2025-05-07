<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Courrier;

class CourrierAffecte extends Mailable
{
    use Queueable, SerializesModels;

    public $courrier;

    /**
     * Create a new message instance.
     */
    public function __construct(Courrier $courrier)
    {
        $this->courrier = $courrier;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('📩 Nouveau Courrier Affecté')
                    ->view('emails.courrier_affecte')
                    ->with([
                        'reference' => $this->courrier->reference,
                        'objet' => $this->courrier->objet,
                        'contenu' => $this->courrier->contenu,
                        'date_reception' => $this->courrier->date_reception,
                    ]);
    }
}
