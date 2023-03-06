<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    public User $user;
    public string $password;

    public function __construct(User $user, string $password) {
    	$this->user = $user;
    	$this->password = $password;
    }

    public function build() {
        return $this->subject('Данные для входа в систему')->view('mail.user.registered');
    }
}
