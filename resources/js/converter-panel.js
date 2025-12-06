import { ConverterManager } from './converters/converter-manager.js';

export function conversionPanel() {
    return {
        conversionStatus: 'idle', // idle, ready, converting, completed, error
        outputFileId: null,
        outputFileName: '',
        outputFileSize: '',

        converterManager: null,

        init() {
            // Initialize converter manager
            this.converterManager = new ConverterManager('word');
            this.converterManager.init();

            // Listen for conversion status updates
            window.addEventListener('conversion-update', (event) => {
                this.conversionStatus = event.detail.status;
                
                if (event.detail.status === 'completed' && event.detail.output_file) {
                    this.outputFileId = event.detail.output_file.id;
                    this.outputFileName = event.detail.output_file.name;
                    this.outputFileSize = event.detail.output_file.size;
                } else if (event.detail.status === 'error') {
                    this.conversionStatus = 'error';
                }
            });

            // Listen for file upload
            window.addEventListener('file-uploaded', () => {
                this.conversionStatus = 'ready';
            });

            // Listen for conversion start
            window.addEventListener('start-conversion', async () => {
                if (this.converterManager && this.converterManager.currentFileId) {
                    try {
                        await this.converterManager.convert(this.converterManager.currentFileId);
                    } catch (error) {
                        console.error('Conversion error:', error);
                        this.conversionStatus = 'error';
                    }
                }
            });
        },

        downloadFile() {
            if (this.outputFileId) {
                window.location.href = `/api/files/${this.outputFileId}/download`;
            } else if (this.converterManager && this.converterManager.outputFileId) {
                window.location.href = `/api/files/${this.converterManager.outputFileId}/download`;
            }
        }
    };
}

