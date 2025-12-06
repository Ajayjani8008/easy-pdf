# SEO Controller Template for New Tools

## 📋 Required SEO Methods for Every Tool Controller

When creating a new tool controller, you **MUST** override these 3 methods to provide unique SEO data:

1. `getShortBenefit()` - For SEO title
2. `getMetaDescription()` - Unique 150-160 character description
3. `getKeywords()` - Tool-specific keywords

---

## 📝 Controller Template

```php
<?php

namespace App\Http\Controllers\Tool;

class YourToolController extends BaseConverterController
{
    /**
     * Return the view file name (without .blade.php)
     */
    protected function getConversionType(): string
    {
        return 'your-tool-name'; // Must match view file name
    }

    /**
     * Full tool name for display
     */
    protected function getToolName(): string
    {
        return 'Your Tool Name';
    }

    /**
     * REQUIRED: Short benefit for SEO title
     * Format: "Free Online {Short Benefit}"
     * Example: "DOCX Converter", "PDF Merger", "PDF Compressor"
     */
    protected function getShortBenefit(): string
    {
        return 'Short Benefit Name';
    }

    /**
     * REQUIRED: Unique meta description (150-160 characters)
     * Must be unique for each tool - no copy-paste!
     * Include: main keyword, free, fast, secure, no signup
     */
    protected function getMetaDescription(): string
    {
        return 'Your unique 150-160 character meta description. Include main keyword, mention free, fast, secure, no signup required.';
    }

    /**
     * REQUIRED: Tool-specific keywords (5-8 keywords)
     * Must be unique for each tool
     * Include: main keyword, variations, related terms
     */
    protected function getKeywords(): string
    {
        return 'main keyword, keyword variation, related term, free tool, online tool, specific feature';
    }
}
```

---

## ✅ Examples

### Example 1: PDF to Word Converter

```php
class PdfToWordController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'pdf-to-word';
    }

    protected function getToolName(): string
    {
        return 'PDF to Word Converter';
    }

    protected function getShortBenefit(): string
    {
        return 'DOCX Converter';
    }

    protected function getMetaDescription(): string
    {
        return 'Convert PDF to Word documents for free. Fast, secure, and easy to use. No registration required. Preserve formatting and layout.';
    }

    protected function getKeywords(): string
    {
        return 'pdf to word, pdf to docx, convert pdf to word, pdf converter, free pdf to word, online pdf converter, pdf to word online, pdf to doc converter';
    }
}
```

**Result:**
- Title: `PDF to Word Converter | Free Online DOCX Converter | EasyPDF`
- Description: 158 characters, unique
- Keywords: 8 relevant keywords

---

### Example 2: Merge PDF

```php
class MergePdfController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'merge';
    }

    protected function getToolName(): string
    {
        return 'Merge PDF';
    }

    protected function getShortBenefit(): string
    {
        return 'PDF Merger';
    }

    protected function getMetaDescription(): string
    {
        return 'Merge multiple PDF files into one document for free. Combine 2-10 PDFs online. Fast, secure, no signup required. Drag and drop to reorder.';
    }

    protected function getKeywords(): string
    {
        return 'merge pdf, combine pdf, pdf merger, merge pdf files, join pdf, pdf combiner, free pdf merger, online pdf merge';
    }
}
```

**Result:**
- Title: `Merge PDF | Free Online PDF Merger | EasyPDF`
- Description: 158 characters, unique
- Keywords: 8 relevant keywords

---

### Example 3: Compress PDF (Future Tool)

```php
class CompressPdfController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'compress-pdf';
    }

    protected function getToolName(): string
    {
        return 'Compress PDF';
    }

    protected function getShortBenefit(): string
    {
        return 'PDF Compressor';
    }

    protected function getMetaDescription(): string
    {
        return 'Compress PDF files to reduce size for free. Reduce file size up to 80% without losing quality. Fast, secure, no signup required.';
    }

    protected function getKeywords(): string
    {
        return 'compress pdf, reduce pdf size, pdf compressor, shrink pdf, optimize pdf, pdf file size reducer, free pdf compressor, online pdf compression';
    }
}
```

**Result:**
- Title: `Compress PDF | Free Online PDF Compressor | EasyPDF`
- Description: 157 characters, unique
- Keywords: 8 relevant keywords

---

## 🎯 SEO Title Format

The title is automatically generated using this format:

```
{ToolName} | Free Online {ShortBenefit} | {BrandName}
```

**Examples:**
- `PDF to Word Converter | Free Online DOCX Converter | EasyPDF`
- `Merge PDF | Free Online PDF Merger | EasyPDF`
- `Compress PDF | Free Online PDF Compressor | EasyPDF`

---

## 📏 Meta Description Guidelines

### Length
- **150-160 characters** (including spaces)
- Google typically displays up to 160 characters
- Aim for 155-158 characters for best results

### Content Structure
1. **First 120 characters**: Main keyword + key benefit
2. **Next 30-40 characters**: Additional benefits (fast, secure, free)
3. **Last 10-20 characters**: Call to action or unique feature

### Example Breakdown
```
Merge multiple PDF files into one document for free. Combine 2-10 PDFs online. Fast, secure, no signup required. Drag and drop to reorder.
|--------120 chars--------| |-----30 chars-----| |--------8 chars--------|
```

### Must Include
- ✅ Main keyword (in first 120 chars)
- ✅ "Free" or "100% free"
- ✅ "Fast" or "Instant"
- ✅ "Secure" or "Safe"
- ✅ "No signup" or "No registration"
- ✅ Unique feature or benefit

---

## 🔑 Keywords Guidelines

### Number of Keywords
- **5-8 keywords** per tool
- Not too many (avoid keyword stuffing)
- Not too few (miss opportunities)

### Keyword Types
1. **Main keyword**: Exact tool name
2. **Variations**: Different ways to say the same thing
3. **Long-tail**: More specific phrases
4. **Related terms**: Associated concepts
5. **Action words**: "free", "online", "convert", "merge"

### Example Analysis (Merge PDF)
```
merge pdf              ← Main keyword
combine pdf            ← Variation
pdf merger             ← Variation
merge pdf files        ← Long-tail
join pdf               ← Related term
pdf combiner           ← Variation
free pdf merger        ← Action + keyword
online pdf merge       ← Action + keyword
```

### Format
- Comma-separated
- Lowercase (optional, but consistent)
- No duplicates
- Natural language

---

## ⚠️ Common Mistakes to Avoid

### ❌ Don't Do This:
```php
// Using default from BaseConverterController
class YourToolController extends BaseConverterController
{
    protected function getConversionType(): string { return 'tool'; }
    protected function getToolName(): string { return 'Tool Name'; }
    // Missing getShortBenefit(), getMetaDescription(), getKeywords()
    // Will use generic defaults - BAD for SEO!
}
```

### ✅ Do This:
```php
// Override all SEO methods
class YourToolController extends BaseConverterController
{
    protected function getConversionType(): string { return 'tool'; }
    protected function getToolName(): string { return 'Tool Name'; }
    protected function getShortBenefit(): string { return 'Unique Benefit'; }
    protected function getMetaDescription(): string { return 'Unique 150-160 char description...'; }
    protected function getKeywords(): string { return 'unique, keywords, for, this, tool'; }
}
```

---

## ✅ Checklist for New Tool Controller

When creating a new tool controller, ensure:

- [ ] `getConversionType()` returns correct view file name
- [ ] `getToolName()` returns full display name
- [ ] `getShortBenefit()` returns unique short benefit (2-3 words)
- [ ] `getMetaDescription()` returns unique 150-160 character description
- [ ] `getKeywords()` returns 5-8 unique, relevant keywords
- [ ] All descriptions/keywords are unique (not copied from other tools)
- [ ] Meta description includes: free, fast, secure, no signup
- [ ] Keywords include main keyword and variations

---

## 🔍 Testing Your SEO

After implementing, check:

1. **View Source** - Check `<title>` and `<meta name="description">` tags
2. **Character Count** - Verify description is 150-160 chars
3. **Uniqueness** - Compare with other tools (should be different)
4. **Keyword Usage** - Main keyword appears in title, description, H1
5. **Google Search Console** - Monitor rankings and CTR

---

## 📚 Quick Reference

### Method Return Types
- `getConversionType()`: `string` - View file name
- `getToolName()`: `string` - Full tool name
- `getShortBenefit()`: `string` - 2-3 words for title
- `getMetaDescription()`: `string` - 150-160 characters
- `getKeywords()`: `string` - 5-8 comma-separated keywords

### Auto-Generated Title Format
```
{ToolName} | Free Online {ShortBenefit} | {BrandName}
```

### Where SEO Data is Used
- **Title**: `<title>` tag in `<head>`
- **Description**: `<meta name="description">` tag
- **Keywords**: `<meta name="keywords">` tag
- **Canonical**: `<link rel="canonical">` tag
- **OG Type**: Open Graph meta tag

---

**Remember:** Every tool MUST have unique SEO data. Never copy-paste descriptions or keywords from other tools!

