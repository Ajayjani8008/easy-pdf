export function mergePanel() {
    return {
        merging: false,
        merged: false,
        outputFile: null,
        progress: 0,
        fileIds: [],
        progressInterval: null,

        init() {
            const component = this;
            
            // Listen for file updates
            window.addEventListener('files-updated-merge', (event) => {
                component.fileIds = event.detail.files.map(f => f.fileId).filter(id => id !== null);
            });

            // Listen for file reordering
            window.addEventListener('files-reordered-merge', (event) => {
                component.fileIds = event.detail.files.map(f => f.fileId).filter(id => id !== null);
            });
        },

        canMerge() {
            // Get file IDs from merge-file-upload component
            const uploadComponent = this.getUploadComponent();
            if (uploadComponent) {
                this.fileIds = uploadComponent.getFileIds();
                return uploadComponent.canMerge();
            }
            return false;
        },

        getUploadComponent() {
            // Find the merge-file-upload component
            const uploadElement = document.querySelector('[x-data*="mergeFileUpload"]');
            if (uploadElement && window.Alpine) {
                return window.Alpine.$data(uploadElement);
            }
            return null;
        },

        async startMerge() {
            const uploadComponent = this.getUploadComponent();
            if (!uploadComponent) {
                this.showToast('warning', 'No Files', 'Please upload files first.');
                return;
            }

            this.fileIds = uploadComponent.getFileIds();
            
            if (this.fileIds.length < 2) {
                this.showToast('validation', 'Insufficient Files', 'At least 2 files are required for merging.');
                return;
            }

            this.merging = true;
            this.merged = false;
            this.progress = 0;
            this.startProgressAnimation();

            // Show info toast
            this.showToast('info', 'Merging Started', 'Your PDF files are being merged. Please wait...');

            try {
                const response = await fetch('/api/merge', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        file_ids: this.fileIds
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.progress = 100;
                    setTimeout(() => {
                        this.merging = false;
                        this.merged = true;
                        this.outputFile = data.file;
                        this.stopProgressAnimation();
                        // Show success toast
                        this.showToast('success', 'Merge Complete', 'Your PDF files have been merged successfully!');
                    }, 500);
                } else {
                    throw new Error(data.message || 'Merge failed');
                }
            } catch (error) {
                console.error('Merge error:', error);
                this.showToast('error', 'Merge Failed', error.message || 'Something went wrong. Please try again.');
                this.merging = false;
                this.stopProgressAnimation();
            }
        },

        startProgressAnimation() {
            // Simulate progress
            let currentProgress = 0;
            this.progressInterval = setInterval(() => {
                if (currentProgress < 90) {
                    currentProgress += Math.random() * 5 + 2; // Random increment
                    this.progress = Math.min(90, Math.floor(currentProgress));
                }
            }, 300);
        },

        stopProgressAnimation() {
            if (this.progressInterval) {
                clearInterval(this.progressInterval);
                this.progressInterval = null;
            }
        },

        downloadFile() {
            if (this.outputFile && this.outputFile.download_url) {
                window.location.href = this.outputFile.download_url;
                this.showToast('info', 'Download Started', 'Your merged PDF is downloading...');
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

