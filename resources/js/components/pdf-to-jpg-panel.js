export function pdfToJpgPanel() {
    return {
        uploadedFileId: null,
        pageCount: 0,
        conversionMode: 'pages', // 'pages' or 'images'
        quality: 'medium', // 'high', 'medium', 'low'
        dpi: 150, // 72, 150, 300
        pageRanges: [],
        selectedPages: [], // For page selection
        converting: false,
        converted: false,
        outputFile: null,
        conversion: null,
        loadingPageCount: false,

        init() {
            const component = this;
            
            // Listen for file upload
            window.addEventListener('file-uploaded', (event) => {
                const newFileId = event.detail.id;
                
                // Reset state if it's a different file or if we already have a completed conversion
                if (component.uploadedFileId !== newFileId || component.converted) {
                    component.resetState();
                }
                
                component.uploadedFileId = newFileId;
                component.loadPageCount();
            });
        },

        resetState() {
            // Reset all state variables when a new file is uploaded
            this.pageCount = 0;
            this.pageRanges = [];
            this.selectedPages = [];
            this.converting = false;
            this.converted = false;
            this.outputFile = null;
            this.conversion = null;
            this.conversionMode = 'pages';
            this.quality = 'medium';
            this.dpi = 150;
        },

        async loadPageCount() {
            if (!this.uploadedFileId) return;

            this.loadingPageCount = true;
            try {
                const response = await fetch(`/api/pdf-to-jpg/page-count?file_id=${this.uploadedFileId}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.pageCount = data.page_count;
                    // Initialize selected pages to all pages
                    this.selectedPages = Array.from({ length: this.pageCount }, (_, i) => i + 1);
                } else {
                    this.showToast('error', 'Error', 'Failed to load page count: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Page count error:', error);
                this.showToast('error', 'Error', 'Failed to load page count. Please try again.');
            } finally {
                this.loadingPageCount = false;
            }
        },

        togglePageSelection(page) {
            const index = this.selectedPages.indexOf(page);
            if (index > -1) {
                this.selectedPages.splice(index, 1);
            } else {
                this.selectedPages.push(page);
                this.selectedPages.sort((a, b) => a - b);
            }
        },

        selectAllPages() {
            this.selectedPages = Array.from({ length: this.pageCount }, (_, i) => i + 1);
        },

        deselectAllPages() {
            this.selectedPages = [];
        },

        getPageRanges() {
            if (this.selectedPages.length === 0) {
                return null; // Convert all pages
            }

            if (this.selectedPages.length === this.pageCount) {
                return null; // All pages selected, return null to convert all
            }

            // Convert selected pages to ranges
            const ranges = [];
            let start = this.selectedPages[0];
            let end = this.selectedPages[0];

            for (let i = 1; i < this.selectedPages.length; i++) {
                if (this.selectedPages[i] === end + 1) {
                    end = this.selectedPages[i];
                } else {
                    ranges.push(start === end ? [start] : [start, end]);
                    start = this.selectedPages[i];
                    end = this.selectedPages[i];
                }
            }
            ranges.push(start === end ? [start] : [start, end]);

            return ranges;
        },

        async startConvert() {
            if (!this.uploadedFileId) {
                this.showToast('warning', 'No File', 'Please upload a PDF file first.');
                return;
            }

            if (this.conversionMode === 'pages' && this.selectedPages.length === 0) {
                this.showToast('validation', 'Select Pages', 'Please select at least one page to convert.');
                return;
            }

            this.converting = true;
            this.converted = false;

            // Show info toast
            this.showToast('info', 'Conversion Started', 'Your PDF is being converted to JPG. Please wait...');

            try {
                const pageRanges = this.getPageRanges();

                const response = await fetch('/api/pdf-to-jpg/convert', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        file_id: this.uploadedFileId,
                        mode: this.conversionMode,
                        quality: this.quality,
                        dpi: parseInt(this.dpi), // Ensure DPI is integer
                        page_ranges: pageRanges
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.converting = false;
                    this.converted = true;
                    this.outputFile = data.file;
                    this.conversion = data.conversion;
                    // Show success toast
                    this.showToast('success', 'Conversion Complete', `Your PDF has been converted successfully! ${data.conversion.converted_count} ${data.conversion.mode === 'pages' ? 'pages' : 'images'} converted.`);
                } else {
                    throw new Error(data.message || 'Conversion failed');
                }
            } catch (error) {
                console.error('Convert error:', error);
                this.showToast('error', 'Conversion Failed', error.message || 'Something went wrong. Please try again.');
                this.converting = false;
            }
        },

        downloadFile() {
            if (this.outputFile && this.outputFile.download_url) {
                window.location.href = this.outputFile.download_url;
                this.showToast('info', 'Download Started', 'Your converted files are downloading...');
            } else {
                this.showToast('error', 'Download Failed', 'File not available for download.');
            }
        },

        showToast(type, title, message) {
            if (window.showToast) {
                window.showToast(type, title, message);
            } else {
                console.warn('Toast system not available');
                alert(`${title}: ${message}`);
            }
        }
    };
}

