var FloccThemeScroll = {
    __status : 1,
    __element : null,
    __callback : {},

    Init : function(element, callback) {
        FloccThemeScroll.__element  = element;
        FloccThemeScroll.__callback = callback;

        $(window).scroll(function(a, b, c) {
            var scroll  = $(document).scrollTop();
            var link    = $(element);
            var offset  = link.offset();
            var bottom  = offset.top + link.outerHeight();

            if($(window).scrollTop() == $(document).height() - $(window).height() && FloccThemeScroll.__status == 1) {
                FloccThemeScroll.SetStatus(0);
                FloccThemeScroll.AddLoadingElement();
            }
        });
    },

    SetStatus : function(status) {
        FloccThemeScroll.__status = status;
    },

    AddLoadingElement : function() {
        $(FloccThemeScroll.__element).append('<li class="scroll-loading">loading</li>');
        FloccThemeScroll.__callback($(FloccThemeScroll.__element + " li").length-1);
    },

    Done : function() {
        $(FloccThemeScroll.__element).find('.scroll-loading').remove();
        FloccThemeScroll.SetStatus(1);
    },

    Finish : function() {
        $(FloccThemeScroll.__element).find('.scroll-loading').remove();
        FloccThemeScroll.SetStatus(0);
    }
};