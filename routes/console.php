<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('invoice:status', function () {
    $this->info('Updating invoices status');
});

Artisan::command('invoice:generate', function () {
    $this->info('Generating scheduled invoice(s)');
});

Artisan::command('invoice:send {invoice_id}', function ($invoice_id) {
    $this->info('Sending invoice');
});

Artisan::command('invoice:notify', function () {
    $this->info('Notify invoices');
});