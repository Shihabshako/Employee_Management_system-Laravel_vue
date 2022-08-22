<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformAdministration extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $status;
    public $applicationId;
    public $applicantName;
    public function __construct($applicantName, $status, $applicationId)
    {
        $this->status = $status;
        $this->applicationId = $applicationId;
        $this->applicantName = $applicantName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this
            ->subject("One application to review")
            ->view('mail', [
                "applicantName" => $this->applicantName,
                "status" => $this->status,
                "link" => "http://127.0.0.1:8000/application-details/" . $this->applicationId,
            ]);
    }
}
