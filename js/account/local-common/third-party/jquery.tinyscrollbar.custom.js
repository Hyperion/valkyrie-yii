/*!
 * Tiny Scrollbar 1.42
 * http://www.baijs.nl/tinyscrollbar/
 *
 * Copyright 2010, Maarten Baijs
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/gpl-2.0.php
 *
 * Date: 06 / 11 / 2010
 * Depends on library: jQuery
 */
var scrollBarRatio = 0;
(function($){
    $.fn.tinyscrollbar = function(options){
        var defaults = {
            axis: 'y', // vertical or horizontal scrollbar? ( x || y ).
            wheel: 40,  //how many pixels must the mouswheel scroll at a time.
            scroll: true, //enable or disable the mousewheel scrollbar
            size: 'auto', //set the size of the scrollbar to auto or a fixed number.
            sizethumb: 'auto', //set the size of the thumb to auto or a fixed number.
            trackSelector: '.track',
            thumbSelector: '.thumb',
            scrollbarSelector: '.scrollbar',
            viewportSelector: '.viewport',
            overviewSelector: '.overview',
            minThumbSize: 50, //minimum width or height of the scrollbar thumb
            slideCallback: null  //callback function on slide
        };
        var options = $.extend(defaults, options);
        var oWrapper = $(this);
        var oViewport = { obj: $(options.viewportSelector, this) };
        var oContent = { obj: $(options.overviewSelector, this) };
        var oScrollbar = { obj: $(options.scrollbarSelector, this) };
        var oTrack = { obj: $(options.trackSelector, oScrollbar.obj) };
        var oThumb = { obj: $(options.thumbSelector, oScrollbar.obj) };
        var sAxis = options.axis == 'x', sDirection = sAxis ? 'left' : 'top', sSize = sAxis ? 'Width' : 'Height';
        var iScroll, iPosition = { start: 0, now: 0 }, iMouse = {};

        if (this.length > 1){
            this.each(function(){$(this).tinyscrollbar(options)});
            return this;
        }
        this.initialize = function(){
            this.update();
            setEvents();
        };
        this.update = function(){
            iScroll = 0;
            oViewport[options.axis] = oViewport.obj[0]['offset'+ sSize];
            oContent[options.axis] = oContent.obj[0]['scroll'+ sSize];
            oContent.ratio = oViewport[options.axis] / oContent[options.axis];
            oScrollbar.obj.toggleClass('disable', oContent.ratio >= 1);
            oTrack[options.axis] = options.size == 'auto' ? oViewport[options.axis] : options.size;
            oThumb[options.axis] = Math.min(oTrack[options.axis], Math.max(0, ( options.sizethumb == 'auto' ? (oTrack[options.axis] * oContent.ratio) : options.sizethumb )));

            if (oThumb[options.axis] < options.minThumbSize) {
                oThumb[options.axis] = options.minThumbSize;
                options.sizethumb = options.minThumbSize;
            }

            oScrollbar.ratio = (options.sizethumb == 'auto') ? (oContent[options.axis] / oTrack[options.axis]) : (oContent[options.axis] - oViewport[options.axis]) / (oTrack[options.axis] - oThumb[options.axis]);
            scrollBarRatio = oScrollbar.ratio;
            setSize();
        };
        function setSize(){
            oContent.obj.removeAttr('style');
            oThumb.obj.removeAttr('style');
            iMouse['start'] = oThumb.obj.offset()[sDirection];
            var sCssSize = sSize.toLowerCase();
            oScrollbar.obj.css(sCssSize, oTrack[options.axis]);
            oTrack.obj.css(sCssSize, oTrack[options.axis]);
            oThumb.obj.css(sCssSize, oThumb[options.axis]);
        };
        function setEvents(){
            oThumb.obj.bind('mousedown', start);
            oTrack.obj.bind('mouseup', drag);
            if(options.scroll && this.addEventListener){
                oWrapper[0].addEventListener('DOMMouseScroll', wheel, false);
                oWrapper[0].addEventListener('mousewheel', wheel, false );
            }
            else if(options.scroll){oWrapper[0].onmousewheel = wheel;}
        };
        function start(oEvent){
            iMouse.start = sAxis ? oEvent.pageX : oEvent.pageY;
            iPosition.start = parseInt(oThumb.obj.css(sDirection));
            $(document).bind('mousemove', drag);
            $(document).bind('mouseup', end);
            oThumb.obj.bind('mouseup', end);
            return false;
        };
        function wheel(oEvent){
            if(!(oContent.ratio >= 1)){
                oEvent = $.event.fix(oEvent || window.event);
                var iDelta = oEvent.wheelDelta ? oEvent.wheelDelta/120 : -oEvent.detail/3;
                iScroll -= iDelta * options.wheel;
                iScroll = Math.min((oContent[options.axis] - oViewport[options.axis]), Math.max(0, iScroll));
                oThumb.obj.css(sDirection, iScroll / oScrollbar.ratio);
                oContent.obj.css(sDirection, -iScroll);
                oEvent.preventDefault();

                if (options.slideCallback != null) {
                    options.slideCallback();
                }
            };
        };
        function end(oEvent){
            $(document).unbind('mousemove', drag);
            $(document).unbind('mouseup', end);
            oThumb.obj.unbind('mouseup', end);
            return false;
        };
        function drag(oEvent){
            if(!(oContent.ratio >= 1)){
                iPosition.now = Math.min((oTrack[options.axis] - oThumb[options.axis]), Math.max(0, (iPosition.start + ((sAxis ? oEvent.pageX : oEvent.pageY) - iMouse.start))));

                iScroll = iPosition.now * oScrollbar.ratio;
                oContent.obj.css(sDirection, -iScroll);
                oThumb.obj.css(sDirection, iPosition.now);

                if (options.slideCallback != null) {
                    options.slideCallback();
                }

            }
            return false;
        };
        return this.initialize();
    };
})(jQuery);