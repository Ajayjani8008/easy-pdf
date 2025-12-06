export function pdfPreview() {
    return {
        uploadedFileId: null,
        fileName: '',
        fileSize: '',
        loading: false,

        init() {
            // Listen for file upload events
            window.addEventListener('file-uploaded', (event) => {
                this.uploadedFileId = event.detail.id;
                this.fileName = event.detail.name;
                this.fileSize = event.detail.size;
                this.loading = true;
                
                // Simulate loading (in real app, you'd fetch PDF preview)
                setTimeout(() => {
                    this.loading = false;
                }, 1000);
            });
        }
    };
}

