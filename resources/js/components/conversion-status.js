export function conversionStatus() {
    return {
        status: 'idle', // idle, uploading, ready, converting, completed, error
        message: '',
        _converting: false, // Flag to prevent duplicate conversions
        _conversionTimeout: null, // Timeout reference for debouncing
        conversionProgress: 0, // Progress percentage (0-100)
        conversionTime: '0s', // Elapsed time string
        startTime: null, // Timestamp when conversion started
        progressInterval: null, // Interval for updating progress

        init() {
            
            // Store reference to component for event handlers
            const component = this;
            
            // Check for pending events first (events that fired before component initialized)
            if (window._pendingFileUploadEvents && window._pendingFileUploadEvents.length > 0) {
                const lastEvent = window._pendingFileUploadEvents[window._pendingFileUploadEvents.length - 1];
                component.status = 'ready';
                component.message = 'File uploaded successfully. Click convert to proceed.';
                // Clear processed events
                window._pendingFileUploadEvents = [];
            }
            
            // Listen for file upload events - use arrow function to preserve 'this'
            const handleFileUploaded = (event) => {
                component.status = 'ready';
                component.message = 'File uploaded successfully. Click convert to proceed.';
            };
            
            // Register event listener
            window.addEventListener('file-uploaded', handleFileUploaded);

            // Listen for conversion start
            const handleConversionStarted = () => {
                component.status = 'converting';
                component.message = 'Converting your PDF to Word document...';
                component.startProgressTracking();
            };
            window.addEventListener('conversion-started', handleConversionStarted);

            // Listen for conversion updates
            const handleConversionUpdate = (event) => {
                if (event.detail.status === 'completed') {
                    component.status = 'completed';
                    component.message = 'Conversion completed successfully!';
                    component._converting = false; // Reset flag
                    component.stopProgressTracking();
                    component.conversionProgress = 100;
                } else if (event.detail.status === 'failed') {
                    component.status = 'error';
                    component.message = event.detail.error || 'Conversion failed. Please try again.';
                    component._converting = false; // Reset flag
                    component.stopProgressTracking();
                } else {
                    component.status = event.detail.status;
                    component.message = event.detail.message || '';
                    // Update progress if provided
                    if (event.detail.progress !== undefined) {
                        component.conversionProgress = Math.min(100, Math.max(0, event.detail.progress));
                }
                }
            };
            window.addEventListener('conversion-update', handleConversionUpdate);
        },

        startProgressTracking() {
            // Reset progress
            this.conversionProgress = 0;
            this.startTime = Date.now();
            this.conversionTime = '0s';
            
            // Clear any existing interval
            if (this.progressInterval) {
                clearInterval(this.progressInterval);
            }
            
            // Simulate progress (since we don't have real-time progress from backend)
            // This creates a smooth animation effect
            let progress = 0;
            this.progressInterval = setInterval(() => {
                // Update elapsed time
                const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
                this.conversionTime = elapsed + 's';
                
                // Simulate progress (slow down as it approaches 90%)
                if (progress < 90) {
                    progress += Math.random() * 3 + 1; // Random increment between 1-4%
                    this.conversionProgress = Math.min(90, Math.floor(progress));
                }
            }, 500); // Update every 500ms
        },

        stopProgressTracking() {
            if (this.progressInterval) {
                clearInterval(this.progressInterval);
                this.progressInterval = null;
            }
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
            this.startProgressTracking();
            
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

