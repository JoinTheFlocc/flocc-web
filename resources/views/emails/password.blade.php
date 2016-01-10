<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <!--
        <h3>Welcome, {{ $user->name }}!</h3>
        //-->
        <div>
        Click here to reset your password {{ url('password/reset/' . $token) }}
        </div>
    </body>
</html>