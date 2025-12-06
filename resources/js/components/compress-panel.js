export function compressPanel() {
    return {
        uploadedFileId: null,
        fileInfo: null,
        compressionLevel: 'balanced', // high, balanced, low
        estimate: null,
        compressing: false,
        compressed: false,
        outputFile: null,
        compression: null,
        loadingInfo: false,

        init() {
            const component = this;
            
            // Listen for file upload
            window.addEventListener('file-uploaded', (event) => {
                const newFileId = event.detail.id;
                
                // Reset state if it's a different file or if we already have a completed compression
                if (component.uploadedFileId !== newFileId || component.compressed) {
                    component.resetState();
                }
                
                component.uploadedFileId = newFileId;
                component.loadFileInfo();
            });
        },

        resetState() {
            // Reset all state variables when a new file is uploaded
            this.fileInfo = null;
            this.estimate = null;
            this.compressing = false;
            this.compressed = false;
            this.outputFile = null;
            this.compression = null;
            this.compressionLevel = 'balanced';
        },

        async loadFileInfo() {
            if (!this.uploadedFileId) return;

            this.loadingInfo = true;
            try {
                const response = await fetch(`/api/compress/file-info?file_id=${this.uploadedFileId}&level=${this.compressionLevel}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.fileInfo = data.file_info;
                    this.estimate = data.estimate;
                } else {
                    this.showToast('error', 'Error', 'Failed to load file info: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('File info error:', error);
                this.showToast('error', 'Error', 'Failed to load file info. Please try again.');
            } finally {
                this.loadingInfo = false;
            }
        },

        async onLevelChange() {
            if (this.uploadedFileId) {
                await this.loadFileInfo();
            }
        },

        async startCompress() {
            if (!this.uploadedFileId) {
                this.showToast('warning', 'No File', 'Please upload a PDF file first.');
                return;
            }

            if (!this.compressionLevel) {
                this.showToast('validation', 'Select Level', 'Please select a compression level.');
                return;
            }

            this.compressing = true;
            this.compressed = false;

            // Show info toast
            this.showToast('info', 'Compressing Started', 'Your PDF is being compressed. Please wait...');

            try {
                const response = await fetch('/api/compress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        file_id: this.uploadedFileId,
                        level: this.compressionLevel
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.compressing = false;
                    this.compressed = true;
                    this.outputFile = data.file;
                    this.compression = data.compression;
                    // Show success toast
                    this.showToast('success', 'Compression Complete', `Your PDF has been compressed successfully! Saved ${data.compression.saved_percentage}%`);
                } else {
                    throw new Error(data.message || 'Compression failed');
                }
            } catch (error) {
                console.error('Compress error:', error);
                this.showToast('error', 'Compression Failed', error.message || 'Something went wrong. Please try again.');
                this.compressing = false;
            }
        },

        downloadFile() {
            if (this.outputFile && this.outputFile.download_url) {
                window.location.href = this.outputFile.download_url;
                this.showToast('info', 'Download Started', 'Your compressed PDF is downloading...');
            } else {
                this.showToast('error', 'Download Failed', 'File not available for download.');
            }
        },

        recompress(level) {
            if (!this.uploadedFileId) return;
            
            this.compressionLevel = level;
            this.compressed = false;
            this.outputFile = null;
            this.compression = null;
            this.startCompress();
        },

        formatBytes(bytes) {
            if (!bytes || bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
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

