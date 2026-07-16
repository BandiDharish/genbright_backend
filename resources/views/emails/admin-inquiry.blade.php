<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Inquiry Received - GenBright</title>
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
            border-bottom: 3px solid #d97706;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }
        .content {
            padding: 40px 35px;
        }
        .title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-table th, .info-table td {
            padding: 12px 15px;
            text-align: left;
            font-size: 15px;
        }
        .info-table th {
            width: 35%;
            color: #64748b;
            font-weight: 600;
            background-color: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
        }
        .info-table td {
            color: #334155;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }
        .message-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px 20px;
            margin-top: 10px;
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
            white-space: pre-wrap;
        }
        .message-label {
            font-size: 15px;
            font-weight: 600;
            color: #64748b;
            margin-top: 20px;
            margin-bottom: 8px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #94a3b8;
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>GenBright Administration</h1>
            </div>

            <!-- Content Area -->
            <div class="content">
                <div class="title">
                    New Inquiry Received
                </div>

                <table class="info-table">
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $data['name'] }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $data['mobile'] }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><a href="mailto:{{ $data['email'] }}" style="color: #d97706; text-decoration: none;">{{ $data['email'] }}</a></td>
                    </tr>
                    <tr>
                        <th>Date &amp; Time</th>
                        <td>{{ $data['datetime'] }}</td>
                    </tr>
                </table>

                <div class="message-label">Message:</div>
                @if(!empty($data['message']))
                    <div class="message-box">{{ $data['message'] }}</div>
                @else
                    <div class="message-box" style="font-style: italic; color: #94a3b8;">No message was provided.</div>
                @endif
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>This is an automated notification from the GenBright Contact Form system.</p>
            </div>
        </div>
    </div>
</body>
</html>
