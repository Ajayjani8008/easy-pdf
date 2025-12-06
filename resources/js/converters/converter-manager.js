import { ConverterFactory } from './converter-factory.js';

/**
 * Global converter manager
 * Handles conversion workflow and coordinates between components
 */
export class ConverterManager {
    constructor(conversionType = 'word') {
        this.converter = ConverterFactory.create(conversionType);
        this.currentFileId = null;
        this.outputFileId = null;
        this.outputFileName = null;
        this._initialized = false;
        this._isConverting = false;
    }

    /**
     * Initialize the converter manager
     */
    init() {
        // Prevent multiple initializations
        if (this._initialized) {
            console.warn('ConverterManager already initialized, skipping');
            return;
        }
        this._initialized = true;

        // Listen for file upload
        const fileUploadHandler = (event) => {
            this.currentFileId = event.detail.id;
        };
        window.addEventListener('file-uploaded', fileUploadHandler);
        this._fileUploadHandler = fileUploadHandler; // Store reference for cleanup

        // Listen for conversion start request
        const startConversionHandler = async () => {
            // Prevent duplicate conversions
            if (this._isConverting) {
                console.warn('Conversion already in progress, ignoring duplicate request');
                return;
            }
            
            if (!this.currentFileId) {
                console.warn('No file ID available for conversion');
                return;
            }
            
            this._isConverting = true;
            console.log('ConverterManager: Starting conversion for file:', this.currentFileId);
            
            try {
                await this.convert(this.currentFileId);
            } catch (error) {
                console.error('Conversion failed:', error);
                this._isConverting = false; // Reset on error
            }
        };
        
        window.addEventListener('start-conversion', startConversionHandler);
        this._startConversionHandler = startConversionHandler; // Store reference for cleanup

        // Listen for conversion completion
        const conversionUpdateHandler = (event) => {
            if (event.detail.status === 'completed' && event.detail.output_file) {
                this.outputFileId = event.detail.output_file.id;
                this.outputFileName = event.detail.output_file.name;
                this._isConverting = false; // Reset flag
                
                // Dispatch completion event
                window.dispatchEvent(new CustomEvent('conversion-completed', {
                    detail: event.detail.output_file
                }));
            } else if (event.detail.status === 'failed' || event.detail.status === 'error') {
                this._isConverting = false; // Reset flag on failure
            }
        };
        window.addEventListener('conversion-update', conversionUpdateHandler);
        this._conversionUpdateHandler = conversionUpdateHandler; // Store reference for cleanup
    }

    /**
     * Cleanup event listeners (optional, for cleanup if needed)
     */
    destroy() {
        if (this._fileUploadHandler) {
            window.removeEventListener('file-uploaded', this._fileUploadHandler);
        }
        if (this._startConversionHandler) {
            window.removeEventListener('start-conversion', this._startConversionHandler);
        }
        if (this._conversionUpdateHandler) {
            window.removeEventListener('conversion-update', this._conversionUpdateHandler);
        }
        this._initialized = false;
    }

    /**
     * Start conversion
     */
    async convert(fileId) {
        return await this.converter.convert(fileId);
    }

    /**
     * Download converted file
     */
    downloadFile() {
        if (this.outputFileId) {
            window.location.href = `/api/files/${this.outputFileId}/download`;
        }
    }
}

