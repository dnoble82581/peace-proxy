<?php

namespace App\Listeners;

use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function __construct() {}

    public function handle(WebhookReceived $event): void {}
}
