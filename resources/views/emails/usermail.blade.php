<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Account Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            margin: 20px 0;
        }
        .content p {
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Task Management System</h1>
        </div>
        <div class="content">
            <p>Hi {{ $user['name'] }},</p>
            <p>We're excited to let you know that your account has been created successfully!</p>
            <p><strong>Email:</strong> {{ $user['email'] }}</p>
            <p><strong>Password:</strong> {{ $user['password'] }}</p>
            <!-- <p>Please click the link below to set your password and start managing your tasks:</p>
            <a href="#" class="btn">Set Your Password</a> -->
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Task Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
