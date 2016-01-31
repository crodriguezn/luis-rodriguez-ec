var Email_Model = {
    send: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(Email_Base.linkx + '/process/send'),
            method: 'post',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR)
            {
                fResponse(data);
            }
        });
    }
};