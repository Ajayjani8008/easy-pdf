export function conversionStatus() {
    return {
        status: 'idle', // idle, uploading, ready, converting, completed, error
        message: '',
        _converting: false, // Flag to prevent duplicate conversions
        _conversionTimeout: null, // Timeout reference for debouncing

        init() {
            console.log('Conversion status component initialized');
            
            // Listen for file upload events
            window.addEventListener('file-uploaded', (event) => {
                console.log('File uploaded event received:', event.detail);
                this.status = 'ready';
                this.message = 'File uploaded successfully. Click convert to proceed.';
                console.log('Status set to ready');
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
                    this._converting = false; // Reset flag
                } else if (event.detail.status === 'failed') {
                    this.status = 'error';
                    this.message = event.detail.error || 'Conversion failed. Please try again.';
                    this._converting = false; // Reset flag
                } else {
                    this.status = event.detail.status;
                    this.message = event.detail.message || '';
                }
            });
        },

        startConversion() {
            // Prevent multiple clicks/conversions
            if (this.status !== 'ready') {
                console.warn('Conversion already in progress or not ready. Status:', this.status);
                return;
            }
            
            // Prevent duplicate calls
            if (this._converting) {
                console.warn('Conversion already started, ignoring duplicate call');
                return;
            }
            
            this._converting = true;
            this.status = 'converting';
            this.message = 'Starting conversion...';
            
            // Use setTimeout to ensure the event is dispatched only once
            // This prevents rapid double-clicks from causing issues
            if (this._conversionTimeout) {
                clearTimeout(this._conversionTimeout);
            }
            
            this._conversionTimeout = setTimeout(() => {
                console.log('Dispatching start-conversion event (single dispatch)');
                window.dispatchEvent(new CustomEvent('start-conversion', {
                    bubbles: false, // Don't bubble to prevent multiple handlers
                    cancelable: true
                }));
                this._conversionTimeout = null;
            }, 10); // Small delay to debounce rapid clicks
        }
    };
}

