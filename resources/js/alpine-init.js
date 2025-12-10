// This file ensures Alpine functions are available before Alpine initializes
// Import and register all Alpine components

import { fileUpload } from './components/file-upload.js';
import { pdfPreview } from './components/pdf-preview.js';
import { conversionStatus } from './components/conversion-status.js';
import { conversionPanel } from './converter-panel.js';
import { mergeFileUpload } from './components/merge-file-upload.js';
import { mergePanel } from './components/merge-panel.js';
import { splitPanel } from './components/split-panel.js';
import { compressPanel } from './components/compress-panel.js';
import { pdfToJpgPanel } from './components/pdf-to-jpg-panel.js';
import { jpgToPdfUpload } from './components/jpg-to-pdf-upload.js';
import { jpgToPdfPanel } from './components/jpg-to-pdf-panel.js';
import { pdfToExcelPanel } from './components/pdf-to-excel-panel.js';

// Make functions available globally immediately
window.fileUpload = fileUpload;
window.pdfPreview = pdfPreview;
window.conversionStatus = conversionStatus;
window.conversionPanel = conversionPanel;
window.mergeFileUpload = mergeFileUpload;
window.mergePanel = mergePanel;
window.splitPanel = splitPanel;
window.compressPanel = compressPanel;
window.pdfToJpgPanel = pdfToJpgPanel;
window.jpgToPdfUpload = jpgToPdfUpload;
window.jpgToPdfPanel = jpgToPdfPanel;
window.pdfToExcelPanel = pdfToExcelPanel;


