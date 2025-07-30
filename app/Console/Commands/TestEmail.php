<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class TestEmail extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $this->info('Attempting to send test email...');
        
        try {
            Mail::raw('Test email from Laravel app', function($message) {
                $message->to('aliahmadk106@gmail.com')
                        ->subject('Test Email')
                        ->from(env('MAIL_FROM_ADDRESS'), 'Frozen Food Panda');
            });
            
            $this->info('Test email sent successfully!');
        } catch (\Exception $e) {
            $this->error('Error sending email: ' . $e->getMessage());
        }
    }
}