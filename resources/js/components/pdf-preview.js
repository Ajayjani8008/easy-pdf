export function pdfPreview() {
    return {
        uploadedFileId: null,
        fileName: '',
        fileSize: '',
        loading: false,
        converting: false,
        converted: false,

        init() {
            const component = this;
            
            // Listen for file upload events
            window.addEventListener('file-uploaded', (event) => {
                component.uploadedFileId = event.detail.id;
                component.fileName = event.detail.name || event.detail.original_name || 'PDF Document';
                component.fileSize = component.formatFileSize(event.detail.size || 0);
                component.loading = true;
                component.converting = false;
                component.converted = false;
                
                // Simulate loading (in real app, you'd fetch PDF preview)
                setTimeout(() => {
                    component.loading = false;
                }, 1000);
            });

            // Listen for conversion start
            window.addEventListener('conversion-started', () => {
                component.converting = true;
                component.converted = false;
            });

            // Listen for conversion updates
            window.addEventListener('conversion-update', (event) => {
                if (event.detail.status === 'completed') {
                    component.converting = false;
                    component.converted = true;
                } else if (event.detail.status === 'failed' || event.detail.status === 'error') {
                    component.converting = false;
                    component.converted = false;
                }
            });
        },
        
        formatFileSize(bytes) {
            if (!bytes || bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
    };
}

