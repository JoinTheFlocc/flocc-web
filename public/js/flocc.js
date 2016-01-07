var Flocc = {
    /**
     * Config
     */
    Config : {
        __data : [],

        Set : function(name, value) {
            Flocc.Config.__data[name] = value;
        },
        Get : function(name) {
            if(typeof Flocc.Config.__data[name] == 'undefined') {
                return null;
            }

            return Flocc.Config.__data[name];
        }
    },

    /**
     * Responses
     */
    Responses : {
        Json : function(url, data, success) {
            $.ajax({
                dataType    : "json",
                url         : url,
                data        : data,
                success     : success
            });
        }
    },

    /**
     * Helpers
     */
    Helpers : {
        Count : function(object) {
            var count = 0;

            for (var i in object) {
                if (object.hasOwnProperty(i)) {
                    ++count;
                }
            }

            return count;
        }
    },

    /**
     * Notifications
     */
    Notification : {
        __interval : 0,

        Initialize : function() {
            Flocc.Notification.Get();

            Flocc.Notification.Start(100000000);
        },
        Start : function(time) {
            Flocc.Notification.__interval = setInterval('Flocc.Notification.Get();', time);
        },
        Stop : function() {
            clearInterval(Flocc.Notification.__interval);
        },
        Get : function() {
            Flocc.Responses.Json(Flocc.Config.Get('notifications.url'), {}, function(data) {
                FloccThemeNotifications.Initialize(data);
            });
        }
    }
};