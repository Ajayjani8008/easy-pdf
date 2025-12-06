// This file ensures Alpine functions are available before Alpine initializes
// Import and register all Alpine components

import { fileUpload } from './components/file-upload.js';
import { pdfPreview } from './components/pdf-preview.js';
import { conversionStatus } from './components/conversion-status.js';
import { conversionPanel } from './converter-panel.js';

// Make functions available globally immediately
window.fileUpload = fileUpload;
window.pdfPreview = pdfPreview;
window.conversionStatus = conversionStatus;
window.conversionPanel = conversionPanel;


