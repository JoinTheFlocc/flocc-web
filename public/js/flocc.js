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
    },

    Social : {
        Initialize : function() {
            Flocc.Social.Facebook.Initialize();

            $('.facebook_share').click(function() {
                Flocc.Social.Facebook.Share($(this).attr('facebook-url'));

                return false;
            });
        },
        Facebook : {
            Initialize : function() {
                window.fbAsyncInit = function() {
                    FB.init({
                        appId      : Flocc.Config.Get('social.facebook.app_id'),
                        xfbml      : true,
                        version    : 'v2.5'
                    });
                };

                (function(d, s, id){
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {return;}
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            },
            Share : function(url) {
                FB.ui({method: 'share', href: url}, function(response) {
                    console.log('FB RESPONSE:')
                    console.log(response);
                });
            }
        }
    },

    Profile : {
        TimeLine : {
            Get : function(user_id) {
                $.ajax({
                    dataType    : "json",
                    url         : 'http://flocc.dev:8888/profile/time-line',
                    data        : {'user_id' : user_id},

                    success     : function(data) {
                        $.each(data, function(i) {
                            Flocc.Profile.TimeLine.Add(data[i]);
                        });

                    }
                });
            },
            Add : function(row) {
                console.log(row);
            }
        }
    }
};