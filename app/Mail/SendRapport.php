<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendRapport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $rapport;
    public $vehicule;
    public $totalByMouvement;
    public $dataByMonth;
    public $totalByMonthYear;
    public $totalByMouvementstr;
    public function __construct($rapport,$vehicule,$totalByMouvement,$dataByMonth,$totalByMonthYear,$totalByMouvementstr)
    {
        $this->rapport = $rapport;
        $this->vehicule = $vehicule;
        $this->totalByMouvement = $totalByMouvement;
        $this->dataByMonth = $dataByMonth;
        $this->totalByMonthYear = $totalByMonthYear;
        $this->totalByMouvementstr = $totalByMouvementstr;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Rapport des versements par mois',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.index',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
