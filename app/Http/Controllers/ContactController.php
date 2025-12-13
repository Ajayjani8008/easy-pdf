<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Save the contact message to database
            $contactMessage = ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
            ]);

            // Prepare data for email
            $contactData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'submitted_at' => $contactMessage->created_at,
                'ip_address' => $request->ip(),
            ];

            // Log the contact submission
            Log::info('Contact form submission', $contactData);

            // Send email notification (optional - configure mail settings in .env)
            try {
                Mail::send('emails.contact', $contactData, function ($message) use ($validated) {
                    $message->to(config('mail.admin_email', 'admin@example.com'))
                            ->subject('New Contact Form Submission: ' . $validated['subject'])
                            ->replyTo($validated['email'], $validated['name']);
                });
            } catch (\Exception $e) {
                Log::warning('Failed to send contact email: ' . $e->getMessage());
            }

            // Return success response
            return redirect()->route('pages.contact')
                           ->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            
            return redirect()->route('pages.contact')
                           ->with('error', 'Sorry, there was an error sending your message. Please try again.')
                           ->withInput();
        }
    }
}