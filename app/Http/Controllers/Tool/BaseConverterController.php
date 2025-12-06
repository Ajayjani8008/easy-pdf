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
     * Override this method in child classes for custom SEO
     */
    protected function getSeoData(): array
    {
        $toolName = $this->getToolName();
        $shortBenefit = $this->getShortBenefit();
        $brandName = config('app.name', 'EasyPDF');
        
        return [
            'title' => "{$toolName} | Free Online {$shortBenefit} | {$brandName}",
            'description' => $this->getMetaDescription(),
            'keywords' => $this->getKeywords(),
            'canonical' => url()->current(),
            'og_type' => 'website',
        ];
    }

    /**
     * Get short benefit for SEO title (e.g., "DOCX Converter", "PDF Merger")
     * 
     * IMPORTANT: Override this in EVERY child controller for unique SEO titles
     * Each tool should have its own short benefit description
     */
    protected function getShortBenefit(): string
    {
        // Default fallback - should be overridden in child classes
        return $this->getToolName();
    }

    /**
     * Get meta description (150-160 characters)
     * 
     * IMPORTANT: Override this in EVERY child controller for unique descriptions
     * Each tool must have its own unique meta description for better SEO
     */
    protected function getMetaDescription(): string
    {
        // Default fallback - should be overridden in child classes
        $toolName = $this->getToolName();
        return "Free online {$toolName}. Fast, secure, and easy to use. No registration required. 100% free PDF tool.";
    }

    /**
     * Get keywords for SEO
     * 
     * IMPORTANT: Override this in EVERY child controller for unique keywords
     * Each tool should have its own set of relevant keywords
     */
    protected function getKeywords(): string
    {
        // Default fallback - should be overridden in child classes
        $toolName = strtolower($this->getToolName());
        return "{$toolName}, free {$toolName}, online {$toolName}, pdf tool, pdf converter, free pdf tool";
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

