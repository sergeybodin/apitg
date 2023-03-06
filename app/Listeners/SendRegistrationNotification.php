<?php

namespace App\Listeners;

use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;

class SendRegistrationNotification {
    public function __construct() {
    }

    public function handle(object $event) {
		try {
			Mail::to($event->user->email)->send(new UserRegistered($event->user, $event->password));
		} catch (\Exception $exception) {}
    }
}
