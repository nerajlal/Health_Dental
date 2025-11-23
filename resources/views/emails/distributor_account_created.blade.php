<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Dental Supply Management System</title>
</head>
<body>
    <h1>Welcome, {{ $distributor->name }}!</h1>
    <p>Your distributor account has been successfully created.</p>
    <p>Here are your login details:</p>
    <ul>
        <li><strong>Email:</strong> {{ $distributor->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please login and change your password immediately.</p>
    <p><a href="{{ route('login') }}">Click here to login</a></p>
    <p>Thank you,<br>Dental Supply Management Team</p>
</body>
</html>
