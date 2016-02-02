var FloccThemeEventsEdit = {
    Init : function() {
        FloccTabs.Init('tab1');
        FloccThemeEventsEdit.Places.Init();
        FloccThemeEventsEdit.Activity.Init();
    },

    Places : {
        Init : function() {
            $('input.place_type').change(function() {
                if($(this).val() == 'place') {
                    FloccThemeEventsEdit.Places.Place();
                } else {
                    FloccThemeEventsEdit.Places.Route.Init();
                }
            });
        },

        Place : function() {
            $('#placePlace').show();
            $('#placeRoute').hide();
        },

        Route : {
            __route : [],

            Init : function() {
                $('#placePlace').hide();
                $('#placeRoute').show();

                FloccThemeEventsEdit.Places.Route.Refresh();

                $('#addPlace').click(function() {
                    var id = $('#placesList').val();
                    var name = $( "#placesList option:selected" ).text();

                    if(id != '0') {
                        FloccThemeEventsEdit.Places.Route.Add(id, name);
                    }
                });
            },

            Add : function(id, name) {
                if(FloccThemeEventsEdit.Places.Route.Is(id) == false) {
                    FloccThemeEventsEdit.Places.Route.__route.push({'id' : id, 'name' : name});

                    FloccThemeEventsEdit.Places.Route.Refresh();
                }
            },

            Delete : function(id) {
                for(var i in FloccThemeEventsEdit.Places.Route.__route) {
                    var row = FloccThemeEventsEdit.Places.Route.__route[i];

                    if(row.id == id) {
                        delete FloccThemeEventsEdit.Places.Route.__route[i];
                    }
                }

                FloccThemeEventsEdit.Places.Route.Refresh();
            },

            Count : function() {
                return FloccThemeEventsEdit.Places.Route.__route.length;
            },

            Is : function(id) {
                for(var i in FloccThemeEventsEdit.Places.Route.__route) {
                    var row = FloccThemeEventsEdit.Places.Route.__route[i];

                    if(row.id == id) {
                        return true;
                    }
                }

                return false;
            },

            Refresh : function() {
                $('#places_route').html('');
                $('#route').val('');

                if(FloccThemeEventsEdit.Places.Route.Count() > 0) {
                    for(var i in FloccThemeEventsEdit.Places.Route.__route) {
                        var row = FloccThemeEventsEdit.Places.Route.__route[i];

                        $('#places_route').append('<li><span>' + row.name + '</span><i onclick="FloccThemeEventsEdit.Places.Route.Delete(' + row.id + ');" class="fa fa-trash-o pull-right"></i><div class="clearfix"></div></li>');
                        $('#route').val($('#route').val() + row.id + ',');
                    }
                }
            }
        }
    },

    Activity : {
        Init : function() {
            $('#addActivity').click(function() {
                $('#newActivity').show();
                $('#newActivity input').prop('checked', true);
                $('#new_activities').focus();
                $('#addActivity').hide();

                return false;
            });
        }
    }
};