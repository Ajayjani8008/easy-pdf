<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlaceholderController extends Controller
{
    public function pdfToPowerpoint()
    {
        return view('tools.placeholder', [
            'title' => 'PDF to PowerPoint',
            'description' => 'Convert your PDF files into easy to edit PPT and PPTX slideshows.',
            'icon' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF922B" />
                        <path d="M14 16H22V24H14V16Z" fill="white" />
                        <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                      </svg>',
            'features' => [
                [
                    'title' => 'High Quality Conversion',
                    'description' => 'Maintain formatting and layout when converting PDF to PowerPoint.',
                    'color' => '#FF922B'
                ],
                [
                    'title' => 'Editable Slides',
                    'description' => 'Get fully editable PPT files that you can modify and present.',
                    'color' => '#4DABF7'
                ],
                [
                    'title' => 'Fast Processing',
                    'description' => 'Quick conversion with our optimized processing engine.',
                    'color' => '#51CF66'
                ],
                [
                    'title' => 'Secure & Private',
                    'description' => 'Your files are processed securely and deleted automatically.',
                    'color' => '#F06595'
                ]
            ]
        ]);
    }

    public function powerpointToPdf()
    {
        return view('tools.placeholder', [
            'title' => 'PowerPoint to PDF',
            'description' => 'Make PPT and PPTX slideshows easy to view by converting them to PDF.',
            'icon' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFA94D" />
                        <path d="M34 16H26V24H34V16Z" fill="white" />
                        <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                      </svg>',
            'features' => [
                [
                    'title' => 'Preserve Formatting',
                    'description' => 'Keep all your slide layouts, fonts, and animations intact.',
                    'color' => '#FFA94D'
                ],
                [
                    'title' => 'Universal Compatibility',
                    'description' => 'PDF files can be viewed on any device without PowerPoint.',
                    'color' => '#4DABF7'
                ],
                [
                    'title' => 'Batch Conversion',
                    'description' => 'Convert multiple PowerPoint files to PDF at once.',
                    'color' => '#51CF66'
                ],
                [
                    'title' => 'Print Ready',
                    'description' => 'Get PDF files optimized for printing and sharing.',
                    'color' => '#F06595'
                ]
            ]
        ]);
    }

    public function excelToPdf()
    {
        return view('tools.placeholder', [
            'title' => 'Excel to PDF',
            'description' => 'Make EXCEL spreadsheets easy to read by converting them to PDF.',
            'icon' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#8CE99A" />
                        <path d="M34 16H26V24H34V16Z" fill="white" />
                        <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                      </svg>',
            'features' => [
                [
                    'title' => 'Preserve Formulas',
                    'description' => 'Keep your calculations and formulas visible in the PDF.',
                    'color' => '#8CE99A'
                ],
                [
                    'title' => 'Multiple Sheets',
                    'description' => 'Convert workbooks with multiple sheets into a single PDF.',
                    'color' => '#4DABF7'
                ],
                [
                    'title' => 'Chart Support',
                    'description' => 'Include all your charts and graphs in the PDF output.',
                    'color' => '#51CF66'
                ],
                [
                    'title' => 'Custom Page Size',
                    'description' => 'Choose the perfect page size for your spreadsheet data.',
                    'color' => '#F06595'
                ]
            ]
        ]);
    }

    public function editPdf()
    {
        return view('tools.placeholder', [
            'title' => 'Edit PDF',
            'description' => 'Add text, images, shapes or freehand annotations to a PDF document.',
            'icon' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#B197FC" />
                        <path d="M16 32H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M24 16V28" stroke="white" stroke-width="3" stroke-linecap="round" />
                      </svg>',
            'features' => [
                [
                    'title' => 'Add Text',
                    'description' => 'Insert text anywhere on your PDF with custom fonts and colors.',
                    'color' => '#B197FC'
                ],
                [
                    'title' => 'Insert Images',
                    'description' => 'Add images, logos, and graphics to your PDF documents.',
                    'color' => '#4DABF7'
                ],
                [
                    'title' => 'Draw & Annotate',
                    'description' => 'Use drawing tools to highlight and annotate your PDFs.',
                    'color' => '#51CF66'
                ],
                [
                    'title' => 'Form Fields',
                    'description' => 'Create fillable forms with text fields and checkboxes.',
                    'color' => '#F06595'
                ]
            ]
        ]);
    }

    public function signPdf()
    {
        return view('tools.placeholder', [
            'title' => 'Sign PDF',
            'description' => 'Sign yourself or request electronic signatures from others.',
            'icon' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#748FFC" />
                        <path d="M28 14L34 20L20 34H14V28L28 14Z" stroke="white" stroke-width="3" stroke-linejoin="round" />
                      </svg>',
            'features' => [
                [
                    'title' => 'Digital Signatures',
                    'description' => 'Create legally binding electronic signatures.',
                    'color' => '#748FFC'
                ],
                [
                    'title' => 'Multiple Signers',
                    'description' => 'Send documents to multiple people for signatures.',
                    'color' => '#4DABF7'
                ],
                [
                    'title' => 'Signature Templates',
                    'description' => 'Save your signature for quick reuse on future documents.',
                    'color' => '#51CF66'
                ],
                [
                    'title' => 'Audit Trail',
                    'description' => 'Track when and where documents were signed.',
                    'color' => '#F06595'
                ]
            ]
        ]);
    }

    public function watermarkPdf()
    {
        return view('tools.placeholder', [
            'title' => 'Watermark PDF',
            'description' => 'Stamp an image or text over your PDF in seconds. Choose typography, transparency and position.',
            'icon' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#F06595" />
                        <circle cx="24" cy="24" r="10" stroke="white" stroke-width="3" />
                        <path d="M18 24H30" stroke="white" stroke-width="3" stroke-linecap="round" />
                      </svg>',
            'features' => [
                [
                    'title' => 'Text Watermarks',
                    'description' => 'Add custom text watermarks with various fonts and styles.',
                    'color' => '#F06595'
                ],
                [
                    'title' => 'Image Watermarks',
                    'description' => 'Use your logo or any image as a watermark.',
                    'color' => '#4DABF7'
                ],
                [
                    'title' => 'Position Control',
                    'description' => 'Place watermarks exactly where you want them.',
                    'color' => '#51CF66'
                ],
                [
                    'title' => 'Transparency Options',
                    'description' => 'Adjust opacity to make watermarks subtle or prominent.',
                    'color' => '#FFD43B'
                ]
            ]
        ]);
    }

    public function rotatePdf()
    {
        return view('tools.placeholder', [
            'title' => 'Rotate PDF',
            'description' => 'Rotate your PDFs the way you need them. You can even rotate multiple PDFs at once!',
            'icon' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#20C997" />
                        <path d="M24 14V22" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M32 16L16 32" stroke="white" stroke-width="3" stroke-linecap="round" />
                      </svg>',
            'features' => [
                [
                    'title' => 'Rotate Pages',
                    'description' => 'Rotate individual pages or entire documents by 90, 180, or 270 degrees.',
                    'color' => '#20C997'
                ],
                [
                    'title' => 'Batch Processing',
                    'description' => 'Rotate multiple PDF files at once to save time.',
                    'color' => '#4DABF7'
                ],
                [
                    'title' => 'Preview Changes',
                    'description' => 'See how your pages will look before applying rotations.',
                    'color' => '#51CF66'
                ],
                [
                    'title' => 'Preserve Quality',
                    'description' => 'Rotation maintains the original quality of your PDF.',
                    'color' => '#F06595'
                ]
            ]
        ]);
    }
}