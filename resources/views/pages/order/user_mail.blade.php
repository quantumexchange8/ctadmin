<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Current Tech</title>
</head>
<body>
<p>From: {{ $data['mail_from'] }}</p>
<p>Subject: {{ $data['mail_subject'] }}</p>

<h2>Message:</h2>
<p>{{ $data['mail_content'] }}</p>
</body>
</html>
