var MY_Layout_Controller = {
    init: function()
    {
        Flash_Handler.init();
    }
};

var Flash_Handler = {
    init: function()
    {
        if( MY_Layout_Base.flash_type == 'success' )
        {
            Core.Notification.success(MY_Layout_Base.flash_message);
        }
        else if( MY_Layout_Base.flash_type == 'info' )
        {
            Core.Notification.info(MY_Layout_Base.flash_message);
        }
        else if( MY_Layout_Base.flash_type == 'warning' )
        {
            Core.Notification.warning(MY_Layout_Base.flash_message);
        }
        else if( MY_Layout_Base.flash_type == 'error' )
        {
            Core.Notification.error(MY_Layout_Base.flash_message);
        }
    }
};


Core.addInit(function(){
    MY_Layout_Controller.init();
});