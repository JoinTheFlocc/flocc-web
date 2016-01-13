
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
