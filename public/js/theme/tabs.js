var FloccTabs = {
    Init : function(id) {
        $('.flocc-tabs .flocc-tab').hide();
        $('.flocc-tabs .flocc-tab[tab-id=' + id + ']').show();

        $('.tab-action.change-tab').click(function() {
            var id = $(this).attr('action-tab-id');

            FloccTabs.Init(id);

            return false;
        });
    }
};