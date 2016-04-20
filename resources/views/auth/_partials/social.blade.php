<p class="divider">or connect with:</p>

<div class="row">
    <div class="col-sm-offset-4 col-sm-4">
        <a class="btn btn-block btn-social btn-facebook" href="{{ route('social.redirect', ['provider' => 'facebook']) }}">
            <span class="fa fa-facebook"></span>Facebook
        </a>
    </div>
<!-- Hiding Microsoft OAuth for now, since SocialiteProvider does not work
    <div class="col-sm-4">
        <a class="btn btn-block btn-social btn-google" href="{{ route('social.redirect', ['provider' => 'google']) }}">
            <span class="fa fa-google"></span>Google
        </a>
    </div>
-- Hiding Microsoft OAuth for now, since SocialiteProvider does not work
    <div class="col-sm-4">
        <a class="btn btn-block btn-social btn-microsoft" href="#">
            <span class="fa fa-windows"></span>Microsoft
        </a>
    </div>
//-->
</div>
