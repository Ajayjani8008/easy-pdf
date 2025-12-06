export function fileUpload() {
    return {
        isDragging: false,
        selectedFile: null,
        uploading: false,
        uploadedFileId: null,

        init() {
            // Initialize if needed
        },

        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                this.handleFile(files[0]);
            }
        },

        handleFileSelect(event) {
            const files = event.target.files;
            if (files.length > 0) {
                this.handleFile(files[0]);
            }
        },

        handleFile(file) {
            // Validate file type
            if (file.type !== 'application/pdf') {
                this.showToast('error', 'Invalid File Type', 'Please select a PDF file only.');
                return;
            }

            // Validate file size (50MB)
            if (file.size > 50 * 1024 * 1024) {
                this.showToast('error', 'File Too Large', 'File size must not exceed 50MB.');
                return;
            }

            this.selectedFile = {
                file: file,
                name: file.name,
                size: file.size,
                sizeText: this.formatFileSize(file.size)
            };
        },

        async uploadFile() {
            if (!this.selectedFile) return;

            this.uploading = true;
            const formData = new FormData();
            formData.append('file', this.selectedFile.file);

            try {
                const response = await fetch('/api/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.uploadedFileId = data.file.id;
                    console.log('File uploaded successfully:', data.file);
                    
                    // Show success toast
                    this.showToast('success', 'Upload Successful', `"${data.file.name}" uploaded successfully.`);
                    
                    // Dispatch event for other components
                    const event = new CustomEvent('file-uploaded', {
                        detail: data.file
                    });
                    window.dispatchEvent(event);
                    console.log('file-uploaded event dispatched');
                    // Clear selected file after successful upload
                    this.selectedFile = null;
                } else {
                    this.showToast('error', 'Upload Failed', data.message || 'Unknown error occurred.');
                }
            } catch (error) {
                console.error('Upload error:', error);
                this.showToast('error', 'Upload Failed', 'Please try again. Check your connection and try again.');
            } finally {
                this.uploading = false;
            }
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
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

