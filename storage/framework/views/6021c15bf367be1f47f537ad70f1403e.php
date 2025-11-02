<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f4f4f4;
            border-radius: 5px;
            padding: 30px;
        }
        .code-box {
            background-color: #fff;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
            letter-spacing: 5px;
        }
        .warning {
            color: #ff9800;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>
        <p>You have requested to reset your password. Use the code below to complete the process:</p>
        
        <div class="code-box">
            <div class="code"><?php echo e($code); ?></div>
        </div>
        
        <p>This code will expire in <strong>15 minutes</strong>.</p>
        
        <p>If you did not request a password reset, please ignore this email or contact support if you have concerns.</p>
        
        <div class="warning">
            <strong>Security Notice:</strong> Never share this code with anyone. Our team will never ask for this code.
        </div>
    </div>
</body>
</html><?php /**PATH C:\wamp64\www\healthissuedetector\health-detector-api\resources\views/emails/reset-password.blade.php ENDPATH**/ ?>