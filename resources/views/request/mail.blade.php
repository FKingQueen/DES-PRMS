<!DOCTYPE html>
<html>
<head>
    <title>DES_PRMS Request Email</title>
    <meta charset="utf-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <p>
        Dear {{ $userData['nameOfRequester'] }},
    </p>

    <p>
        {{ $mailData['content'] }}
    </p>

    <p>
        Thank you!
    </p>

    <p>
        Best regards,<br>
        Darapidap Elementary School<br>
        DES-PRMS
    </p>

    <p>
        <small>
            This is an automated email. Please do not reply to this email.
        </small>
    </p>


    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
