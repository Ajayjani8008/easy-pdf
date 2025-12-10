export function pdfToExcelPanel() {
    return {
        uploadedFileId: null,
        pdfInfo: null,
        converting: false,
        converted: false,
        outputFile: null,
        metadata: null,
        
        // Options
        extractionMode: 'automatic', // automatic, manual, entire_page
        pages: 'all', // 'all', single number, range '2-6', or array
        selectedPages: [],
        outputFormat: 'xlsx', // xlsx, csv
        keepFormatting: true,
        mergeHeaders: true,
        detectDates: true,
        detectCurrency: true,
        removeEmptyRows: true,
        removeEmptyColumns: true,
        ocrEnabled: false,
        ocrLanguage: 'eng',
        
        // State flags
        _lastLoadedFileId: null,
        _loadingPdfInfo: false,

        init() {
            // Listen for file upload events
            window.addEventListener('file-uploaded', (e) => {
                this.handleFileUpload(e.detail);
            });

            // Listen for new file uploads to reset state
            window.addEventListener('new-file-uploaded', () => {
                this.resetState();
            });
        },

        handleFileUpload(detail) {
            // Handle both 'id' and 'file_id' formats
            const fileId = detail?.file_id || detail?.id;
            if (fileId) {
                this.uploadedFileId = fileId;
                this.loadPdfInfo();
            } else {
                console.warn('PDF to Excel Panel: No file_id or id in upload event', detail);
            }
        },

        async loadPdfInfo() {
            if (!this.uploadedFileId || this._lastLoadedFileId === this.uploadedFileId || this._loadingPdfInfo) {
                console.log('PDF to Excel Panel: Skipping loadPdfInfo', {
                    uploadedFileId: this.uploadedFileId,
                    _lastLoadedFileId: this._lastLoadedFileId,
                    _loadingPdfInfo: this._loadingPdfInfo
                });
                return;
            }

            this._loadingPdfInfo = true;
            this._lastLoadedFileId = this.uploadedFileId;

            console.log('PDF to Excel Panel: Loading PDF info for file', this.uploadedFileId);

            try {
                const response = await fetch(`/api/pdf-to-excel/info/${this.uploadedFileId}`);
                const data = await response.json();

                console.log('PDF to Excel Panel: PDF info response', data);

                if (data.success) {
                    this.pdfInfo = data;
                    this.selectedPages = [];
                    console.log('PDF to Excel Panel: PDF info loaded successfully', this.pdfInfo);
                } else {
                    console.error('PDF to Excel Panel: Failed to load PDF info', data);
                    this.showToast('error', 'Error', data.message || 'Failed to load PDF info.');
                }
            } catch (error) {
                console.error('PDF to Excel Panel: Load PDF info error', error);
                this.showToast('error', 'Error', 'Failed to load PDF information.');
            } finally {
                this._loadingPdfInfo = false;
            }
        },

        canConvert() {
            return this.uploadedFileId && this.pdfInfo && !this.converting;
        },

        async startConvert() {
            if (!this.canConvert()) {
                this.showToast('warning', 'No PDF', 'Please upload a PDF file first.');
                return;
            }

            this.converting = true;
            this.converted = false;
            this.outputFile = null;
            this.metadata = null;

            this.showToast('info', 'Conversion Started', 'Converting PDF to Excel. Please wait...');

            try {
                // Prepare pages parameter
                let pagesParam = 'all';
                if (this.pages === 'all') {
                    pagesParam = 'all';
                } else if (this.selectedPages.length > 0) {
                    pagesParam = JSON.stringify(this.selectedPages);
                } else if (typeof this.pages === 'string' && this.pages.includes('-')) {
                    pagesParam = this.pages; // Range like "2-6"
                } else if (this.pages && this.pages !== 'all') {
                    pagesParam = this.pages.toString();
                }

                const options = {
                    file_id: this.uploadedFileId,
                    extraction_mode: this.extractionMode,
                    pages: pagesParam,
                    output_format: this.outputFormat,
                    keep_formatting: this.keepFormatting,
                    merge_headers: this.mergeHeaders,
                    detect_dates: this.detectDates,
                    detect_currency: this.detectCurrency,
                    remove_empty_rows: this.removeEmptyRows,
                    remove_empty_columns: this.removeEmptyColumns,
                    ocr_enabled: this.ocrEnabled,
                    ocr_language: this.ocrLanguage,
                };

                const response = await fetch('/api/pdf-to-excel/convert', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(options)
                });

                const data = await response.json();

                if (data.success) {
                    this.converting = false;
                    this.converted = true;
                    this.outputFile = data.file;
                    this.metadata = data.metadata;
                    this.showToast('success', 'Conversion Complete', 'Your Excel file is ready to download!');
                } else {
                    this.converting = false;
                    this.showToast('error', 'Conversion Failed', data.message || 'Failed to convert PDF to Excel.');
                }
            } catch (error) {
                console.error('Conversion error:', error);
                this.converting = false;
                this.showToast('error', 'Error', 'An error occurred during conversion.');
            }
        },

        downloadFile() {
            if (!this.outputFile || !this.outputFile.download_url) {
                this.showToast('error', 'Error', 'Download URL not available.');
                return;
            }

            window.location.href = this.outputFile.download_url;
        },

        resetState() {
            this.uploadedFileId = null;
            this.pdfInfo = null;
            this.converting = false;
            this.converted = false;
            this.outputFile = null;
            this.metadata = null;
            this._lastLoadedFileId = null;
            this.selectedPages = [];
            // Keep options/settings - don't reset them
        },

        togglePageSelection(pageNum) {
            const index = this.selectedPages.indexOf(pageNum);
            if (index > -1) {
                this.selectedPages.splice(index, 1);
            } else {
                this.selectedPages.push(pageNum);
            }
            this.selectedPages.sort((a, b) => a - b);
        },

        isPageSelected(pageNum) {
            return this.selectedPages.includes(pageNum);
        },

        getSelectedPagesText() {
            if (this.pages === 'all') {
                return 'All pages';
            } else if (this.selectedPages.length > 0) {
                return `${this.selectedPages.length} page(s) selected`;
            } else if (typeof this.pages === 'string' && this.pages.includes('-')) {
                return `Pages ${this.pages}`;
            } else if (this.pages) {
                return `Page ${this.pages}`;
            }
            return 'All pages';
        },

        showToast(type, title, message) {
            // Dispatch custom event for toast notification
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { type, title, message }
            }));
        }
    };
}

