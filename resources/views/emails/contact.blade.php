<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4DABF7;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .field {
            margin-bottom: 15px;
        }
        .field strong {
            display: inline-block;
            width: 120px;
            color: #555;
        }
        .message-content {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #4DABF7;
            margin-top: 10px;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
        <p>EasyPDF Pro - Contact Form</p>
    </div>
    
    <div class="content">
        <div class="field">
            <strong>Name:</strong> {{ $name }}
        </div>
        
        <div class="field">
            <strong>Email:</strong> {{ $email }}
        </div>
        
        <div class="field">
            <strong>Subject:</strong> {{ $subject }}
        </div>
        
        <div class="field">
            <strong>Submitted:</strong> {{ $submitted_at->format('F j, Y \a\t g:i A') }}
        </div>
        
        <div class="field">
            <strong>IP Address:</strong> {{ $ip_address }}
        </div>
        
        <div class="field">
            <strong>Message:</strong>
            <div class="message-content">
                {{ $message }}
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>This email was sent from the EasyPDF Pro contact form.</p>
        <p>Reply directly to this email to respond to {{ $name }}.</p>
    </div>
</body>
</html>