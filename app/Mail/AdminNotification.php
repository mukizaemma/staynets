<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Generic details payload used by the registrationNotifications view.
     *
     * @var array<string,mixed>
     */
    public array $details;

    /**
     * Create a new message instance.
     *
     * @param  array<string,mixed>  $details
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->from('info@iremetech.com', 'Accommodation Booking Engine')
            ->subject($this->details['subject'] ?? 'New Update')
            ->view('emails.registrationNotifications')
            ->with(['details' => $this->details]);
    }
}





