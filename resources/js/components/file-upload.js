export function fileUpload() {
    return {
        isDragging: false,
        selectedFile: null,
        uploading: false,
        uploadedFileId: null,
        
        // Configuration from data attributes
        acceptedTypes: [],
        acceptedExtensions: [],
        maxSize: 50 * 1024 * 1024, // 50MB default
        uploadUrl: '/api/upload',
        fileTypeLabel: 'PDF',

        init() {
            // Get configuration from data attributes
            // Use $el or this.$el depending on Alpine.js version
            const element = this.$el || (this.$root && this.$root.$el) || document.querySelector('[x-data*="fileUpload"]');
            if (element) {
                // Get accepted file types from accept attribute
                const fileInput = element.querySelector('input[type="file"]');
                if (fileInput) {
                    const acceptAttr = fileInput.getAttribute('accept') || '';
                    if (acceptAttr) {
                        this.parseAcceptAttribute(acceptAttr);
                    }
                }
                
                // Get max size from data attribute
                const maxSizeAttr = element.getAttribute('data-max-size');
                if (maxSizeAttr) {
                    this.maxSize = parseInt(maxSizeAttr) * 1024; // Convert KB to bytes
                }
                
                // Get upload URL from data attribute
                const uploadUrlAttr = element.getAttribute('data-upload-url');
                if (uploadUrlAttr) {
                    this.uploadUrl = uploadUrlAttr;
                }
                
                // Get file type label from data attribute
                const fileTypeLabelAttr = element.getAttribute('data-file-type-label');
                if (fileTypeLabelAttr) {
                    this.fileTypeLabel = fileTypeLabelAttr;
                }
            }
        },

        parseAcceptAttribute(accept) {
            // Parse accept attribute like ".pdf,application/pdf" or ".doc,.docx,.rtf,.odt"
            const parts = accept.split(',');
            this.acceptedTypes = [];
            this.acceptedExtensions = [];
            
            parts.forEach(part => {
                part = part.trim();
                if (part.startsWith('.')) {
                    // Extension like .pdf, .doc
                    this.acceptedExtensions.push(part.toLowerCase());
                } else if (part.includes('/')) {
                    // MIME type like application/pdf
                    this.acceptedTypes.push(part.toLowerCase());
                }
            });
        },

        isValidFileType(file) {
            // If no restrictions set, allow all (backward compatibility)
            if (this.acceptedTypes.length === 0 && this.acceptedExtensions.length === 0) {
                return true;
            }
            
            // Check by MIME type first
            if (this.acceptedTypes.length > 0 && file.type) {
                const fileMimeType = file.type.toLowerCase();
                if (this.acceptedTypes.some(type => {
                    const normalizedType = type.toLowerCase();
                    return fileMimeType === normalizedType || 
                           fileMimeType.includes(normalizedType.split('/')[1]) ||
                           normalizedType.includes(fileMimeType.split('/')[0]);
                })) {
                    return true;
                }
            }
            
            // Check by extension as fallback
            if (this.acceptedExtensions.length > 0 && file.name) {
                const fileName = file.name.toLowerCase();
                const lastDotIndex = fileName.lastIndexOf('.');
                if (lastDotIndex > 0) {
                    const fileExtension = fileName.substring(lastDotIndex);
                    if (this.acceptedExtensions.some(ext => ext.toLowerCase() === fileExtension)) {
                        return true;
                    }
                }
            }
            
            return false;
        },

        getFileTypeErrorMessage() {
            if (this.acceptedExtensions.length > 0) {
                const extensions = this.acceptedExtensions.join(', ').replace(/\./g, '').toUpperCase();
                return `Please select a ${this.fileTypeLabel} file only (${extensions}).`;
            }
            return `Please select a ${this.fileTypeLabel} file only.`;
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
            if (this.acceptedTypes.length > 0 || this.acceptedExtensions.length > 0) {
                if (!this.isValidFileType(file)) {
                    this.showToast('error', 'Invalid File Type', this.getFileTypeErrorMessage());
                    return;
                }
            } else {
                // Default: PDF only (backward compatibility)
                if (file.type !== 'application/pdf') {
                    this.showToast('error', 'Invalid File Type', 'Please select a PDF file only.');
                    return;
                }
            }

            // Validate file size
            if (file.size > this.maxSize) {
                const maxSizeMB = (this.maxSize / 1024 / 1024).toFixed(0);
                this.showToast('error', 'File Too Large', `File size must not exceed ${maxSizeMB}MB.`);
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
                const response = await fetch(this.uploadUrl, {
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

