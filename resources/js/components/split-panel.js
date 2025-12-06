export function splitPanel() {
    return {
        uploadedFileId: null,
        pageCount: 0,
        selectedRanges: [],
        splitting: false,
        split: false,
        outputFile: null,
        loadingPageCount: false,

        init() {
            const component = this;
            
            // Listen for file upload
            window.addEventListener('file-uploaded', (event) => {
                const newFileId = event.detail.id;
                
                // Reset state if it's a different file or if we already have a completed split
                if (component.uploadedFileId !== newFileId || component.split) {
                    component.resetState();
                }
                
                component.uploadedFileId = newFileId;
                component.loadPageCount();
            });
        },

        resetState() {
            // Reset all state variables when a new file is uploaded
            this.selectedRanges = [];
            this.splitting = false;
            this.split = false;
            this.outputFile = null;
            this.pageCount = 0;
        },

        async loadPageCount() {
            if (!this.uploadedFileId) return;

            this.loadingPageCount = true;
            try {
                const response = await fetch(`/api/split/page-count?file_id=${this.uploadedFileId}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.pageCount = data.page_count;
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

        addRange() {
            this.selectedRanges.push({
                start: null,
                end: null
            });
        },

        removeRange(index) {
            this.selectedRanges.splice(index, 1);
        },

        validateRanges() {
            // Remove invalid ranges
            this.selectedRanges = this.selectedRanges.filter(range => {
                return range.start && range.end && 
                       range.start >= 1 && 
                       range.end <= this.pageCount &&
                       range.start <= range.end;
            });

            // Normalize ranges (ensure end >= start)
            this.selectedRanges.forEach(range => {
                if (range.end < range.start) {
                    range.end = range.start;
                }
            });

            return this.selectedRanges.length > 0;
        },

        async startSplit() {
            if (!this.uploadedFileId) {
                this.showToast('warning', 'No File', 'Please upload a PDF file first.');
                return;
            }

            if (!this.validateRanges()) {
                this.showToast('validation', 'Invalid Ranges', 'Please add at least one valid page range.');
                return;
            }

            // Prepare page ranges for API
            const pageRanges = this.selectedRanges.map(range => {
                const start = parseInt(range.start);
                const end = parseInt(range.end);
                return start === end ? [start] : [start, end];
            });

            this.splitting = true;
            this.split = false;

            // Show info toast
            this.showToast('info', 'Splitting Started', 'Your PDF is being split. Please wait...');

            try {
                const response = await fetch('/api/split', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        file_id: this.uploadedFileId,
                        page_ranges: pageRanges
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.splitting = false;
                    this.split = true;
                    this.outputFile = data.file;
                    // Show success toast
                    this.showToast('success', 'Split Complete', 'Your PDF has been split successfully!');
                } else {
                    throw new Error(data.message || 'Split failed');
                }
            } catch (error) {
                console.error('Split error:', error);
                this.showToast('error', 'Split Failed', error.message || 'Something went wrong. Please try again.');
                this.splitting = false;
            }
        },

        downloadFile() {
            if (this.outputFile && this.outputFile.download_url) {
                window.location.href = this.outputFile.download_url;
                this.showToast('info', 'Download Started', 'Your split PDF is downloading...');
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

