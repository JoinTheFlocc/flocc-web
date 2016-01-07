/**
 * Theme Notifications
 *
 * @type {{Initialize: FloccThemeNotifications.Initialize, Clear: FloccThemeNotifications.Clear, SetCount: FloccThemeNotifications.SetCount}}
 */
var FloccThemeNotifications = {
    Initialize : function(data) {
        var count = Flocc.Helpers.Count(data);

        console.log(count);

        if(count > 0) {
            FloccThemeNotifications.SetCount(count);
        } else {
            FloccThemeNotifications.Clear();
        }
    },
    Clear : function() {
        $('#notificationsCount').html(0).hide();
    },
    SetCount : function(count) {
        $('#notificationsCount').html(count).show();
    }
};