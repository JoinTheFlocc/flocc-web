<div class="container-fluid footer">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-2 legal">
                <a href="#">About</a>
            </div>
            <div class="col-md-2 legal">
                <a href="#">Discover</a>
            </div>
            <div class="col-md-2 legal">
                <a href="#">What's next</a>
            </div>
            <div class="col-md-2 legal">
                <a href="#">Contact</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <hr>
                <p class="text-center">Copyright 2015 - Flocc</p>
            </div>
        </div>
    </div>
</div>

<script src="/js/theme/notifications.js"></script>
<script src="/js/flocc.js"></script>

<script>
    Flocc.Config.Set('notifications.url', '{{ URL::route('notifications.get') }}');
    Flocc.Notification.Initialize();
</script>

<script type="text/javascript">
    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = '';
    }
</script>
