<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting GenBright</title>
    <style>
        body {
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0f172a;
            padding: 30px;
            text-align: center;
            border-bottom: 3px solid #d97706; /* Elegant gold border */
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .content {
            padding: 40px 35px;
            line-height: 1.6;
        }
        .salutation {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 20px;
        }
        .message-body {
            font-size: 16px;
            color: #475569;
            margin-bottom: 30px;
        }
        .signoff {
            font-size: 15px;
            color: #334155;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }
        .signoff-name {
            font-weight: 600;
            color: #0f172a;
            margin-top: 4px;
        }
        .footer {
            text-align: center;
            padding: 25px;
            font-size: 13px;
            color: #94a3b8;
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
        }
        .footer a {
            color: #d97706;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>GenBright</h1>
            </div>

            <!-- Content Area -->
            <div class="content">
                <div class="salutation">
                    Dear {{ $data['name'] }},
                </div>

                <div class="message-body">
                    <p>Thank you for contacting GenBright.</p>
                    <p>We have received your inquiry successfully. Our admissions team will contact you soon.</p>
                </div>

                <div class="signoff">
                    Regards,<br>
                    <div class="signoff-name">GenBright Admissions Team</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>&copy; {{ date('Y') }} GenBright. All rights reserved.</p>
                <p>If you have any urgent queries, please reply to this email or visit our website.</p>
            </div>
        </div>
    </div>
</body>
</html>
