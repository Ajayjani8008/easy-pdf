<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseConverterController extends Controller
{
    /**
     * Get the conversion type (e.g., 'word', 'excel', 'powerpoint')
     */
    abstract protected function getConversionType(): string;

    /**
     * Get the tool name for display
     */
    abstract protected function getToolName(): string;

    /**
     * Get SEO data for the tool
     */
    protected function getSeoData(): array
    {
        $toolName = $this->getToolName();
        
        return [
            'title' => "{$toolName} | " . config('app.name'),
            'description' => "Free online {$toolName}. Convert your PDF files instantly. Fast, secure, and easy to use. No registration required.",
            'keywords' => strtolower($toolName) . ', convert pdf, online tool, free converter',
            'canonical' => url()->current(),
            'og_type' => 'website',
        ];
    }

    /**
     * Display the converter page
     */
    public function index()
    {
        $seo = $this->getSeoData();
        
        return view("tools.{$this->getConversionType()}", compact('seo'));
    }
}

