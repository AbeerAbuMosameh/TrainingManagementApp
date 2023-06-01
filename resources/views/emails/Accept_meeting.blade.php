<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h3>Accept Meeting</h3>

    <p>Dear {{ $advisorName }},</p>

    <p>Your meeting request for the program "{{ $programName }}" has been accepted.</p>

    <p>Meeting Details:</p>
    <ul>
        <li>Date: {{ $date }}</li>
        <li>Time: {{ $time }}</li>
    </ul>

    <p>Link of meeting will send before one hour of meeting</p>
    <p>Thank you for using Training Hub.</p>

    <p>Best regards,</p>
    <p>The Training Hub Team</p>

    <hr>
</body>
</html>
