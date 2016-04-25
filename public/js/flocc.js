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
            if(Flocc.Config.Get('notifications.check')) {
                Flocc.Responses.Json(Flocc.Config.Get('notifications.url'), {}, function(data) {
                    FloccThemeNotifications.Initialize(data);
                });
            }
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
    Google : {
        AutoComplete : {
            Initialize : function() {
                $('.place_auto_complete').keyup(function() {
                    var value       = $(this).val();
                    var position    = $(this).offset();
                    var height      = $(this).outerHeight();
                    var width       = $(this).outerWidth();

                    if(value.length > 3) {
                        Flocc.Responses.Json('/api/google/places/auto-complete', {'keyword' : value}, function(data) {
                            Flocc.Google.AutoComplete.Show(data, position, height, width);
                        });

                        var input = $(this);

                        $(document).on('click', '#auto-complete ul li', function() {
                            input.val($(this).html());
                            Flocc.Google.AutoComplete.Hide();
                        });
                    } else {
                        Flocc.Google.AutoComplete.Hide();
                    }
                });
            },
            Show : function(data, position, height, width)
            {
                Flocc.Google.AutoComplete.Hide();

                var lis     = '';
                var style   = 'top: ' + (position.top+height) + 'px; left: ' + position.left + 'px; width: ' + width + 'px;';

                for(var i in data) {
                    var row = data[i];

                    lis = lis + '<li id="' + i + '">' + row + '</li>';
                }

                $('body').append('<div id="auto-complete" style="' + style + '"></div>');
                $('#auto-complete').append('<ul>' + lis + '</ul>');
            },

            Hide : function() {
                $('#auto-complete').remove();
            }
        }
    },

    /**
     * Base64
     */
    Base64 : {
        Encode : function(str) {
            return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
        }
    },

    /**
     * Modals
     */
    Modals : {
        __show_callback : null,
        __close_callback : null,

        setShowCallback : function(callback) {
            Flocc.Modals.__show_callback = callback;

            return Flocc.Modals;
        },

        setCloseCallback : function(callback) {
            Flocc.Modals.__close_callback = callback;

            return Flocc.Modals;
        },
        Show : function(modal) {
            $(modal).modal('show');

            if(Flocc.Modals.__show_callback != null) {
                $(modal).on('show.bs.modal', function (e) {
                    Flocc.Modals.__show_callback();
                });
            }

            if(Flocc.Modals.__close_callback != null) {
                $(modal).on('hidden.bs.modal', function (e) {
                    Flocc.Modals.__close_callback();
                });
            }
        }
    }
};
