export function jpgToPdfUpload() {
    return {
        isDragging: false,
        selectedFiles: [],
        uploading: false,
        uploadedImages: [],
        maxFiles: 50,

        init() {
            // Listen for image removal
            window.addEventListener('remove-image', (event) => {
                this.removeImage(event.detail.imageId);
            });
        },

        handleDrop(event) {
            event.preventDefault();
            this.isDragging = false;
            const files = Array.from(event.dataTransfer.files);
            this.handleFiles(files);
        },

        handleFileSelect(event) {
            const file = event.target.files[0]; // One-by-one selection
            if (file) {
                this.handleFile(file);
            }
            event.target.value = '';
        },

        handleFile(file) {
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                this.showToast('error', 'Invalid File Type', 'Please select JPG, JPEG, PNG, or WebP images only.');
                return;
            }

            // Check total file count
            if (this.selectedFiles.length >= this.maxFiles) {
                this.showToast('warning', 'Maximum Files Reached', `Maximum ${this.maxFiles} images allowed. Please remove an image first.`);
                return;
            }

            // Validate file size (50MB)
            if (file.size > 50 * 1024 * 1024) {
                this.showToast('error', 'File Too Large', `Image "${file.name}" exceeds 50MB limit.`);
                return;
            }

            // Check if file already exists
            if (this.selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                this.showToast('warning', 'Image Already Added', `Image "${file.name}" is already in the list.`);
                return;
            }

            // Add file to selected files
            const fileData = {
                id: this.generateId(),
                file: file,
                name: file.name,
                size: file.size,
                sizeText: this.formatFileSize(file.size),
                uploading: false,
                uploaded: false,
                imageId: null,
                preview: null,
            };

            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                fileData.preview = e.target.result;
            };
            reader.readAsDataURL(file);

            this.selectedFiles.push(fileData);

            // Auto-upload the file
            this.uploadFile(fileData);
        },

        handleFiles(files) {
            const imageFiles = files.filter(file => {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                return allowedTypes.includes(file.type);
            });
            
            if (imageFiles.length === 0) {
                this.showToast('error', 'Invalid Files', 'Please select JPG, JPEG, PNG, or WebP images only.');
                return;
            }

            const totalFiles = this.selectedFiles.length + imageFiles.length;
            if (totalFiles > this.maxFiles) {
                this.showToast('warning', 'Too Many Files', `Maximum ${this.maxFiles} images allowed. You already have ${this.selectedFiles.length} images.`);
                return;
            }

            imageFiles.forEach(file => {
                if (file.size > 50 * 1024 * 1024) {
                    this.showToast('error', 'File Too Large', `Image "${file.name}" exceeds 50MB limit.`);
                    return;
                }

                if (this.selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    return; // Skip duplicates
                }

                const fileData = {
                    id: this.generateId(),
                    file: file,
                    name: file.name,
                    size: file.size,
                    sizeText: this.formatFileSize(file.size),
                    uploading: false,
                    uploaded: false,
                    imageId: null,
                    preview: null,
                };

                const reader = new FileReader();
                reader.onload = (e) => {
                    fileData.preview = e.target.result;
                };
                reader.readAsDataURL(file);

                this.selectedFiles.push(fileData);
                this.uploadFile(fileData);
            });
        },

        async uploadFile(fileData) {
            fileData.uploading = true;
            this.uploading = true;

            try {
                const formData = new FormData();
                formData.append('files[]', fileData.file);

                const response = await fetch('/api/jpg-to-pdf/upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success && data.files && data.files.length > 0) {
                    const uploadedFile = data.files[0];
                    fileData.uploaded = true;
                    fileData.uploading = false;
                    fileData.imageId = uploadedFile.id;

                    // Move to uploaded images
                    this.uploadedImages.push({
                        id: uploadedFile.id,
                        name: uploadedFile.name,
                        size: uploadedFile.size,
                        type: uploadedFile.type,
                        preview: fileData.preview,
                    });

                    // Remove from selected files
                    this.selectedFiles = this.selectedFiles.filter(f => f.id !== fileData.id);

                    // Dispatch event
                    this.dispatchImagesUpdatedEvent();
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            } catch (error) {
                console.error('Upload error:', error);
                this.showToast('error', 'Upload Failed', error.message || 'Failed to upload image. Please try again.');
                fileData.uploading = false;
                // Remove failed file
                this.selectedFiles = this.selectedFiles.filter(f => f.id !== fileData.id);
            } finally {
                this.uploading = this.selectedFiles.some(f => f.uploading);
            }
        },

        removeImage(imageId) {
            this.uploadedImages = this.uploadedImages.filter(img => img.id !== imageId);
            this.dispatchImagesUpdatedEvent();
        },

        reorderImages(event) {
            const draggedIndex = event.detail.draggedIndex;
            const targetIndex = event.detail.targetIndex;

            if (draggedIndex !== null && targetIndex !== null && draggedIndex !== targetIndex) {
                const moved = this.uploadedImages.splice(draggedIndex, 1)[0];
                this.uploadedImages.splice(targetIndex, 0, moved);
                this.dispatchImagesReorderedEvent();
            }
        },

        moveUp(index) {
            if (index > 0) {
                const temp = this.uploadedImages[index];
                this.uploadedImages[index] = this.uploadedImages[index - 1];
                this.uploadedImages[index - 1] = temp;
                this.dispatchImagesReorderedEvent();
            }
        },

        moveDown(index) {
            if (index < this.uploadedImages.length - 1) {
                const temp = this.uploadedImages[index];
                this.uploadedImages[index] = this.uploadedImages[index + 1];
                this.uploadedImages[index + 1] = temp;
                this.dispatchImagesReorderedEvent();
            }
        },

        dispatchImagesUpdatedEvent() {
            window.dispatchEvent(new CustomEvent('images-uploaded', {
                detail: { images: [...this.uploadedImages] }
            }));
        },

        dispatchImagesReorderedEvent() {
            window.dispatchEvent(new CustomEvent('images-reordered', {
                detail: { images: [...this.uploadedImages] }
            }));
        },

        generateId() {
            return 'file_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
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
                alert(`${title}: ${message}`);
            }
        }
    };
}

