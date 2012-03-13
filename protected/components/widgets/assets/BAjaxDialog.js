var ajaxDialog = {
    csrfToken : '',
    csrfTokenName : null,
    defaultTitle : 'Dialog',
    timeout: 0,

    addButtons : function(buttons)
    {
        this.dialogFooter.empty();

        for(var i in buttons) {
            this.dialogFooter.append(buttons[i]);
        }

        this.dialogFooter.children('a[type=submit]').on('click', function(e) {
            e.preventDefault();
            ajaxDialog.submit($(this).attr('name'));
        });

    },

    addContent : function(url)
    {
        $.ajax({
            'url': url,
            'data': this.getCsrfToken(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data)
            {
                ajaxDialog.removeLoader();
                ajaxDialog.dialogContent.html(data.content);
                if(typeof data.buttons !== 'undefined')
                    ajaxDialog.addButtons(data.buttons);
                ajaxDialog.callback(data);
            },
            'cache': false
        });
    },

    addLoader : function(){
        this.dialogContent.html( 'Loading...' );
    },

    callback : function(data){
        switch(data.status)
        {
            case 'render':
                setTimeout(this.renderCallback(data), 300);
                break;
            case 'canceled':
                setTimeout(this.canceledCallback, this.timeout);
                break;
            case 'imagedeleted':
                setTimeout(this.imageDeletedCallback, this.timeout);
                break;
            case 'success':
                setTimeout(this.successCallback(data), this.timeout);
                break;
            default:
                setTimeout(this.defaultCallback, this.timeout);
                break;
        }
    },

    canceledCallback : function(){
        ajaxDialog.close();
    },

    cleanContents : function(){
        this.dialogContent.empty();
    },

    close : function(){
        this.cleanContents();
        this.dialog.modal('hide');
    },

    defaultCallback : function(){
        ajaxDialog.close();
    },

    getCsrfToken : function(){
        if((this.csrfTokenName != null))
        {
            return ('&' + this.csrfTokenName + '=' + this.csrfToken);
        }
    },

    imageDeletedCallback : function(){
        ajaxDialog.close();
    },

    init : function() {
        this.dialog = $('#update-dialog');

        this.dialogHeader = this.dialog.children('.modal-header');
        this.dialogContent = this.dialog.children('.modal-body');
        this.dialogFooter = this.dialog.children('.modal-footer');
    },

    open : function(url)
    {
        this.cleanContents();

        if( typeof this.title === 'undefined' )
        {
            this.title = this.defaultTitle;
        }

        this.dialogHeader.children('h3').html(this.title);
        this.dialog.modal('show');
        this.addLoader();
        this.addContent(url);
    },

    removeLoader : function(){
        this.dialogContent.empty();
    },

    renderCallback : function(data){
    },

    submit : function(submitName)
    {
        submitName = '&' + submitName + '=true';
        var form = this.dialogContent.find( 'form' );
        var formData = form.serialize() + submitName;
        this.addLoader();

        $.ajax({
            'url': form.attr('action'),
            'data': formData,
            'type': 'post',
            'dataType': 'json',
            'success': function(data)
            {
                ajaxDialog.removeLoader();
                if(data.status === 'render')
                {
                    ajaxDialog.dialogContent.html(data.content);
                }
                else if(data.status === 'success')
                {
                    if(typeof data.content === 'undefined')
                        window.location.reload();
                    else
                        $('.alert-success').html(data.content).show().delay(3000).slideUp();
                }
                ajaxDialog.callback(data);
            },
            'cache': false
        });
    },

    successCallback : function(data)
    {
        $('.grid-view').each(function(){
            $.fn.yiiGridView.update($(this).attr('id'));
        });

        $('.list-view').each(function(){
            $.fn.yiiListView.update($(this).attr('id'));
        });

        ajaxDialog.close();
    }
};

function ajaxDialogOpen(e)
{
    e.preventDefault();

    ajaxDialog.title = $(this).data('ajax-dialog-title');

    if(typeof ajaxDialog.dialog === 'undefined')
    {
        ajaxDialog.init();
    }

    ajaxDialog.open($(this).attr('href'));
}