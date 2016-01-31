var Email_Controller = {
    init: function()
    {
        var self = this;
        self.$form = $('[name="contact-form"]');
        
        $('[name="enviar"]', self.$form).click(function () {
            self.actionSend();
        });
        self.formReset();
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;

        $('[name="name"]', self.$form).prop('readonly', isFormReadOnly);
        $('[name="email"]', self.$form).prop('readonly', isFormReadOnly);
        $('[name="subject"]', self.$form).prop('readonly', isFormReadOnly);
        $('[name="message"]', self.$form).prop('disabled', isFormReadOnly);
    },
    formReset: function ()
    {
        var self = this;
        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
    },
    dataDefault: function ()
    {
        var self = this;
        
        self.data(Email_Base.email_form_default);
    },
    data: function (form_data/*=UNDEFINED*/)
    {
        var self = this;

        if (form_data)
        {
            //fields
            var name    = form_data.name.value;
            var email   = form_data.email.value;
            var subject = form_data.subject.value;
            var message = form_data.message.value;

            $('[name="name"]', self.$form).val(name);
            $('[name="email"]', self.$form).val(email);
            $('[name="subject"]', self.$form).val(subject);
            $('[name="message"]', self.$form).val(message);

            return;
        }

        form_data = {
            name: $('[name="name"]', self.$form).val(),
            email: $('[name="email"]', self.$form).val(),
            subject: $('[name="subject"]', self.$form).val(),
            message: $('[name="message"]', self.$form).val()
        };

        return form_data;
    },
    errorClear: function ()
    {
        this.formError(Email_Base.email_form_default);
    },
    formError: function (data)
    {
        var self = this;

        var $form_group = $('.form-group', self.$form);

        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();

        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$form).closest('.form-group');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(data[field_name].error).show();
            }

        }
    },
    actionSend: function ()
    {
        var self = this;

        self.formReadOnly(true);

        var data = self.data();
        
        Email_Model.send(data, function (data) {
            if (data.isSuccess)
            {
                Core.Notification.success(data.message);
                self.dataDefault();
            }
            else
            {
                Core.Notification.error(data.message);
                self.formError(data.forms.email);
                self.formReadOnly(false);
            }

        });
    }
};

Core.addInit(function(){
    Email_Controller.init();
});