var Core = {
    _arrInit: [],
    site_url: function( uri ){
        return "<?php echo $site_url . ( empty($index_page) ? '' : '/' ) ; ?>" + uri;
    },
    base_url: function( uri ){
        return "<?php echo $base_url; ?>/" + uri;
    },
    //----------------
    //----------------
    init: function()
    {
        this._runInits();
    },
    //----------------
    //----------------
    addInit: function( fun )
    {
        this._arrInit.push( fun );
    },
    //----------------
    //----------------
    _runInits: function()
    {
        var self = this;
        
        $.each( self._arrInit, function(index, value){
            value();
        });
    }
};

Core.Notification = {
    success: function( msg )
    {
        $.jGrowl(msg, { theme:'growl-success', header:'Mensaje!', life: 5000, closeTemplate:'', position:'top-right' });
    },
    error: function( msg )
    {
        $.jGrowl(msg, { theme:'growl-error', header:'Mensaje!', life: 5000, closeTemplate:'', position:'top-right' });
    },
    warning: function( msg )
    {
        $.jGrowl(msg, { theme:'growl-warning', header:'Mensaje!', life: 5000, closeTemplate:'', position:'top-right' });
    },
    info: function( msg )
    {
        $.jGrowl(msg, { theme:'growl-info', header:'Mensaje!', life: 5000, closeTemplate:'', position:'top-right' });
    }
};

Core.Ajax = {
    post: function( url, data, fSuccess, fFail/*=null*/ )
    {
        $.ajax({
            url:url, data:data, method:'post', dataType:'json',
            success: function(res, textStatus, jqXHR)
            {
                //console.log(textStatus);
                //console.log(jqXHR);
                fSuccess(res);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            Core.Notification.error(jqXHR.responseText);
            console.log(textStatus);
            console.log(errorThrown);
            if( fFail )
            {
                fFail();
            }
        });
    }
};


$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

