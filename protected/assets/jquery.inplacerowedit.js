var ajaxUpdateRow = {
    beforesubmit: function(tr, data){},
    buttonareaselector: '.button-column',
    editbuttonselector: 'a.update',
    updatebuttontext: '<i class="icon-ok icon-white"></i>',
    updatebuttonclass: 'btn btn-warning',
    cancelbuttontext: '<i class="icon-remove"></i>',
    cancelbuttonclass: 'btn',
    url: '',
    method: 'POST',
    inputs: {},

    editBtnClick : function()
    {
        var editbtn = $(this.editbuttonselector);
        var savebtn = $('<a></a>').html(this.updatebuttontext).addClass(this.updatebuttonclass);
        var cancelbtn = $('<a></a>').html(this.cancelbuttontext).addClass(this.cancelbuttonclass);
        this.tr = editbtn.parents('tr');
        if(this.url == '')
            this.url = editbtn.attr('href');
        this.tr.children('td').each(function(i) {
            var self = $(this);
            if (ajaxUpdateRow.inputs[i] == null || ajaxUpdateRow.inputs[i].disabled)
                return;
                    
            var text = self.text();
            var hiddenDiv = $('<div />').css('display', 'none').addClass('inplacerowedit-hidden').text(text);
            self.html(hiddenDiv);

            var inputOptions = ajaxUpdateRow.getInputOptions(ajaxUpdateRow.inputs[i]);
            var input;
            switch(inputOptions.type)
            {
                case 'text': default:
                    input = ajaxUpdateRow.textRow(text, inputOptions.options);
                    break;
                case 'select':
                    input = ajaxUpdateRow.selectRow(text, inputOptions.options);
                    break;
            }
            input.attr('name', inputOptions.name);
            if ($.isFunction(inputOptions.after))
                inputOptions.after(input);
            self.append(input);
        });
        var controls = this.tr.find(this.buttonareaselector);
        var btndiv = $('<div />');
        btndiv.append(savebtn);
        btndiv.append('&nbsp;');
        btndiv.addClass('buttons');
        btndiv.append(cancelbtn);
        controls.empty().append(btndiv);
        
        savebtn.on('click', function(e) {
            e.preventDefault();
            var data = ajaxUpdateRow.tr.find(':input, select').serializeArray();
            $.ajax({
                async: false,
                cache: false,
                data: data,
                dataType: 'json',
                url: ajaxUpdateRow.url,
                type: ajaxUpdateRow.method,
                success: function(data, textStatus) {
                    ajaxUpdateRow.reloadTable();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    ajaxUpdateRow.reloadTable();
                }
            });
        });
        cancelbtn.on('click', function(e) 
        {
            e.preventDefault();
            ajaxUpdateRow.reloadTable();
        });
    },
    
    reloadTable : function(){
        $('.grid-view').each(function(){
            $.fn.yiiGridView.update($(this).attr('id'));
        });

        $('.list-view').each(function(){
            $.fn.yiiListView.update($(this).attr('id'));
        });
    },
    
    getInputOptions : function(s) {
        var type = s.type ? s.type : 'text';
        var name = s.name ? s.name : '';
        var options = s.option ? s.option : null;
        var after = s.afterCreate ? s.afterCreate : null;

        return {
            type: type, 
            options: options, 
            name: name, 
            after: after
        };
    },
    
    textRow : function(val, options) {
        return $('<input />').attr('type', 'text').val(val);
    },
    selectRow : function(val, options) {
        var select = $('<select />');
        for(var i = 0; i < options.length ; i++){
            var option = $('<option />').val(options[i].value).html(options[i].name);
            if(val == options[i].name)
                option.attr({selected:"selected"});
            select.append(option);
        }
        return select;
    },
    datepickerRow : function(val, options) {
        var textbox = this.textRow(val, options);
        textbox.datepicker(options);
        return textbox;
    }
};