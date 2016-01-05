<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h3>Welcome, {{ $user->name }}!</h3>
        <div>
        This is verify e-mail.
        Please click {{{ URL::to('auth/verify/' . $user['activation_code']) }}}
        </div>
    </body>
</html>