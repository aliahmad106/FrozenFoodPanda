<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class ContactController extends Controller
{
    public function index()
    {
        Log::info('Contact page viewed');
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        Log::info('Contact form submission started', [
            'request_data' => $request->except(['privacy_policy'])
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy_policy' => 'required',
        ]);

        Log::info('Contact form validation passed');

        try {
            // Admin email address
            $adminEmail = 'frozenfoodpanda347@gmail.com';
            
            // Log mail configuration
            Log::info('Current mail configuration', [
                'driver' => Config::get('mail.default'),
                'host' => Config::get('mail.mailers.smtp.host'),
                'port' => Config::get('mail.mailers.smtp.port'),
                'from_address' => Config::get('mail.from.address'),
                'from_name' => Config::get('mail.from.name')
            ]);
            
            Log::info('Preparing to send admin notification email', [
                'to_email' => $adminEmail,
                'from_email' => $request->email,
                'from_name' => $request->name,
                'subject' => 'Contact Form: ' . $request->subject
            ]);

            // Send notification to admin (frozenfoodpanda347@gmail.com)
            try {
                Mail::send('emails.contact', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'subject' => $request->subject,
                    'userMessage' => $request->message,
                    'ip' => $request->ip(),
                    'userAgent' => $request->header('User-Agent'),
                    'time' => now()->format('M d, Y, h:i A')
                ], function($message) use ($request, $adminEmail) {
                    Log::info('Setting up admin email message');
                    
                    $message->to($adminEmail)
                           ->subject('Contact Form: ' . $request->subject);
                    
                    // Use replyTo instead of from to avoid potential email validation issues
                    $message->replyTo($request->email, $request->name);
                    
                    Log::info('Admin notification email configured', [
                        'to' => $adminEmail,
                        'reply_to' => $request->email,
                        'subject' => 'Contact Form: ' . $request->subject
                    ]);
                });
                
                Log::info('Admin notification email sent successfully');
            } catch (\Exception $e) {
                Log::error('Failed to send admin notification email', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e; // Re-throw to be caught by the outer try-catch
            }

            Log::info('Preparing to send confirmation email to user', [
                'to_email' => $request->email,
                'to_name' => $request->name,
                'from_email' => $adminEmail,
                'subject' => 'We received your message - FrozenFoodPanda'
            ]);

            // Send confirmation email to the user from admin email
            try {
                Mail::send('emails.contact-confirmation', [
                    'name' => $request->name,
                    'subject' => $request->subject,
                ], function($message) use ($request, $adminEmail) {
                    Log::info('Setting up user confirmation email message');
                    
                    $message->to($request->email, $request->name)
                           ->subject('We received your message - FrozenFoodPanda');
                    
                    // Use default from address which should be configured as frozenfoodpanda347@gmail.com
                    // in the .env file or mail config
                    
                    Log::info('User confirmation email configured', [
                        'to' => $request->email,
                        'using_default_from' => true,
                        'subject' => 'We received your message - FrozenFoodPanda'
                    ]);
                });
                
                Log::info('User confirmation email sent successfully');
            } catch (\Exception $e) {
                Log::error('Failed to send user confirmation email', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Continue execution even if confirmation email fails
            }

            Log::info('Contact form submission completed successfully', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'admin_email' => $adminEmail
            ]);

            return redirect()->route('contact.index')->with('success', 'Your message has been sent successfully! We will get back to you soon.');
        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('contact.index')->with('error', 'Sorry, there was a problem sending your message. Please try again later. Error: ' . $e->getMessage());
        }
    }
}