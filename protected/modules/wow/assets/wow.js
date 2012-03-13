var Wow = {

    baseUrl: '',
    
    bindItemTooltips: function() {
        var doc = $(document);
        var callback = function() {
            if (this.href == 'javascript:;' || this.href.indexOf('#') == 0 || this.rel == 'np')
                return;

            var self = $(this),
                data = self.data('item'),
                href = self.attr('href').replace('/wow/item/', ""),
                id = parseInt(href),
                query = (data) ? '?'+ data : "";

            if (id && id > 0)
                Tooltip.show(this, Wow.baseUrl + '/wow/item/'+ id + query, true);
        };

        doc.undelegate('a[href*="/item/"]', 'mouseover.tooltip', callback);
        doc.delegate('a[href*="/item/"]', 'mouseover.tooltip', callback);
    },

    bindSpellTooltips: function() {
        var doc = $(document);
        var callback = function() {
            if (this.href == 'javascript:;' || this.href.indexOf('#') == 0 || this.rel == 'np')
                return;

            var self = $(this),
                data = self.data('spell'),
                href = self.attr('href').replace('/wow/spell/', ""),
                id = parseInt(href),
                query = (data) ? '?'+ data : "";

            if (id && id > 0)
                Tooltip.show(this, Wow.baseUrl + '/wow/spell/'+ id + query, true);
        };

        doc.undelegate('a[href*="/spell/"]', 'mouseover.tooltip', callback);
        doc.delegate('a[href*="/spell/"]', 'mouseover.tooltip', callback);
    }
}; 
