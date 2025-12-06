import { BaseConverter } from './base-converter.js';

export class PdfToWordConverter extends BaseConverter {
    constructor() {
        super('word');
    }

    /**
     * Get download URL for converted file
     */
    getDownloadUrl(fileId) {
        return `/api/files/${fileId}/download`;
    }
}

