<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
</head>
<body>
<p>
    Hello, {{ $user->first_name }} {{ $user->last_name }}!<br /><br />

    You have been added as a user to the Itsourcecode Accounting System. Please verify your e-mail address to be able to sign in.<br /><br />

    Please click <a href="{{ URL::to('verify/' . $code) }}">here</a> to verify. If that doesn't work, your e-mail client may have prevented it. In that case, copy the link below and paste it in your web browser.<br /><br />

    <a href="{{ URL::to('verify/' . $code) }}">{{ URL::to('verify/' . $code) }}</a>

    <br /><br />

    If you have been added by mistake, please disregard this e-mail.<br /><br />

    Thank you!
</p>
</body>
</html>