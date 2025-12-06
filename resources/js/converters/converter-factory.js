import { PdfToWordConverter } from './pdf-to-word.js';

export class ConverterFactory {
    /**
     * Create converter instance based on type
     */
    static create(type) {
        switch (type) {
            case 'word':
            case 'pdf-to-word':
                return new PdfToWordConverter();
            // Add more converters here as needed
            // case 'excel':
            // case 'pdf-to-excel':
            //     return new PdfToExcelConverter();
            default:
                throw new Error(`Unknown converter type: ${type}`);
        }
    }
}

