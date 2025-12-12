export function wordToPdfPanel() {
    return {
        uploadedFileId: null,
        converting: false,
        converted: false,
        outputFile: null,
        metadata: null,
        
        // Options
        pageSize: 'a4', // a4, letter, legal
        orientation: 'portrait', // portrait, landscape
        margin: 'default', // default, narrow, wide
        
        // State flags
        _lastLoadedFileId: null,

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
            } else {
                console.warn('Word to PDF Panel: No file_id or id in upload event', detail);
            }
        },

        canConvert() {
            return this.uploadedFileId && !this.converting;
        },

        async startConvert() {
            if (!this.canConvert()) {
                this.showToast('warning', 'No File', 'Please upload a Word document first.');
                return;
            }

            this.converting = true;
            this.converted = false;
            this.outputFile = null;
            this.metadata = null;

            try {
                const response = await fetch('/api/word-to-pdf/convert', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    },
                    body: JSON.stringify({
                        file_id: this.uploadedFileId,
                        page_size: this.pageSize,
                        orientation: this.orientation,
                        margin: this.margin,
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    this.converted = true;
                    this.outputFile = {
                        id: data.file_id,
                        name: data.file_name,
                        size: data.file_size,
                        pages: data.pages,
                    };
                    this.metadata = {
                        pages: data.pages,
                        file_size: data.file_size,
                        converted_at: data.converted_at,
                    };
                    this.showToast('success', 'Success', 'Word document converted to PDF successfully!');
                } else {
                    this.showToast('error', 'Error', data.message || 'Conversion failed.');
                }
            } catch (error) {
                console.error('Conversion error:', error);
                this.showToast('error', 'Error', 'Failed to convert Word to PDF. Please try again.');
            } finally {
                this.converting = false;
            }
        },

        downloadFile() {
            if (!this.outputFile) {
                this.showToast('warning', 'No File', 'No converted file available.');
                return;
            }

            const downloadUrl = `/api/files/${this.outputFile.id}/download`;
            window.open(downloadUrl, '_blank');

            // Reset conversion state after download (allow re-conversion)
            setTimeout(() => {
                this.converted = false;
                this.outputFile = null;
                this.metadata = null;
            }, 1000);
        },

        resetState() {
            // Reset conversion state but keep settings
            this.uploadedFileId = null;
            this._lastLoadedFileId = null;
            this.converting = false;
            this.converted = false;
            this.outputFile = null;
            this.metadata = null;
        },

        showToast(type, title, message) {
            // Dispatch custom event for toast notification
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { type, title, message }
            }));
        },
    };
}

