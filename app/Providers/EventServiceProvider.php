<?php

namespace App\Providers;

use App\Events\Tasks\Activated;
use App\Events\Tasks\BeforeActivate;
use App\Events\Tasks\BeforeComplete;
use App\Events\Tasks\BeforeFail;
use App\Events\Tasks\BeforeSkip;
use App\Events\Tasks\BeforeUpdate;
use App\Events\Tasks\Completed;
use App\Events\Tasks\Delegated;
use App\Events\Tasks\Failed;
use App\Events\Tasks\Skipped;
use App\Events\Tasks\ExecutorsChanged;
use App\Events\Tasks\Updated;
use App\Events\UserRegistered;
use App\Listeners\SendRegistrationNotification;
use App\Listeners\SendTaskActivatedNotification;
use App\Listeners\Tasks\CheckHandlers;
use App\Listeners\Tasks\CreateSnapshot;
use App\Listeners\Tasks\GenerateDocuments;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
		UserRegistered::class => [
			SendRegistrationNotification::class
		],

		// Tasks
		BeforeActivate::class => [
			CheckHandlers::class
		],
		Activated::class => [
			SendTaskActivatedNotification::class,
			CheckHandlers::class
		],
		BeforeUpdate::class => [
			CheckHandlers::class
		],
		Updated::class => [
			GenerateDocuments::class,
			CheckHandlers::class
		],
		BeforeComplete::class => [
			CheckHandlers::class
		],
		Completed::class => [
			GenerateDocuments::class,
			CheckHandlers::class
		],
		BeforeFail::class => [
			CheckHandlers::class
		],
		Failed::class => [
			CheckHandlers::class
		],
		BeforeSkip::class => [
			CheckHandlers::class
		],
		Skipped::class => [
			CheckHandlers::class
		],
        Delegated::class => [

        ],
        ExecutorsChanged::class => [

        ]
    ];

    public function boot() {
        parent::boot();
    }
}
