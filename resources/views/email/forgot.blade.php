<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot</title>
</head>
<body>
<p><b>{{$name}}</b></p>
<p>you recently requested to reset your password for your <a href="http://365daymarket.com">365daymarket.com</a>
    account, Click the button below to reset
    it.</p>
<button style="border-radius: 3px;padding:9px;
    border: solid 1px #ffaf46;
    background-color: #ffc579;
    background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#ffc579),color-stop(100%,#fb9d23));
    background-image: -webkit-linear-gradient(top,#ffc579,#fb9d23);"><a
            href="{{URL::to('/')}}/reset-password/{{$verification_code}}" style="text-decoration: none;color:#000;">Reset your password</a></button>
</body>
</html>