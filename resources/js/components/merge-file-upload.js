export function mergeFileUpload() {
    return {
        isDragging: false,
        selectedFiles: [],
        uploading: false,
        uploadedFiles: [],
        minFiles: 2,
        maxFiles: 10,

        init() {
            // Listen for file removal
            window.addEventListener('remove-file', (event) => {
                this.removeFile(event.detail.fileId);
            });
        },

        handleDrop(event) {
            event.preventDefault();
            this.isDragging = false;
            const files = Array.from(event.dataTransfer.files);
            this.handleFiles(files);
        },

        handleFileSelect(event) {
            const file = event.target.files[0]; // Only take first file (one-by-one selection)
            if (file) {
                this.handleFile(file);
            }
            // Reset input so same file can be selected again
            event.target.value = '';
        },

        handleFile(file) {
            // Validate file type
            if (file.type !== 'application/pdf') {
                this.showToast('error', 'Invalid File Type', 'Please select a PDF file only.');
                return;
            }

            // Check total file count
            if (this.selectedFiles.length >= this.maxFiles) {
                this.showToast('warning', 'Maximum Files Reached', `Maximum ${this.maxFiles} files allowed. Please remove a file first.`);
                return;
            }

            // Validate file size (50MB)
            if (file.size > 50 * 1024 * 1024) {
                this.showToast('error', 'File Too Large', `File "${file.name}" exceeds 50MB limit.`);
                return;
            }

            // Check if file already exists
            if (this.selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                this.showToast('warning', 'File Already Added', `File "${file.name}" is already in the list.`);
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
                fileId: null,
            };

            this.selectedFiles.push(fileData);

            // Auto-upload the file
            this.uploadFile(fileData);
        },

        handleFiles(files) {
            // Handle multiple files from drag & drop (still allow drag multiple)
            const pdfFiles = files.filter(file => file.type === 'application/pdf');
            
            if (pdfFiles.length === 0) {
                this.showToast('error', 'Invalid Files', 'Please select PDF files only.');
                return;
            }

            // Check total file count
            const totalFiles = this.selectedFiles.length + pdfFiles.length;
            if (totalFiles > this.maxFiles) {
                this.showToast('warning', 'Too Many Files', `Maximum ${this.maxFiles} files allowed. You already have ${this.selectedFiles.length} files.`);
                return;
            }

            // Validate and add files one by one
            pdfFiles.forEach(file => {
                // Validate file size (50MB)
                if (file.size > 50 * 1024 * 1024) {
                    this.showToast('error', 'File Too Large', `File "${file.name}" exceeds 50MB limit.`);
                    return;
                }

                // Check if file already exists
                if (this.selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    this.showToast('warning', 'File Already Added', `File "${file.name}" is already in the list.`);
                    return;
                }

                const fileData = {
                    id: this.generateId(),
                    file: file,
                    name: file.name,
                    size: file.size,
                    sizeText: this.formatFileSize(file.size),
                    uploading: false,
                    uploaded: false,
                    fileId: null,
                };

                this.selectedFiles.push(fileData);
                // Upload each file individually
                this.uploadFile(fileData);
            });
        },

        async uploadAllFiles() {
            if (this.selectedFiles.length === 0) return;

            // Upload files that haven't been uploaded yet
            const filesToUpload = this.selectedFiles.filter(f => !f.uploaded);
            
            // Upload all files at once in a single request
            if (filesToUpload.length > 0) {
                await this.uploadFilesBatch(filesToUpload);
            }
        },

        async uploadFile(fileData) {
            fileData.uploading = true;
            const formData = new FormData();
            formData.append('files[]', fileData.file);

            try {
                const response = await fetch('/api/merge/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success && data.files && data.files.length > 0) {
                    const uploadedFile = data.files.find(f => f.name === fileData.name) || data.files[0];
                    
                    fileData.uploaded = true;
                    fileData.fileId = uploadedFile.id;
                    fileData.uploadedName = uploadedFile.name;
                    fileData.uploadedSize = uploadedFile.size;

                    // Add to uploaded files list
                    this.uploadedFiles.push({
                        id: fileData.id,
                        fileId: uploadedFile.id,
                        name: fileData.name,
                        size: fileData.sizeText,
                    });

                    // Show success toast
                    this.showToast('success', 'File Uploaded', `"${fileData.name}" uploaded successfully.`);

                    // Dispatch event for other components
                    window.dispatchEvent(new CustomEvent('files-updated-merge', {
                        detail: { files: this.uploadedFiles }
                    }));
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            } catch (error) {
                console.error('Upload error:', error);
                this.showToast('error', 'Upload Failed', `Failed to upload "${fileData.name}": ${error.message}`);
                // Remove failed file
                this.removeFile(fileData.id);
            } finally {
                fileData.uploading = false;
            }
        },

        async uploadFile(fileData) {
            fileData.uploading = true;
            const formData = new FormData();
            formData.append('files[]', fileData.file);

            try {
                const response = await fetch('/api/merge/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success && data.files && data.files.length > 0) {
                    // Find the uploaded file that matches this file
                    const uploadedFile = data.files.find(f => f.name === fileData.name) || data.files[0];
                    fileData.uploaded = true;
                    fileData.fileId = uploadedFile.id;
                    fileData.uploadedName = uploadedFile.name;
                    fileData.uploadedSize = uploadedFile.size;

                    // Add to uploaded files list
                    this.uploadedFiles.push({
                        id: fileData.id,
                        fileId: uploadedFile.id,
                        name: fileData.name,
                        size: fileData.sizeText,
                    });

                    // Show success toast
                    this.showToast('success', 'File Uploaded', `"${fileData.name}" uploaded successfully. ${this.uploadedFiles.length} of ${this.minFiles} files ready.`);

                    // Dispatch event for other components
                    window.dispatchEvent(new CustomEvent('file-uploaded-merge', {
                        detail: {
                            file: uploadedFile,
                            allFiles: this.uploadedFiles,
                        }
                    }));

                    // Dispatch ready event if we have enough files
                    if (this.uploadedFiles.length >= this.minFiles) {
                        window.dispatchEvent(new CustomEvent('merge-ready', {
                            detail: { files: this.uploadedFiles }
                        }));
                    }
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            } catch (error) {
                console.error('Upload error:', error);
                this.showToast('error', 'Upload Failed', `Failed to upload "${fileData.name}": ${error.message}`);
                // Remove failed file
                this.removeFile(fileData.id);
            } finally {
                fileData.uploading = false;
            }
        },

        removeFile(fileId) {
            // Remove from selected files
            this.selectedFiles = this.selectedFiles.filter(f => f.id !== fileId);
            // Remove from uploaded files
            this.uploadedFiles = this.uploadedFiles.filter(f => f.id !== fileId);
            
            // Dispatch event
            window.dispatchEvent(new CustomEvent('files-updated-merge', {
                detail: { files: this.uploadedFiles }
            }));
        },

        reorderFiles(fromIndex, toIndex) {
            // Reorder uploaded files
            const [moved] = this.uploadedFiles.splice(fromIndex, 1);
            this.uploadedFiles.splice(toIndex, 0, moved);

            // Also reorder selected files to keep in sync
            const selectedFrom = this.selectedFiles.findIndex(f => f.id === moved.id);
            if (selectedFrom !== -1) {
                const [movedSelected] = this.selectedFiles.splice(selectedFrom, 1);
                const selectedTo = this.selectedFiles.findIndex(f => {
                    const uploadedIndex = this.uploadedFiles.findIndex(uf => uf.id === f.id);
                    return uploadedIndex >= toIndex;
                });
                if (selectedTo !== -1) {
                    this.selectedFiles.splice(selectedTo, 0, movedSelected);
                } else {
                    this.selectedFiles.push(movedSelected);
                }
            }

            // Dispatch event
            window.dispatchEvent(new CustomEvent('files-reordered-merge', {
                detail: { files: this.uploadedFiles }
            }));
        },

        getFileIds() {
            return this.uploadedFiles.map(f => f.fileId).filter(id => id !== null);
        },

        canMerge() {
            return this.uploadedFiles.length >= this.minFiles && 
                   this.uploadedFiles.every(f => f.fileId !== null);
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
            // Use global toast notification system
            if (window.showToast) {
                window.showToast(type, title, message);
            } else {
                // Fallback to alert if toast system not available
                console.warn('Toast system not available, using alert');
                alert(`${title}: ${message}`);
            }
        }
    };
}

