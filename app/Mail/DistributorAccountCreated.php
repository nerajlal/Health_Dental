<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DistributorAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $distributor;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $distributor, $password)
    {
        $this->distributor = $distributor;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to Dental Supply Management System')
                    ->view('emails.distributor_account_created');
    }
}
