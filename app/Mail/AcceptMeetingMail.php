<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptMeetingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $advisorName;
    public $programName;
    public $date;
    public $time;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($advisorName, $programName,$date,$time)
    {
        $this->advisorName = $advisorName;
        $this->programName = $programName;
        $this->date = $date;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('abeermosameh@gmail.com', 'Training hub')
            ->subject('Accept Meeting From '. $this->advisorName)
            ->view('emails.Accept_meeting')->with([
                'advisorName'=> $this->advisorName,
                'programName' => $this->programName,
                'date' => $this->date,
                'time' => $this->time,
            ]);


    }
}
