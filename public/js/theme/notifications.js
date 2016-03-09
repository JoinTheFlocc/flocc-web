/**
 * Theme Notifications
 *
 * @type {{Initialize: FloccThemeNotifications.Initialize, Clear: FloccThemeNotifications.Clear, SetCount: FloccThemeNotifications.SetCount}}
 */
var FloccThemeNotifications = {
    Initialize : function(data) {
        var count = Flocc.Helpers.Count(data);

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
    },
    Mail : {
        Initialize : function(data) {
            var count = Flocc.Helpers.Count(data);

            if(count > 0) {
                FloccThemeNotifications.Mail.SetCount(count);
            } else {
                FloccThemeNotifications.Mail.Clear();
            }
        },
        Clear : function() {
            $('#notificationsMailCount').html(0).hide();
        },
        SetCount : function(count) {
            $('#notificationsMailCount').html(count).show();
        },
    }
};