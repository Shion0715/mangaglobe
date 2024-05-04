<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Received</title>
</head>
<body>
    <p>The details of your inquiry are as follows.</p>
    ーーーー
    <p>Subject: {{$inputs['title']}}</p>
    <p>Message: {{$inputs['body']}}</p>
    <p>Email Address: {{$inputs['email']}}</p>
    ーーーー
    <p>We will contact you shortly. Please wait for a while.</p>
</body>
</html>