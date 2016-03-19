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
            Flocc.Notification.Mail.Initialize();
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
        },

        Mail : {
            Initialize : function() {
                Flocc.Responses.Json(Flocc.Config.Get('notifications.url') + '/mail.new', {}, function(data) {
                    FloccThemeNotifications.Mail.Initialize(data);
                });
            }
        }
    },

    Social : {
        Initialize : function() {
            Flocc.Social.Facebook.Initialize();

            $('.facebook_share').click(function() {
                Flocc.Social.Facebook.Share($(this).attr('facebook-url'), $(this).attr('facebook-title'), $(this).attr('facebook-img'), $(this).attr('facebook-desc'));
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
            Share : function(url, title, img, desc) {
                FB.ui({
                    method: 'feed',
                    name: 'Flocc: ' + title,
                    link: url,
                    picture: img,
                    caption: title,
                    description: desc,
                    message: ''

                }, function(response) {
                    console.log('FB RESPONSE:')
                    console.log(response);
                });
            }
        }
    },

    Profile : {
        TimeLine : {
            Init : function() {
                $('#time_line').html('');
            },
            Tabs : function(callback) {
                $('#time_line_tabs li a').click(function() {
                    $('#time_line_tabs').find('.active').removeClass('active');
                    $(this).parent().addClass('active');
                    callback($(this).parent().attr('type'));
                });
            },
            Count : function(data) {
                var count = 0;

                for (var i in data) {
                    if (data.hasOwnProperty(i)) {
                        ++count;
                    }
                }

                return count;
            },
            GetActiveType : function() {
                return $('#time_line_tabs').find('.active').attr('type');
            },
            Get : function(user_id, type, start, limit) {
                if(typeof type == 'undefined') {
                    type = 'all';
                }

                if(typeof start == 'undefined') {
                    start = 0;
                }

                if(typeof limit == 'undefined') {
                    limit = 10;
                }

                $.ajax({
                    dataType    : "json",
                    url         : Flocc.Config.Get('users.timeline.json'),
                    data        : {
                        'user_id'   : user_id,
                        'type'      : type,
                        'start'     : start,
                        'limit'     : limit
                    },

                    success     : function(data) {
                        if(Flocc.Profile.TimeLine.Count(data) > 0) {
                            $.each(data, function(i) {
                                Flocc.Profile.TimeLine.Add(data[i]);
                            });

                            FloccThemeScroll.Done();
                        } else {
                            FloccThemeScroll.Finish();
                        }
                    },
                    error : function(a, b, c) {
                        console.log('Error: ' + a,b,c);
                    }
                });
            },
            Add : function(row) {
                console.log(row);
                $('#time_line').append('<li>' + row.html + '</li>');
            }
        }
    },
};
