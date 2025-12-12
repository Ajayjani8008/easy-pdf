export class BaseConverter {
    constructor(conversionType) {
        this.conversionType = conversionType;
        this.jobId = null;
        this.statusCheckInterval = null;
    }

    /**
     * Start conversion process
     */
    async convert(fileId) {
        // Prevent duplicate API calls
        if (this._converting) {
            console.warn('Conversion already in progress, ignoring duplicate call');
            return { success: false, message: 'Conversion already in progress' };
        }
        
        this._converting = true;
        
        try {
            console.log(`BaseConverter: Making API call to /api/convert/${this.conversionType} for file:`, fileId);
            
            const response = await fetch(`/api/convert/${this.conversionType}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ file_id: fileId })
            });

            const data = await response.json();

            if (data.success) {
                this.jobId = data.job.id;
                // Dispatch conversion started event
                this.showToast('success', 'Conversion Started', 'Conversion started successfully.');
                window.dispatchEvent(new CustomEvent('conversion-started'));
                this.startStatusPolling();
                return data;
            } else {
                this._converting = false; // Reset on failure
                throw new Error(data.message || 'Conversion failed to start');
            }
        } catch (error) {
            this._converting = false; // Reset on error
            window.dispatchEvent(new CustomEvent('conversion-update', {
                detail: {
                    status: 'error',
                    error: error.message
                }
            }));
            throw error;
        }
    }

    /**
     * Poll for conversion status
     */
    startStatusPolling() {
        this.statusCheckInterval = setInterval(async () => {
            try {
                const response = await fetch(`/api/conversions/${this.jobId}/status`);
                const data = await response.json();

                if (data.success) {
                    window.dispatchEvent(new CustomEvent('conversion-update', {
                        detail: {
                            status: data.job.status,
                            message: this.getStatusMessage(data.job.status),
                            ...data.job
                        }
                    }));

                    if (data.job.status === 'completed' || data.job.status === 'failed') {
                        this.stopStatusPolling();
                        this._converting = false; // Reset flag when done
                    }
                }
            } catch (error) {
                console.error('Status check error:', error);
                this.stopStatusPolling();
                window.dispatchEvent(new CustomEvent('conversion-update', {
                    detail: {
                        status: 'error',
                        error: 'Failed to check conversion status'
                    }
                }));
            }
        }, 2000); // Check every 2 seconds
    }

    /**
     * Stop polling for status
     */
    stopStatusPolling() {
        if (this.statusCheckInterval) {
            clearInterval(this.statusCheckInterval);
            this.statusCheckInterval = null;
        }
    }

    /**
     * Get status message
     */
    getStatusMessage(status) {
        const messages = {
            'pending': 'Conversion is queued...',
            'processing': 'Converting your PDF...',
            'completed': 'Conversion completed!',
            'failed': 'Conversion failed'
        };
        return messages[status] || 'Processing...';
    }
    showToast(type, title, message) {
        if (window.showToast) {
            window.showToast(type, title, message);
        } else {
            console.warn('Toast system not available');
            alert(`${title}: ${message}`);
        }
    }
}

