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
    }

    /**
     * Initialize the converter manager
     */
    init() {
        // Listen for file upload
        window.addEventListener('file-uploaded', (event) => {
            this.currentFileId = event.detail.id;
        });

        // Listen for conversion start request
        window.addEventListener('start-conversion', async () => {
            if (this.currentFileId) {
                try {
                    await this.convert(this.currentFileId);
                } catch (error) {
                    console.error('Conversion failed:', error);
                }
            }
        });

        // Listen for conversion completion
        window.addEventListener('conversion-update', (event) => {
            if (event.detail.status === 'completed' && event.detail.output_file) {
                this.outputFileId = event.detail.output_file.id;
                this.outputFileName = event.detail.output_file.name;
                
                // Dispatch completion event
                window.dispatchEvent(new CustomEvent('conversion-completed', {
                    detail: event.detail.output_file
                }));
            }
        });
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

