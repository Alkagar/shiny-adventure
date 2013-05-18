(function (window, $) {
    "use strict";
    var SH = {
        showNotification : function(message, closeCallback) {
            var notification = $('<div />').addClass('notification').css({
                'position' : 'absolute',
                'top' : '0px',
                'left' : '0px',
                'width' : '100%'
            }).text(message).hide();

            $('body').append(notification);

            notification.slideDown('slow');

            setTimeout(function(){
                notification.slideUp('slow', function() { 
                    notification.remove(); 
                    if(closeCallback !== 'undefined') {
                        closeCallback();
                    }
                });
            }, 4000);
        }
    }

    window.SH = SH;
})(window, jQuery);
