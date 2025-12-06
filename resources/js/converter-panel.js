import { ConverterManager } from './converters/converter-manager.js';

export function conversionPanel() {
    return {
        conversionStatus: 'idle', // idle, ready, converting, completed, error
        outputFileId: null,
        outputFileName: '',
        outputFileSize: '',

        converterManager: null,

        init() {
            // Initialize converter manager only once
            if (!this.converterManager) {
            this.converterManager = new ConverterManager('word');
            this.converterManager.init();
                console.log('ConverterManager initialized in conversion panel');
            }

            // Listen for conversion status updates
            window.addEventListener('conversion-update', (event) => {
                console.log('Conversion update received:', event.detail);
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
            window.addEventListener('file-uploaded', (event) => {
                console.log('File uploaded in panel:', event.detail);
                this.conversionStatus = 'ready';
                console.log('Panel status set to ready');
            });

            // Note: Conversion start is handled by ConverterManager.init()
            // No need to listen here to avoid duplicate API calls
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

