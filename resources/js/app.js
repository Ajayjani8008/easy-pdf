import './bootstrap';

// Import converter components
import { fileUpload } from './components/file-upload.js';
import { pdfPreview } from './components/pdf-preview.js';
import { conversionStatus } from './components/conversion-status.js';
import { conversionPanel } from './converter-panel.js';

// Make functions available globally for Alpine.js
window.fileUpload = fileUpload;
window.pdfPreview = pdfPreview;
window.conversionStatus = conversionStatus;
window.conversionPanel = conversionPanel;
