
<script src="/js/theme/notifications.js"></script>
<script src="/js/flocc.js"></script>

<script>
    Flocc.Config.Set('notifications.url', '{{ URL::route('notifications.get') }}');

    Flocc.Notification.Initialize();
</script>