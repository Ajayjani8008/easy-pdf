<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacyPolicy()
    {
        return view('pages.privacy-policy', [
            'title' => 'Privacy Policy',
            'description' => 'Learn how we protect your privacy and handle your data at EasyPDF Pro.'
        ]);
    }

    public function termsConditions()
    {
        return view('pages.terms-conditions', [
            'title' => 'Terms & Conditions',
            'description' => 'Read our terms of service and conditions for using EasyPDF Pro.'
        ]);
    }

    public function help()
    {
        return view('pages.help', [
            'title' => 'Help Center',
            'description' => 'Find answers to common questions and get help with EasyPDF Pro.'
        ]);
    }

    public function blog()
    {
        return view('pages.blog', [
            'title' => 'Blog',
            'description' => 'Latest news, tips, and updates from EasyPDF Pro.'
        ]);
    }

    public function developers()
    {
        return view('pages.developers', [
            'title' => 'Developers',
            'description' => 'API documentation and resources for developers.'
        ]);
    }

    public function pricing()
    {
        return view('pages.pricing', [
            'title' => 'Pricing',
            'description' => 'Choose the perfect plan for your PDF needs.'
        ]);
    }

    public function features()
    {
        return view('pages.features', [
            'title' => 'Features',
            'description' => 'Discover all the powerful features of EasyPDF Pro.'
        ]);
    }

    public function security()
    {
        return view('pages.security', [
            'title' => 'Security',
            'description' => 'Learn about our security measures and data protection.'
        ]);
    }

    public function careers()
    {
        return view('pages.careers', [
            'title' => 'Careers',
            'description' => 'Join our team and help us make PDFs easier for everyone.'
        ]);
    }

    public function press()
    {
        return view('pages.press', [
            'title' => 'Press',
            'description' => 'Press releases and media resources for EasyPDF Pro.'
        ]);
    }
}