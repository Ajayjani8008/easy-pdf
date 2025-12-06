export function jpgToPdfPanel() {
    return {
        uploadedImages: [],
        converting: false,
        converted: false,
        outputFile: null,
        conversion: null,
        
        // Options
        pageSize: 'a4',
        orientation: 'portrait',
        fitMode: 'fit',
        margin: 'small',
        customMargin: 10,
        customWidth: null,
        customHeight: null,
        compression: 'balanced',
        
        // UI state
        showCustomSize: false,
        showCustomMargin: false,

        init() {
            const component = this;
            
            // Listen for image uploads
            window.addEventListener('images-uploaded', (event) => {
                const newImages = event.detail.images || [];
                const previousCount = component.uploadedImages.length;
                
                // If new images were added (count increased) and conversion was completed, reset conversion state
                if (newImages.length > previousCount && component.converted) {
                    component.resetState();
                }
                
                component.uploadedImages = newImages;
            });
            
            // Listen for image reordering
            window.addEventListener('images-reordered', (event) => {
                component.uploadedImages = event.detail.images || [];
            });
        },

        getImageIds() {
            return this.uploadedImages.map(img => img.id).filter(id => id);
        },

        canConvert() {
            return this.uploadedImages.length > 0 && !this.converting;
        },

        async startConvert() {
            if (!this.canConvert()) {
                this.showToast('warning', 'No Images', 'Please upload at least one image first.');
                return;
            }

            const imageIds = this.getImageIds();
            if (imageIds.length === 0) {
                this.showToast('error', 'No Images', 'Please wait for images to finish uploading.');
                return;
            }

            this.converting = true;
            this.converted = false;

            this.showToast('info', 'Conversion Started', 'Converting images to PDF. Please wait...');

            try {
                const options = {
                    page_size: this.pageSize,
                    orientation: this.orientation,
                    fit_mode: this.fitMode,
                    margin: this.margin,
                    compression: this.compression,
                };

                if (this.pageSize === 'custom' && this.customWidth && this.customHeight) {
                    options.custom_width = parseFloat(this.customWidth);
                    options.custom_height = parseFloat(this.customHeight);
                }

                if (this.margin === 'custom') {
                    options.custom_margin = parseFloat(this.customMargin);
                }

                const response = await fetch('/api/jpg-to-pdf/convert', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        file_ids: imageIds,
                        ...options
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.converting = false;
                    this.converted = true;
                    this.outputFile = data.file;
                    this.conversion = data.conversion;
                    this.showToast('success', 'Conversion Complete', `Your PDF has been created successfully! ${data.conversion.image_count} images converted.`);
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
                this.showToast('info', 'Download Started', 'Your PDF is downloading...');
                
                // After download, reset conversion state to allow re-conversion with different settings
                setTimeout(() => {
                    this.resetState();
                }, 1000);
            } else {
                this.showToast('error', 'Download Failed', 'File not available for download.');
            }
        },

        resetState() {
            // Reset conversion state but keep images and settings
            // This allows user to adjust settings and convert again
            this.converting = false;
            this.converted = false;
            this.outputFile = null;
            this.conversion = null;
            // Keep uploadedImages, pageSize, orientation, fitMode, margin, compression, etc.
            // So user can adjust settings and convert again
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
