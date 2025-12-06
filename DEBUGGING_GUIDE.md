# Debugging Guide - Right Panel Not Showing

## Step-by-Step Debugging

### 1. Check Browser Console
Open browser DevTools (F12) and check the Console tab. You should see:
- "Conversion panel initialized"
- "Conversion status component initialized"
- "File uploaded successfully: {file object}"
- "file-uploaded event dispatched"
- "File uploaded in panel: {file object}"
- "Panel status set to ready"
- "File uploaded event received: {file object}"
- "Status set to ready"

### 2. Check Network Tab
- Verify `/api/upload` request returns `200 OK`
- Check response contains `success: true` and `file` object

### 3. Verify Alpine.js is Loaded
In browser console, type:
```javascript
window.Alpine
```
Should return an object (not undefined)

### 4. Check Event Listener
In browser console, type:
```javascript
window.addEventListener('file-uploaded', (e) => console.log('Test listener:', e.detail));
```
Then upload a file. You should see the log.

### 5. Manual Event Test
In browser console, type:
```javascript
window.dispatchEvent(new CustomEvent('file-uploaded', { detail: { id: 'test', name: 'test.pdf', size: '1 KB' } }));
```
The panel should update to show "Convert to Word" button.

## Common Issues

### Issue 1: Alpine.js Not Loaded
**Symptom**: No console logs, components not reactive
**Solution**: Check if Alpine.js CDN is loading in Network tab

### Issue 2: Event Not Firing
**Symptom**: Upload succeeds but no console logs
**Solution**: Check if `file-uploaded` event is being dispatched in file-upload.js

### Issue 3: Event Not Received
**Symptom**: Event fires but status doesn't update
**Solution**: Check if event listeners are registered before event fires

### Issue 4: Status Not Updating
**Symptom**: Status stays 'idle'
**Solution**: Check Alpine.js reactivity - try `$watch` or `$nextTick`

## Quick Fixes

### Force Status Update
Add this to conversion-status.js init():
```javascript
this.$watch('status', (value) => {
    console.log('Status changed to:', value);
});
```

### Force Panel Update
Add this to conversion-panel.js init():
```javascript
this.$watch('conversionStatus', (value) => {
    console.log('Panel status changed to:', value);
});
```

## Expected Flow

1. User selects PDF → `selectedFile` set
2. User clicks "Upload PDF" → `uploading = true`
3. API call to `/api/upload` → Response received
4. `file-uploaded` event dispatched → All listeners receive it
5. `conversionStatus` set to `'ready'` → Panel shows button
6. `status` set to `'ready'` → Status component shows button

## Visual Check

After upload, the right panel should show:
- Title: "Conversion"
- Blue box with message: "File uploaded successfully..."
- Blue button: "Convert to Word"

If you see "Upload a PDF file to get started" instead, the status is still 'idle'.

