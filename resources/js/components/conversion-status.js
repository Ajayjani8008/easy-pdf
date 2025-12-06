export function conversionStatus() {
    return {
        status: 'idle', // idle, uploading, ready, converting, completed, error
        message: '',

        init() {
            // Listen for file upload events
            window.addEventListener('file-uploaded', () => {
                this.status = 'ready';
                this.message = 'File uploaded successfully. Click convert to proceed.';
            });

            // Listen for conversion start
            window.addEventListener('conversion-started', () => {
                this.status = 'converting';
                this.message = 'Converting your PDF to Word document...';
            });

            // Listen for conversion updates
            window.addEventListener('conversion-update', (event) => {
                if (event.detail.status === 'completed') {
                    this.status = 'completed';
                    this.message = 'Conversion completed successfully!';
                } else if (event.detail.status === 'failed') {
                    this.status = 'error';
                    this.message = event.detail.error || 'Conversion failed. Please try again.';
                } else {
                    this.status = event.detail.status;
                    this.message = event.detail.message || '';
                }
            });
        },

        startConversion() {
            if (this.status !== 'ready') return;
            
            this.status = 'converting';
            this.message = 'Starting conversion...';
            window.dispatchEvent(new CustomEvent('start-conversion'));
        }
    };
}

