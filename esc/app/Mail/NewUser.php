<?php

namespace App\Mail;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data =$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $user = new User;
        // $lastID = $user->getLastID();
        // $userDetails = $user->getData('id', $lastID);
        return $this->view('emails.newUser')->with('data', $this->data);
        // ->with([
        //     'email' =>$userDetails->email,
        //     'tempPassword' =>$userDetails->password
        // ]);
    }
}
