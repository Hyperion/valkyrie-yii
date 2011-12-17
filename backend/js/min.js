jQuery.cookie=function(key,value,options){
    if(arguments.length>1&&String(value)!=="[object Object]"){
        options=jQuery.extend({},options);
        if(value===null||value===undefined){
            options.expires=-1;
        }
        if(typeof options.expires==='number'){
            var days=options.expires,t=options.expires=new Date();
            t.setDate(t.getDate()+days);
        }
        value=String(value);
        return(document.cookie=[encodeURIComponent(key),'=',options.raw?value:encodeURIComponent(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''));
    }
    options=value||{};
    
    var result,decode=options.raw?function(s){
        return s;
    }:decodeURIComponent;
    return(result=new RegExp('(?:^|; )'+encodeURIComponent(key)+'=([^;]*)').exec(document.cookie))?decode(result[1]):null;
};
(function($){
    var console=window.console?window.console:{
        log:$.noop,
        error:function(msg){
            $.error(msg);
        }
    };
    
    var supportsProp=(('prop'in $.fn)&&('removeProp'in $.fn));
})(jQuery);
;
(function($){
    $.tooltipsy=function(el,options){
        this.options=options;
        this.$el=$(el);
        this.random=parseInt(Math.random()*10000);
        this.ready=false;
        this.shown=false;
        this.width=0;
        this.height=0;
        this.delaytimer=null;
        this.$el.data("tooltipsy",this);
        this.init();
    };
    
    $.tooltipsy.prototype.init=function(){
        var base=this;
        base.settings=$.extend({},base.defaults,base.options);
        base.settings.delay=parseInt(base.settings.delay);
        if(typeof base.settings.content==='function'){
            base.readify();
        }
        base.$el.bind('mouseenter',function(e){
            if(base.settings.delay>0){
                base.delaytimer=window.setTimeout(function(){
                    base.enter(e);
                },base.settings.delay);
            }
            else{
                base.enter(e);
            }
        }).bind('mouseleave',function(e){
            window.clearTimeout(base.delaytimer);
            base.delaytimer=null;
            base.leave(e);
        });
    };

    $.tooltipsy.prototype.enter=function(e){
        var base=this;
        if(base.ready===false){
            base.readify();
        }
        if(base.shown===false){
            if((function(o){
                var s=0,k;
                for(k in o){
                    if(o.hasOwnProperty(k)){
                        s++;
                    }
                }
                return s;
            })(base.settings.css)>0){
                base.$tip.css(base.settings.css);
            }
            base.width=base.$tipsy.outerWidth();
            base.height=base.$tipsy.outerHeight();
        }
        if(base.settings.alignTo=='cursor'){
            var tip_position=[e.pageX+base.settings.offset[0],e.pageY+base.settings.offset[1]];
            if(tip_position[0]+base.width>$(window).width()){
                var tip_css={
                    top:tip_position[1]+'px',
                    right:tip_position[0]+'px',
                    left:'auto'
                };
    
            }
            else{
                var tip_css={
                    top:tip_position[1]+'px',
                    left:tip_position[0]+'px',
                    right:'auto'
                };

            }
        }
        else{
            var tip_position=[(function(pos){
                if(base.settings.offset[0]<0){
                    return pos.left-Math.abs(base.settings.offset[0])-base.width;
                }
                else if(base.settings.offset[0]==0){
                    return pos.left-((base.width-base.$el.outerWidth())/2);
                }
                else{
                    return pos.left+base.$el.outerWidth()+base.settings.offset[0];
                }
            })(base.offset(base.$el[0])),(function(pos){
                if(base.settings.offset[1]<0){
                    return pos.top-Math.abs(base.settings.offset[1])-base.height;
                }
                else if(base.settings.offset[1]==0){
                    return pos.top-((base.height-base.$el.outerHeight())/2);
                }
                else{
                    return pos.top+base.$el.outerHeight()+base.settings.offset[1];
                }
            })(base.offset(base.$el[0]))];
        }
        base.$tipsy.css({
            top:tip_position[1]+'px',
            left:tip_position[0]+'px'
        });
        base.settings.show(e,base.$tipsy.stop(true,true));
    };

    $.tooltipsy.prototype.leave=function(e){
        var base=this;
        if(e.relatedTarget==base.$tip[0]){
            base.$tip.bind('mouseleave',function(e){
                if(e.relatedTarget==base.$el[0]){
                    return;
                }
                base.settings.hide(e,base.$tipsy.stop(true,true));
            });
            return;
        }
        base.settings.hide(e,base.$tipsy.stop(true,true));
    };

    $.tooltipsy.prototype.readify=function(){
        this.ready=true;
        this.title=this.$el.attr('title')||'';
        this.$el.attr('title','');
        this.$tipsy=$('<div id="tooltipsy'+this.random+'">').appendTo('body').css({
            position:'absolute',
            zIndex:'999'
        }).hide();
        this.$tip=$('<div class="'+this.settings.className+'">').appendTo(this.$tipsy);
        this.$tip.data('rootel',this.$el);
        this.$tip.html(this.settings.content!=''?this.settings.content:this.title);
    };

    $.tooltipsy.prototype.offset=function(el){
        var ol=ot=0;
        if(el.offsetParent){
            do{
                ol+=el.offsetLeft;
                ot+=el.offsetTop;
            }while(el=el.offsetParent);
        }
        return{
            left:ol,
            top:ot
        };

    }
    $.tooltipsy.prototype.defaults={
        alignTo:'element',
        offset:[0,-1],
        content:'',
        show:function(e,$el){
            $el.fadeIn(100);
        },
        hide:function(e,$el){
            $el.fadeOut(100);
        },
        css:{},
        className:'tooltipsy',
        delay:200
    };

    $.fn.tooltipsy=function(options){
        return this.each(function(){
            new $.tooltipsy(this,options);
        });
    };

})(jQuery);
;
/*
// iPhone-style Checkboxes jQuery plugin
// Copyright Thomas Reynolds, licensed GPL & MIT
 */
;
(function($,iphoneStyle){
    $[iphoneStyle]=function(elem,options){
        this.$elem=$(elem);
        var obj=this;
        $.each(options,function(key,value){
            obj[key]=value;
        });
        this.wrapCheckboxWithDivs();
        this.attachEvents();
        this.disableTextSelection();
        if(this.resizeHandle){
            this.optionallyResize('handle');
        }
        if(this.resizeContainer){
            this.optionallyResize('container');
        }
        this.initialPosition();
    };
    
    $.extend($[iphoneStyle].prototype,{
        wrapCheckboxWithDivs:function(){
            this.$elem.wrap('<div class="'+this.containerClass+'" />');
            this.container=this.$elem.parent();
            this.offLabel=$('<label class="'+this.labelOffClass+'">'+'<span>'+this.uncheckedLabel+'</span>'+'</label>').appendTo(this.container);
            this.offSpan=this.offLabel.children('span');
            this.onLabel=$('<label class="'+this.labelOnClass+'">'+'<span>'+this.checkedLabel+'</span>'+'</label>').appendTo(this.container);
            this.onSpan=this.onLabel.children('span');
            this.handle=$('<div class="'+this.handleClass+'">'+'<div class="'+this.handleRightClass+'">'+'<div class="'+this.handleCenterClass+'" />'+'</div>'+'</div>').appendTo(this.container);
        },
        disableTextSelection:function(){
            if(!$.browser.msie){
                return;
            }
            $.each([this.handle,this.offLabel,this.onLabel,this.container],function(){
                $(this).attr("unselectable","on");
            });
        },
        optionallyResize:function(mode){
            var onLabelWidth=this.onLabel.width(),offLabelWidth=this.offLabel.width();
            if(mode=='container'){
                var newWidth=(onLabelWidth>offLabelWidth)?onLabelWidth:offLabelWidth;
                newWidth+=this.handle.width()+15;
            }else{
                var newWidth=(onLabelWidth<offLabelWidth)?onLabelWidth:offLabelWidth;
            }
            this[mode].css({
                width:newWidth
            });
        },
        attachEvents:function(){
            var obj=this;
            this.container.bind('mousedown touchstart',function(event){
                event.preventDefault();
                if(obj.$elem.is(':disabled')){
                    return;
                }
                var x=event.pageX||event.originalEvent.changedTouches[0].pageX;
                $[iphoneStyle].currentlyClicking=obj.handle;
                $[iphoneStyle].dragStartPosition=x;
                $[iphoneStyle].handleLeftOffset=parseInt(obj.handle.css('left'),10)||0;
                $[iphoneStyle].dragStartedOn=obj.$elem;
            }).bind('iPhoneDrag',function(event,x){
                event.preventDefault();
                if(obj.$elem.is(':disabled')){
                    return;
                }
                if(obj.$elem!=$[iphoneStyle].dragStartedOn){
                    return;
                }
                var p=(x+$[iphoneStyle].handleLeftOffset-$[iphoneStyle].dragStartPosition)/obj.rightSide;
                if(p<0){
                    p=0;
                }
                if(p>1){
                    p=1;
                }
                obj.handle.css({
                    left:p*obj.rightSide
                });
                obj.onLabel.css({
                    width:p*obj.rightSide+4
                });
                obj.offSpan.css({
                    marginRight:-p*obj.rightSide
                });
                obj.onSpan.css({
                    marginLeft:-(1-p)*obj.rightSide
                });
            }).bind('iPhoneDragEnd',function(event,x){
                if(obj.$elem.is(':disabled')){
                    return;
                }
                var checked;
                if($[iphoneStyle].dragging){
                    var p=(x-$[iphoneStyle].dragStartPosition)/obj.rightSide;
                    checked=(p<0)?Math.abs(p)<0.5:p>=0.5;
                }else{
                    checked=!obj.$elem.attr('checked');
                }
                obj.$elem.attr('checked',checked);
                $[iphoneStyle].currentlyClicking=null;
                $[iphoneStyle].dragging=null;
                obj.$elem.change();
            });
            this.$elem.change(function(){
                if(obj.$elem.is(':disabled')){
                    obj.container.addClass(obj.disabledClass);
                    return false;
                }else{
                    obj.container.removeClass(obj.disabledClass);
                }
                var new_left=obj.$elem.attr('checked')?obj.rightSide:0;
                obj.handle.animate({
                    left:new_left
                },obj.duration);
                obj.onLabel.animate({
                    width:new_left+4
                },obj.duration);
                obj.offSpan.animate({
                    marginRight:-new_left
                },obj.duration);
                obj.onSpan.animate({
                    marginLeft:new_left-obj.rightSide
                },obj.duration);
            });
        },
        initialPosition:function(){
            this.offLabel.css({
                width:this.container.width()-5
            });
            var offset=($.browser.msie&&$.browser.version<7)?3:6;
            this.rightSide=this.container.width()-this.handle.width()-offset;
            if(this.$elem.is(':checked')){
                this.handle.css({
                    left:this.rightSide
                });
                this.onLabel.css({
                    width:this.rightSide+4
                });
                this.offSpan.css({
                    marginRight:-this.rightSide
                });
            }else{
                this.onLabel.css({
                    width:0
                });
                this.onSpan.css({
                    marginLeft:-this.rightSide
                });
            }
            if(this.$elem.is(':disabled')){
                this.container.addClass(this.disabledClass);
            }
        }
    });
    $.fn[iphoneStyle]=function(options){
        var checkboxes=this.filter(':checkbox');
        if(!checkboxes.length){
            return this;
        }
        var opt=$.extend({},$[iphoneStyle].defaults,options);
        checkboxes.each(function(){
            $(this).data(iphoneStyle,new $[iphoneStyle](this,opt));
        });
        if(!$[iphoneStyle].initComplete){
            $(document).bind('mousemove touchmove',function(event){
                if(!$[iphoneStyle].currentlyClicking){
                    return;
                }
                event.preventDefault();
                var x=event.pageX||event.originalEvent.changedTouches[0].pageX;
                if(!$[iphoneStyle].dragging&&(Math.abs($[iphoneStyle].dragStartPosition-x)>opt.dragThreshold)){
                    $[iphoneStyle].dragging=true;
                }
                $(event.target).trigger('iPhoneDrag',[x]);
            }).bind('mouseup touchend',function(event){
                if(!$[iphoneStyle].currentlyClicking){
                    return;
                }
                event.preventDefault();
                var x=event.pageX||event.originalEvent.changedTouches[0].pageX;
                $($[iphoneStyle].currentlyClicking).trigger('iPhoneDragEnd',[x]);
            });
            $[iphoneStyle].initComplete=true;
        }
        return this;
    };

    $[iphoneStyle].defaults={
        duration:200,
        checkedLabel:'ON',
        uncheckedLabel:'OFF',
        resizeHandle:true,
        resizeContainer:true,
        disabledClass:'iPhoneCheckDisabled',
        containerClass:'iPhoneCheckContainer',
        labelOnClass:'iPhoneCheckLabelOn',
        labelOffClass:'iPhoneCheckLabelOff',
        handleClass:'iPhoneCheckHandle',
        handleCenterClass:'iPhoneCheckHandleCenter',
        handleRightClass:'iPhoneCheckHandleRight',
        dragThreshold:5
    };

})(jQuery,'iphoneStyle');
;
if(!document.createElement('canvas').getContext){
    (function(){
        var m=Math;
        var mr=m.round;
        var ms=m.sin;
        var mc=m.cos;
        var abs=m.abs;
        var sqrt=m.sqrt;
        var Z=10;
        var Z2=Z/2;
        function getContext(){
            return this.context_||(this.context_=new CanvasRenderingContext2D_(this));
        }
        var slice=Array.prototype.slice;
        function bind(f,obj,var_args){
            var a=slice.call(arguments,2);
            return function(){
                return f.apply(obj,a.concat(slice.call(arguments)));
            };
        
        }
        var G_vmlCanvasManager_={
            init:function(opt_doc){
                if(/MSIE/.test(navigator.userAgent)&&!window.opera){
                    var doc=opt_doc||document;
                    doc.createElement('canvas');
                    if(doc.readyState!=="complete"){
                        doc.attachEvent('onreadystatechange',bind(this.init_,this,doc));
                    }else{
                        this.init_(doc);
                    }
                }
            },
            init_:function(doc){
                if(!doc.namespaces['g_vml_']){
                    doc.namespaces.add('g_vml_','urn:schemas-microsoft-com:vml','#default#VML');
                }
                if(!doc.namespaces['g_o_']){
                    doc.namespaces.add('g_o_','urn:schemas-microsoft-com:office:office','#default#VML');
                }
                if(!doc.styleSheets['ex_canvas_']){
                    var ss=doc.createStyleSheet();
                    ss.owningElement.id='ex_canvas_';
                    ss.cssText='canvas{display:inline-block;overflow:hidden;'+'text-align:left;width:300px;height:150px}'+'g_vml_\\:*{behavior:url(#default#VML)}'+'g_o_\\:*{behavior:url(#default#VML)}';
                }
                var els=doc.getElementsByTagName('canvas');
                for(var i=0;i<els.length;i++){
                    this.initElement(els[i]);
                }
            },
            initElement:function(el){
                if(!el.getContext){
                    el.getContext=getContext;
                    el.innerHTML='';
                    el.attachEvent('onpropertychange',onPropertyChange);
                    el.attachEvent('onresize',onResize);
                    var attrs=el.attributes;
                    if(attrs.width&&attrs.width.specified){
                        el.style.width=attrs.width.nodeValue+'px';
                    }else{
                        el.width=el.clientWidth;
                    }
                    if(attrs.height&&attrs.height.specified){
                        el.style.height=attrs.height.nodeValue+'px';
                    }else{
                        el.height=el.clientHeight;
                    }
                }
                return el;
            }
        };

        function onPropertyChange(e){
            var el=e.srcElement;
            switch(e.propertyName){
                case'width':
                    el.style.width=el.attributes.width.nodeValue+'px';
                    el.getContext().clearRect();
                    break;
                case'height':
                    el.style.height=el.attributes.height.nodeValue+'px';
                    el.getContext().clearRect();
                    break;
            }
        }
        function onResize(e){
            var el=e.srcElement;
            if(el.firstChild){
                el.firstChild.style.width=el.clientWidth+'px';
                el.firstChild.style.height=el.clientHeight+'px';
            }
        }
        G_vmlCanvasManager_.init();
        var dec2hex=[];
        for(var i=0;i<16;i++){
            for(var j=0;j<16;j++){
                dec2hex[i*16+j]=i.toString(16)+j.toString(16);
            }
        }
        function createMatrixIdentity(){
            return[[1,0,0],[0,1,0],[0,0,1]];
        }
        function matrixMultiply(m1,m2){
            var result=createMatrixIdentity();
            for(var x=0;x<3;x++){
                for(var y=0;y<3;y++){
                    var sum=0;
                    for(var z=0;z<3;z++){
                        sum+=m1[x][z]*m2[z][y];
                    }
                    result[x][y]=sum;
                }
            }
            return result;
        }
        function copyState(o1,o2){
            o2.fillStyle=o1.fillStyle;
            o2.lineCap=o1.lineCap;
            o2.lineJoin=o1.lineJoin;
            o2.lineWidth=o1.lineWidth;
            o2.miterLimit=o1.miterLimit;
            o2.shadowBlur=o1.shadowBlur;
            o2.shadowColor=o1.shadowColor;
            o2.shadowOffsetX=o1.shadowOffsetX;
            o2.shadowOffsetY=o1.shadowOffsetY;
            o2.strokeStyle=o1.strokeStyle;
            o2.globalAlpha=o1.globalAlpha;
            o2.arcScaleX_=o1.arcScaleX_;
            o2.arcScaleY_=o1.arcScaleY_;
            o2.lineScale_=o1.lineScale_;
        }
        function processStyle(styleString){
            var str,alpha=1;
            styleString=String(styleString);
            if(styleString.substring(0,3)=='rgb'){
                var start=styleString.indexOf('(',3);
                var end=styleString.indexOf(')',start+1);
                var guts=styleString.substring(start+1,end).split(',');
                str='#';
                for(var i=0;i<3;i++){
                    str+=dec2hex[Number(guts[i])];
                }
                if(guts.length==4&&styleString.substr(3,1)=='a'){
                    alpha=guts[3];
                }
            }else{
                str=styleString;
            }
            return{
                color:str,
                alpha:alpha
            };

        }
        function processLineCap(lineCap){
            switch(lineCap){
                case'butt':
                    return'flat';
                case'round':
                    return'round';
                case'square':default:
                    return'square';
            }
        }
        function CanvasRenderingContext2D_(surfaceElement){
            this.m_=createMatrixIdentity();
            this.mStack_=[];
            this.aStack_=[];
            this.currentPath_=[];
            this.strokeStyle='#000';
            this.fillStyle='#000';
            this.lineWidth=1;
            this.lineJoin='miter';
            this.lineCap='butt';
            this.miterLimit=Z*1;
            this.globalAlpha=1;
            this.canvas=surfaceElement;
            var el=surfaceElement.ownerDocument.createElement('div');
            el.style.width=surfaceElement.clientWidth+'px';
            el.style.height=surfaceElement.clientHeight+'px';
            el.style.overflow='hidden';
            el.style.position='absolute';
            surfaceElement.appendChild(el);
            this.element_=el;
            this.arcScaleX_=1;
            this.arcScaleY_=1;
            this.lineScale_=1;
        }
        var contextPrototype=CanvasRenderingContext2D_.prototype;
        contextPrototype.clearRect=function(){
            this.element_.innerHTML='';
        };

        contextPrototype.beginPath=function(){
            this.currentPath_=[];
        };

        contextPrototype.moveTo=function(aX,aY){
            var p=this.getCoords_(aX,aY);
            this.currentPath_.push({
                type:'moveTo',
                x:p.x,
                y:p.y
            });
            this.currentX_=p.x;
            this.currentY_=p.y;
        };

        contextPrototype.lineTo=function(aX,aY){
            var p=this.getCoords_(aX,aY);
            this.currentPath_.push({
                type:'lineTo',
                x:p.x,
                y:p.y
            });
            this.currentX_=p.x;
            this.currentY_=p.y;
        };

        contextPrototype.bezierCurveTo=function(aCP1x,aCP1y,aCP2x,aCP2y,aX,aY){
            var p=this.getCoords_(aX,aY);
            var cp1=this.getCoords_(aCP1x,aCP1y);
            var cp2=this.getCoords_(aCP2x,aCP2y);
            bezierCurveTo(this,cp1,cp2,p);
        };

        function bezierCurveTo(self,cp1,cp2,p){
            self.currentPath_.push({
                type:'bezierCurveTo',
                cp1x:cp1.x,
                cp1y:cp1.y,
                cp2x:cp2.x,
                cp2y:cp2.y,
                x:p.x,
                y:p.y
            });
            self.currentX_=p.x;
            self.currentY_=p.y;
        }
        contextPrototype.quadraticCurveTo=function(aCPx,aCPy,aX,aY){
            var cp=this.getCoords_(aCPx,aCPy);
            var p=this.getCoords_(aX,aY);
            var cp1={
                x:this.currentX_+2.0/3.0*(cp.x-this.currentX_),
                y:this.currentY_+2.0/3.0*(cp.y-this.currentY_)
            };
        
            var cp2={
                x:cp1.x+(p.x-this.currentX_)/3.0,
                y:cp1.y+(p.y-this.currentY_)/3.0
            };
        
            bezierCurveTo(this,cp1,cp2,p);
        };

        contextPrototype.arc=function(aX,aY,aRadius,aStartAngle,aEndAngle,aClockwise){
            aRadius*=Z;
            var arcType=aClockwise?'at':'wa';
            var xStart=aX+mc(aStartAngle)*aRadius-Z2;
            var yStart=aY+ms(aStartAngle)*aRadius-Z2;
            var xEnd=aX+mc(aEndAngle)*aRadius-Z2;
            var yEnd=aY+ms(aEndAngle)*aRadius-Z2;
            if(xStart==xEnd&&!aClockwise){
                xStart+=0.125;
            }
            var p=this.getCoords_(aX,aY);
            var pStart=this.getCoords_(xStart,yStart);
            var pEnd=this.getCoords_(xEnd,yEnd);
            this.currentPath_.push({
                type:arcType,
                x:p.x,
                y:p.y,
                radius:aRadius,
                xStart:pStart.x,
                yStart:pStart.y,
                xEnd:pEnd.x,
                yEnd:pEnd.y
            });
        };

        contextPrototype.rect=function(aX,aY,aWidth,aHeight){
            this.moveTo(aX,aY);
            this.lineTo(aX+aWidth,aY);
            this.lineTo(aX+aWidth,aY+aHeight);
            this.lineTo(aX,aY+aHeight);
            this.closePath();
        };

        contextPrototype.strokeRect=function(aX,aY,aWidth,aHeight){
            var oldPath=this.currentPath_;
            this.beginPath();
            this.moveTo(aX,aY);
            this.lineTo(aX+aWidth,aY);
            this.lineTo(aX+aWidth,aY+aHeight);
            this.lineTo(aX,aY+aHeight);
            this.closePath();
            this.stroke();
            this.currentPath_=oldPath;
        };

        contextPrototype.fillRect=function(aX,aY,aWidth,aHeight){
            var oldPath=this.currentPath_;
            this.beginPath();
            this.moveTo(aX,aY);
            this.lineTo(aX+aWidth,aY);
            this.lineTo(aX+aWidth,aY+aHeight);
            this.lineTo(aX,aY+aHeight);
            this.closePath();
            this.fill();
            this.currentPath_=oldPath;
        };

        contextPrototype.createLinearGradient=function(aX0,aY0,aX1,aY1){
            var gradient=new CanvasGradient_('gradient');
            gradient.x0_=aX0;
            gradient.y0_=aY0;
            gradient.x1_=aX1;
            gradient.y1_=aY1;
            return gradient;
        };

        contextPrototype.createRadialGradient=function(aX0,aY0,aR0,aX1,aY1,aR1){
            var gradient=new CanvasGradient_('gradientradial');
            gradient.x0_=aX0;
            gradient.y0_=aY0;
            gradient.r0_=aR0;
            gradient.x1_=aX1;
            gradient.y1_=aY1;
            gradient.r1_=aR1;
            return gradient;
        };

        contextPrototype.drawImage=function(image,var_args){
            var dx,dy,dw,dh,sx,sy,sw,sh;
            var oldRuntimeWidth=image.runtimeStyle.width;
            var oldRuntimeHeight=image.runtimeStyle.height;
            image.runtimeStyle.width='auto';
            image.runtimeStyle.height='auto';
            var w=image.width;
            var h=image.height;
            image.runtimeStyle.width=oldRuntimeWidth;
            image.runtimeStyle.height=oldRuntimeHeight;
            if(arguments.length==3){
                dx=arguments[1];
                dy=arguments[2];
                sx=sy=0;
                sw=dw=w;
                sh=dh=h;
            }else if(arguments.length==5){
                dx=arguments[1];
                dy=arguments[2];
                dw=arguments[3];
                dh=arguments[4];
                sx=sy=0;
                sw=w;
                sh=h;
            }else if(arguments.length==9){
                sx=arguments[1];
                sy=arguments[2];
                sw=arguments[3];
                sh=arguments[4];
                dx=arguments[5];
                dy=arguments[6];
                dw=arguments[7];
                dh=arguments[8];
            }else{
                throw Error('Invalid number of arguments');
            }
            var d=this.getCoords_(dx,dy);
            var w2=sw/2;
            var h2=sh/2;
            var vmlStr=[];
            var W=10;
            var H=10;
            vmlStr.push(' <g_vml_:group',' coordsize="',Z*W,',',Z*H,'"',' coordorigin="0,0"',' style="width:',W,'px;height:',H,'px;position:absolute;');
            if(this.m_[0][0]!=1||this.m_[0][1]){
                var filter=[];
                filter.push('M11=',this.m_[0][0],',','M12=',this.m_[1][0],',','M21=',this.m_[0][1],',','M22=',this.m_[1][1],',','Dx=',mr(d.x/Z),',','Dy=',mr(d.y/Z),'');
                var max=d;
                var c2=this.getCoords_(dx+dw,dy);
                var c3=this.getCoords_(dx,dy+dh);
                var c4=this.getCoords_(dx+dw,dy+dh);
                max.x=m.max(max.x,c2.x,c3.x,c4.x);
                max.y=m.max(max.y,c2.y,c3.y,c4.y);
                vmlStr.push('padding:0 ',mr(max.x/Z),'px ',mr(max.y/Z),'px 0;filter:progid:DXImageTransform.Microsoft.Matrix(',filter.join(''),", sizingmethod='clip');")
            }else{
                vmlStr.push('top:',mr(d.y/Z),'px;left:',mr(d.x/Z),'px;');
            }
            vmlStr.push(' ">','<g_vml_:image src="',image.src,'"',' style="width:',Z*dw,'px;',' height:',Z*dh,'px;"',' cropleft="',sx/w,'"',' croptop="',sy/h,'"',' cropright="',(w-sx-sw)/w,'"',' cropbottom="',(h-sy-sh)/h,'"',' />','</g_vml_:group>');
            this.element_.insertAdjacentHTML('BeforeEnd',vmlStr.join(''));
        };

        contextPrototype.stroke=function(aFill){
            var lineStr=[];
            var lineOpen=false;
            var a=processStyle(aFill?this.fillStyle:this.strokeStyle);
            var color=a.color;
            var opacity=a.alpha*this.globalAlpha;
            var W=10;
            var H=10;
            lineStr.push('<g_vml_:shape',' filled="',!!aFill,'"',' style="position:absolute;width:',W,'px;height:',H,'px;"',' coordorigin="0 0" coordsize="',Z*W,' ',Z*H,'"',' stroked="',!aFill,'"',' path="');
            var newSeq=false;
            var min={
                x:null,
                y:null
            };
    
            var max={
                x:null,
                y:null
            };
    
            for(var i=0;i<this.currentPath_.length;i++){
                var p=this.currentPath_[i];
                var c;
                switch(p.type){
                    case'moveTo':
                        c=p;
                        lineStr.push(' m ',mr(p.x),',',mr(p.y));
                        break;
                    case'lineTo':
                        lineStr.push(' l ',mr(p.x),',',mr(p.y));
                        break;
                    case'close':
                        lineStr.push(' x ');
                        p=null;
                        break;
                    case'bezierCurveTo':
                        lineStr.push(' c ',mr(p.cp1x),',',mr(p.cp1y),',',mr(p.cp2x),',',mr(p.cp2y),',',mr(p.x),',',mr(p.y));
                        break;
                    case'at':case'wa':
                        lineStr.push(' ',p.type,' ',mr(p.x-this.arcScaleX_*p.radius),',',mr(p.y-this.arcScaleY_*p.radius),' ',mr(p.x+this.arcScaleX_*p.radius),',',mr(p.y+this.arcScaleY_*p.radius),' ',mr(p.xStart),',',mr(p.yStart),' ',mr(p.xEnd),',',mr(p.yEnd));
                        break;
                }
                if(p){
                    if(min.x==null||p.x<min.x){
                        min.x=p.x;
                    }
                    if(max.x==null||p.x>max.x){
                        max.x=p.x;
                    }
                    if(min.y==null||p.y<min.y){
                        min.y=p.y;
                    }
                    if(max.y==null||p.y>max.y){
                        max.y=p.y;
                    }
                }
            }
            lineStr.push(' ">');
            if(!aFill){
                var lineWidth=this.lineScale_*this.lineWidth;
                if(lineWidth<1){
                    opacity*=lineWidth;
                }
                lineStr.push('<g_vml_:stroke',' opacity="',opacity,'"',' joinstyle="',this.lineJoin,'"',' miterlimit="',this.miterLimit,'"',' endcap="',processLineCap(this.lineCap),'"',' weight="',lineWidth,'px"',' color="',color,'" />');
            }else if(typeof this.fillStyle=='object'){
                var fillStyle=this.fillStyle;
                var angle=0;
                var focus={
                    x:0,
                    y:0
                };
    
                var shift=0;
                var expansion=1;
                if(fillStyle.type_=='gradient'){
                    var x0=fillStyle.x0_/this.arcScaleX_;
                    var y0=fillStyle.y0_/this.arcScaleY_;
                    var x1=fillStyle.x1_/this.arcScaleX_;
                    var y1=fillStyle.y1_/this.arcScaleY_;
                    var p0=this.getCoords_(x0,y0);
                    var p1=this.getCoords_(x1,y1);
                    var dx=p1.x-p0.x;
                    var dy=p1.y-p0.y;
                    angle=Math.atan2(dx,dy)*180/Math.PI;
                    if(angle<0){
                        angle+=360;
                    }
                    if(angle<1e-6){
                        angle=0;
                    }
                }else{
                    var p0=this.getCoords_(fillStyle.x0_,fillStyle.y0_);
                    var width=max.x-min.x;
                    var height=max.y-min.y;
                    focus={
                        x:(p0.x-min.x)/width,
                        y:(p0.y-min.y)/height
                    };
        
                    width/=this.arcScaleX_*Z;
                    height/=this.arcScaleY_*Z;
                    var dimension=m.max(width,height);
                    shift=2*fillStyle.r0_/dimension;
                    expansion=2*fillStyle.r1_/dimension-shift;
                }
                var stops=fillStyle.colors_;
                stops.sort(function(cs1,cs2){
                    return cs1.offset-cs2.offset;
                });
                var length=stops.length;
                var color1=stops[0].color;
                var color2=stops[length-1].color;
                var opacity1=stops[0].alpha*this.globalAlpha;
                var opacity2=stops[length-1].alpha*this.globalAlpha;
                var colors=[];
                for(var i=0;i<length;i++){
                    var stop=stops[i];
                    colors.push(stop.offset*expansion+shift+' '+stop.color);
                }
                lineStr.push('<g_vml_:fill type="',fillStyle.type_,'"',' method="none" focus="100%"',' color="',color1,'"',' color2="',color2,'"',' colors="',colors.join(','),'"',' opacity="',opacity2,'"',' g_o_:opacity2="',opacity1,'"',' angle="',angle,'"',' focusposition="',focus.x,',',focus.y,'" />');
            }else{
                lineStr.push('<g_vml_:fill color="',color,'" opacity="',opacity,'" />');
            }
            lineStr.push('</g_vml_:shape>');
            this.element_.insertAdjacentHTML('beforeEnd',lineStr.join(''));
        };

        contextPrototype.fill=function(){
            this.stroke(true);
        }
        contextPrototype.closePath=function(){
            this.currentPath_.push({
                type:'close'
            });
        };

        contextPrototype.getCoords_=function(aX,aY){
            var m=this.m_;
            return{
                x:Z*(aX*m[0][0]+aY*m[1][0]+m[2][0])-Z2,
                y:Z*(aX*m[0][1]+aY*m[1][1]+m[2][1])-Z2
            }
        };

        contextPrototype.save=function(){
            var o={};
    
            copyState(this,o);
            this.aStack_.push(o);
            this.mStack_.push(this.m_);
            this.m_=matrixMultiply(createMatrixIdentity(),this.m_);
        };

        contextPrototype.restore=function(){
            copyState(this.aStack_.pop(),this);
            this.m_=this.mStack_.pop();
        };

        function matrixIsFinite(m){
            for(var j=0;j<3;j++){
                for(var k=0;k<2;k++){
                    if(!isFinite(m[j][k])||isNaN(m[j][k])){
                        return false;
                    }
                }
            }
            return true;
        }
        function setM(ctx,m,updateLineScale){
            if(!matrixIsFinite(m)){
                return;
            }
            ctx.m_=m;
            if(updateLineScale){
                var det=m[0][0]*m[1][1]-m[0][1]*m[1][0];
                ctx.lineScale_=sqrt(abs(det));
            }
        }
        contextPrototype.translate=function(aX,aY){
            var m1=[[1,0,0],[0,1,0],[aX,aY,1]];
            setM(this,matrixMultiply(m1,this.m_),false);
        };

        contextPrototype.rotate=function(aRot){
            var c=mc(aRot);
            var s=ms(aRot);
            var m1=[[c,s,0],[-s,c,0],[0,0,1]];
            setM(this,matrixMultiply(m1,this.m_),false);
        };

        contextPrototype.scale=function(aX,aY){
            this.arcScaleX_*=aX;
            this.arcScaleY_*=aY;
            var m1=[[aX,0,0],[0,aY,0],[0,0,1]];
            setM(this,matrixMultiply(m1,this.m_),true);
        };

        contextPrototype.transform=function(m11,m12,m21,m22,dx,dy){
            var m1=[[m11,m12,0],[m21,m22,0],[dx,dy,1]];
            setM(this,matrixMultiply(m1,this.m_),true);
        };

        contextPrototype.setTransform=function(m11,m12,m21,m22,dx,dy){
            var m=[[m11,m12,0],[m21,m22,0],[dx,dy,1]];
            setM(this,m,true);
        };

        contextPrototype.clip=function(){};

        contextPrototype.arcTo=function(){};

        contextPrototype.createPattern=function(){
            return new CanvasPattern_;
        };

        function CanvasGradient_(aType){
            this.type_=aType;
            this.x0_=0;
            this.y0_=0;
            this.r0_=0;
            this.x1_=0;
            this.y1_=0;
            this.r1_=0;
            this.colors_=[];
        }
        CanvasGradient_.prototype.addColorStop=function(aOffset,aColor){
            aColor=processStyle(aColor);
            this.colors_.push({
                offset:aOffset,
                color:aColor.color,
                alpha:aColor.alpha
            });
        };

        function CanvasPattern_(){}
        G_vmlCanvasManager=G_vmlCanvasManager_;
        CanvasRenderingContext2D=CanvasRenderingContext2D_;
        CanvasGradient=CanvasGradient_;
        CanvasPattern=CanvasPattern_;
    })();
};

var scr=document.getElementsByTagName('script');
var zoombox_path=scr[scr.length-1].getAttribute("src").replace('zoombox.js','');
(function($){
    var options={
        theme:'zoombox',
        opacity:0.8,
        duration:800,
        animation:true,
        width:600,
        height:400,
        gallery:true,
        autoplay:false,
        overflow:false
    }
    var images;
    var elem;
    var isOpen=false;
    var link;
    var width;
    var height;
    var timer;
    var i=0;
    var content;
    var type='multimedia';
    var position=false;
    var imageset=false;
    var state='closed';
    var html='<div id="zoombox"> \
            <div class="zoombox_mask"></div>\
            <div class="zoombox_container">\
                <div class="zoombox_content"></div>\
                <div class="zoombox_title"></div>\
                <div class="zoombox_next"></div>\
                <div class="zoombox_prev"></div>\
                <div class="zoombox_close"></div>\
            </div>\
            <div class="zoombox_gallery"></div>\
        </div>';
    var filtreImg=/(\.jpg)|(\.jpeg)|(\.bmp)|(\.gif)|(\.png)/i;
    var filtreMP3=/(\.mp3)/i;
    var filtreFLV=/(\.flv)/i;
    var filtreSWF=/(\.swf)/i;
    var filtreQuicktime=/(\.mov)|(\.mp4)/i;
    var filtreWMV=/(\.wmv)|(\.avi)/i;
    var filtreDailymotion=/(http:\/\/www.dailymotion)|(http:\/\/dailymotion)/i;
    var filtreVimeo=/(http:\/\/www.vimeo)|(http:\/\/vimeo)/i;
    var filtreYoutube=/(youtube\.)/i;
    var filtreKoreus=/(http:\/\/www\.koreus)|(http:\/\/koreus)/i;
    var galleryLoaded=0;
    $.zoombox=function(el,options){}
    $.zoombox.options=options;
    $.zoombox.close=function(){
        close();
    }
    $.zoombox.open=function(tmplink,opts){
        elem=null;
        link=tmplink;
        options=$.extend({},$.zoombox.options,opts);
        load();
    }
    $.zoombox.html=function(cont,opts){
        content=cont;
        options=$.extend({},$.zoombox.options,opts);
        width=options.width;
        height=options.height;
        elem=null;
        open();
    }
    $.fn.zoombox=function(opts){
        images=new Array();
        return this.each(function(){
            if($.browser.msie&&$.browser.version<7&&!window.XMLHttpRequest){
                return false;
            }
            var obj=this;
            var galleryRegExp=/zgallery([0-9]+)/;
            var gallery=galleryRegExp.exec($(this).attr("class"));
            var tmpimageset=false;
            if(gallery!=null){
                if(!images[gallery[1]]){
                    images[gallery[1]]=new Array();
                }
                images[gallery[1]].push($(this));
                var pos=images[gallery[1]].length-1;
                tmpimageset=images[gallery[1]];
            }
            $(this).unbind('click').click(function(){
                options=$.extend({},$.zoombox.options,opts);
                if(state!='closed')return false;
                elem=$(obj);
                link=elem.attr('href');
                imageset=tmpimageset;
                position=pos;
                load();
                return false;
            });
        });
    }
    function load(){
        if(state=='closed')isOpen=false;
        state='load';
        setDim();
        if(filtreImg.test(link)){
            img=new Image();
            img.src=link;
            $("body").append('<div id="zoombox_loader"></div>');
            $("#zoombox_loader").css("marginTop",scrollY());
            timer=window.setInterval(function(){
                loadImg(img);
            },100);
        }else{
            setContent();
            open();
        }
    }
    function build(){
        $('body').append(html);
        $(window).keydown(function(event){
            shortcut(event.which);
        });
        $(window).resize(function(){
            resize();
        });
        $('#zoombox .zoombox_mask').hide();
        $('#zoombox').addClass(options.theme);
        $('#zoombox .zoombox_mask,.zoombox_close').click(function(){
            close();
            return false;
        });
        if(imageset==false){
            $('#zoombox .zoombox_next,#zoombox .zoombox_prev').remove();
        }else{
            $('#zoombox .zoombox_next').click(function(){
                next();
            });
            $('#zoombox .zoombox_prev').click(function(){
                prev();
            });
        }
    }
    function gallery(){
        var loaded=0;
        var width=0;
        var contentWidth=0;
        if(options.gallery){
            if(imageset===false){
                $('#zoombox .zoombox_gallery').remove();
                return false;
            }
            for(var i in imageset){
                var imgSrc=zoombox_path+'img/video.png';
                var img=$('<img src="'+imgSrc+'" class="video gallery'+(i*1)+'"/>');
                if(filtreImg.test(imageset[i].attr('href'))){
                    imgSrc=imageset[i].attr('href')
                    img=$('<img src="'+imgSrc+'" class="gallery'+(i*1)+'"/>');
                }
                img.data('id',i).appendTo('#zoombox .zoombox_gallery')
                img.click(function(){
                    gotoSlide($(this).data('id'));
                    $('#zoombox .zoombox_gallery img').removeClass('current');
                    $(this).addClass('current');
                });
                if(i==position){
                    img.addClass('current');
                }
                $("<img/>").data('img',img).attr("src",imgSrc).load(function(){
                    loaded++;
                    var img=$(this).data('img');
                    img.width(Math.round(img.height()*this.width/this.height));
                    if(loaded==$('#zoombox .zoombox_gallery img').length){
                        var width=0;
                        $('#zoombox .zoombox_gallery img').each(function(){
                            width+=$(this).outerWidth();
                            $(this).data('left',width);
                        });
                        var div=$('<div>').css({
                            position:'absolute',
                            top:0,
                            left:0,
                            width:width
                        });
                        $('#zoombox .zoombox_gallery').wrapInner(div);
                        contentWidth=$('#zoombox .zoombox_gallery').width();
                        $('#zoombox').trigger('change');
                    }
                });
            }
            $('#zoombox .zoombox_gallery').show().animate({
                bottom:0
            },options.duration);
        }
        $('#zoombox').bind('change',function(e,css){
            if($('#zoombox .zoombox_gallery div').width()<$('#zoombox .zoombox_gallery').width){
                return true;
            }
            var d=0;
            var center=0;
            if(css!=null){
                d=options.duration;
                center=css.width/2;
            }else{
                center=$('#zoombox .zoombox_gallery').width()/2;
            }
            var decal=-$('#zoombox .zoombox_gallery img.current').data('left')+$('#zoombox .zoombox_gallery img.current').width()/2;
            var left=decal+center;
            if(left<center*2-$('#zoombox .zoombox_gallery div').width()){
                left=center*2-$('#zoombox .zoombox_gallery div').width();
            }
            if(left>0){
                left=0;
            }
            $('#zoombox .zoombox_gallery div').animate({
                left:left
            },d);
        });
    }
    function open(){
        if(isOpen==false)build();else $('#zoombox .zoombox_title').empty();
        $('#zoombox .close').hide();
        $('#zoombox .zoombox_container').removeClass('multimedia').removeClass('img').addClass(type);
        if(elem!=null&&elem.attr('title')){
            $('#zoombox .zoombox_title').append(elem.attr('title'));
        }
        $('#zoombox .zoombox_content').empty();
        if(type=='img'&&isOpen==false&&options.animation==true){
            $('#zoombox .zoombox_content').append(content);
        }
        if(elem!=null&&elem.find('img').length!=0&&isOpen==false){
            var min=elem.find('img');
            $('#zoombox .zoombox_container').css({
                width:min.width(),
                height:min.height(),
                top:min.offset().top,
                left:min.offset().left,
                opacity:0,
                marginTop:min.css('marginTop')
            });
        }else if(elem!=null&&isOpen==false){
            $('#zoombox .zoombox_container').css({
                width:elem.width(),
                height:elem.height(),
                top:elem.offset().top,
                left:elem.offset().left
            });
        }else if(isOpen==false){
            $('#zoombox .zoombox_container').css({
                width:100,
                height:100,
                top:windowH()/2-50,
                left:windowW()/2-50
            })
        }
        var css={
            width:width,
            height:height,
            left:(windowW()-width)/2,
            top:(windowH()-height)/2,
            marginTop:scrollY(),
            opacity:1
        };
    
        $('#zoombox').trigger('change',css);
        if(options.animation==true){
            $('#zoombox .zoombox_title').hide();
            $('#zoombox .zoombox_close').hide();
            $('#zoombox .zoombox_container').animate(css,options.duration,function(){
                if(type=='multimedia'||isOpen==true){
                    $('#zoombox .zoombox_content').append(content);
                }
                if(type=='image'||isOpen==true){
                    $('#zoombox .zoombox_content img').css('opacity',0).fadeTo(300,1);
                }
                $('#zoombox .zoombox_title').fadeIn(300);
                $('#zoombox .zoombox_close').fadeIn(300);
                state='opened';
                if(!isOpen){
                    gallery();
                }
                isOpen=true;
            });
            $('#zoombox .zoombox_mask').fadeTo(200,options.opacity);
        }else{
            $('#zoombox .zoombox_content').append(content);
            $('#zoombox .zoombox_close').show();
            $('#zoombox .zoombox_gallery').show();
            $('#zoombox .zoombox_container').css(css);
            $('#zoombox .zoombox_mask').show();
            $('#zoombox .zoombox_mask').css('opacity',options.opacity);
            if(!isOpen){
                gallery();
            }
            isOpen=true;
            state='opened';
        }
    }
    function close(){
        state='closing';
        window.clearInterval(timer);
        $(window).unbind('keydown');
        $(window).unbind('resize');
        if(type=='multimedia'){
            $('#zoombox .zoombox_container').empty();
        }
        var css={};
    
        if(elem!=null&&elem.find('img').length>0){
            var min=elem.find('img');
            css={
                width:min.width(),
                height:min.height(),
                top:min.offset().top,
                left:min.offset().left,
                opacity:0,
                marginTop:min.css('marginTop')
            };
        
        }else if(elem!=null){
            css={
                width:elem.width(),
                height:elem.height(),
                top:elem.offset().top,
                left:elem.offset().left,
                marginTop:0,
                opacity:0
            };

        }else{
            css={
                width:100,
                height:100,
                top:windowH()/2-50,
                left:windowW()/2-50,
                opacity:0
            };

        }
        if(options.animation==true){
            $('#zoombox .zoombox_mask').fadeOut(200);
            $('#zoombox .zoombox_gallery').animate({
                bottom:-$('#zoombox .zoombox_gallery').innerHeight()
            },options.duration);
            $('#zoombox .zoombox_container').animate(css,options.duration,function(){
                $('#zoombox').remove();
                state='closed';
                isOpen=false;
            });
        }else{
            $('#zoombox').remove();
            state='closed';
            isOpen=false;
        }
    }
    function setContent(){
        if(options.overflow==false){
            if(width*1+50>windowW()){
                height=(windowW()-50)*height/width;
                width=windowW()-50;
            }
            if(height*1+50>windowH()){
                width=(windowH()-50)*width/height;
                height=windowH()-50;
            }
        }
        var url=link;
        type='multimedia';
        if(filtreImg.test(url)){
            type='img';
            content='<img src="'+link+'" width="100%" height="100%"/>';
        }else if(filtreMP3.test(url)){
            width=300;
            height=40;
            content='<object type="application/x-shockwave-flash" data="'+MP3Player+'?son='+url+'" width="'+width+'" height="'+height+'">';
            content+='<param name="movie" value="'+MP3Player+'?son='+url+'" /></object>';
        }else if(filtreFLV.test(url)){
            var autostart=0;
            if(options.autoplay==true){
                autostart=1;
            }
            content='<object type="application/x-shockwave-flash" data="'+zoombox_path+'FLVplayer.swf" width="'+width+'" height="'+height+'">\
<param name="allowFullScreen" value="true">\
<param name="scale" value="noscale">\
<param name="wmode" value="transparent">\
<param name="flashvars" value="flv='+url+'&autoplay='+autostart+'">\
<embed src="'+zoombox_path+'FLVplayer.swf" width="'+width+'" height="'+height+'" allowscriptaccess="always" allowfullscreen="true" flashvars="flv='+url+'" wmode="transparent" />\
</object>';
        }else if(filtreSWF.test(url)){
            content='<object width="'+width+'" height="'+height+'"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="'+url+'" /><embed src="'+url+'" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'+width+'" height="'+height+'" wmode="transparent"></embed></object>';
        }else if(filtreQuicktime.test(url)){
            content='<embed src="'+url+'" width="'+width+'" height="'+height+'" controller="true" cache="true" autoplay="true"/>';
        }else if(filtreWMV.test(url)){
            content='<embed src="'+url+'" width="'+width+'" height="'+height+'" controller="true" cache="true" autoplay="true" wmode="transparent" />';
        }else if(filtreDailymotion.test(url)){
            var id=url.split('_');
            id=id[0].split('/');
            id=id[id.length-1];
            if(options.autoplay==true){
                id=id+'&autostart=1';
            }
            content='<object width="'+width+'" height="'+height+'"><param name="movie" value="http://www.dailymotion.com/swf/'+id+'&colors=background:000000;glow:000000;foreground:FFFFFF;special:000000;&related=0"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed src="http://www.dailymotion.com/swf/'+id+'&colors=background:000000;glow:000000;foreground:FFFFFF;special:000000;&related=0" type="application/x-shockwave-flash" width="'+width+'" height="'+height+'" allowFullScreen="true" allowScriptAccess="always" wmode="transparent" ></embed></object>';
        }else if(filtreVimeo.test(url)){
            var id=url.split('/');
            id=id[3];
            if(options.autoplay==true){
                id=id+'&autoplay=1';
            }
            content='<object width="'+width+'" height="'+height+'"><param name="allowfullscreen" value="true" /> <param name="allowscriptaccess" value="always" /><param name="wmode" value="transparent" /><param name="movie" value="http://www.vimeo.com/moogaloop.swf?clip_id='+id+'&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00AAEB&amp;fullscreen=1" /> <embed src="http://www.vimeo.com/moogaloop.swf?clip_id='+id+'&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00AAEB&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'+width+'" height="'+height+'" wmode="transparent" ></embed></object>';
        }else if(filtreYoutube.test(url)){
            var id=url.split('watch?v=');
            id=id[1].split('&');
            id=id[0];
            if(options.autoplay==true){
                id=id+'&autoplay=1';
            }
            content='<object width="'+width+'" height="'+height+'"><param name="movie" value="http://www.youtube.com/v/'+id+'&hl=fr&rel=0&color1=0xFFFFFF&color2=0xFFFFFF&hd=1"></param><embed src="http://www.youtube.com/v/'+id+'&hl=fr&rel=0&color1=0xFFFFFF&color2=0xFFFFFF&hd=1" type="application/x-shockwave-flash" width="'+width+'" height="'+height+'" wmode="transparent"></embed></object>';
        }else if(filtreKoreus.test(url)){
            url=url.split('.html');
            url=url[0];
            content='<object type="application/x-shockwave-flash" data="'+url+'" width="'+width+'" height="'+height+'"><param name="movie" value="'+url+'"><embed src="'+url+'" type="application/x-shockwave-flash" width="'+width+'" height="'+height+'"  wmode="transparent"></embed></object>';
        }else{
            content='<iframe src="'+url+'" width="'+width+'" height="'+height+'" border="0"></iframe>';
        }
        return content;
    }
    function loadImg(img){
        if(img.complete){
            i=0;
            window.clearInterval(timer);
            width=img.width;
            height=img.height;
            $('#zoombox_loader').remove();
            setContent();
            open();
        }
        $('#zoombox_loader').css({
            'background-position':"0px "+i+"px"
        });
        i=i-40;
        if(i<(-440)){
            i=0;
        }
    }
    function gotoSlide(i){
        if(state!='opened'){
            return false;
        }
        position=i;
        elem=imageset[position];
        link=elem.attr('href');
        if($('#zoombox .zoombox_gallery img').length>0){
            $('#zoombox .zoombox_gallery img').removeClass('current');
            $('#zoombox .zoombox_gallery img:eq('+i+')').addClass('current');
        }
        load();
        return false;
    }
    function next(){
        i=position+1;
        if(i>imageset.length-1){
            i=0;
        }
        gotoSlide(i);
    }
    function prev(){
        i=position-1;
        if(i<0){
            i=imageset.length-1;
        }
        gotoSlide(i);
    }
    function resize(){
        $('#zoombox .zoombox_container').css({
            top:(windowH()-$('#zoombox .zoombox_container').outerHeight(true))/2,
            left:(windowW()-$('#zoombox .zoombox_container').outerWidth(true))/2
        });
    }
    function shortcut(key){
        if(key==37){
            prev();
        }
        if(key==39){
            next();
        }
        if(key==27){
            close();
        }
    }
    function setDim(){
        width=options.width;
        height=options.height;
        if(elem!=null){
            var widthReg=/w([0-9]+)/;
            var w=widthReg.exec(elem.attr("class"));
            if(w!=null){
                if(w[1]){
                    width=w[1];
                }
            }
            var heightReg=/h([0-9]+)/;
            var h=heightReg.exec(elem.attr("class"));
            if(h!=null){
                if(h[1]){
                    height=h[1];
                }
            }
        }
        return false;
    }
    function windowH(){
        if(window.innerHeight)return window.innerHeight;
        else{
            return $(window).height();
        }
    }
    function windowW(){
        if(window.innerWidth)return window.innerWidth;
        else{
            return $(window).width();
        }
    }
    function scrollY(){
        scrOfY=0;
        if(typeof(window.pageYOffset)=='number'){
            scrOfY=window.pageYOffset;
        }else if(document.body&&(document.body.scrollTop)){
            scrOfY=document.body.scrollTop;
        }else if(document.documentElement&&(document.documentElement.scrollTop)){
            scrOfY=document.documentElement.scrollTop;
        }
        return scrOfY;
    }
    function scrollX(){
        scrOfX=0;
        if(typeof(window.pageXOffset)=='number'){
            scrOfX=window.pageXOffset;
        }else if(document.body&&(document.body.scrollLeft)){
            scrOfX=document.body.scrollLeft;
        }else if(document.documentElement&&(document.documentElement.scrollLeft)){
            scrOfX=document.documentElement.scrollLeft;
        }
        return scrOfX;
    }
})(jQuery);
;
(function($){
    $.fn.visualize=function(options,container){
        return $(this).each(function(){
            var o=$.extend({
                type:'bar',
                width:$(this).width(),
                height:$(this).height(),
                appendTitle:true,
                title:null,
                appendKey:true,
                colors:['#be1e2d','#666699','#92d5ea','#ee8310','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744'],
                textColors:[],
                parseDirection:'x',
                pieMargin:10,
                pieLabelsAsPercent:true,
                pieLabelPos:'inside',
                lineWeight:4,
                lineDots:false,
                dotInnerColor:"#ffffff",
                lineMargin:(options.lineDots?15:0),
                barGroupMargin:10,
                chartId:'',
                xLabelParser:null,
                valueParser:null,
                chartId:'',
                chartClass:'',
                barMargin:1,
                yLabelInterval:30,
                interaction:false
            },options);
            o.width=parseFloat(o.width);
            o.height=parseFloat(o.height);
            if(o.type!='line'&&o.type!='area'){
                o.lineMargin=0;
            }
            var self=$(this);
            var tableData={};
            
            var colors=o.colors;
            var textColors=o.textColors;
            var parseLabels=function(direction){
                var labels=[];
                if(direction=='x'){
                    self.find('thead tr').each(function(i){
                        $(this).find('th').each(function(j){
                            if(!labels[j]){
                                labels[j]=[];
                            }
                            labels[j][i]=$(this).text()
                        })
                    });
                }
                else{
                    self.find('tbody tr').each(function(i){
                        $(this).find('th').each(function(j){
                            if(!labels[i]){
                                labels[i]=[];
                            }
                            labels[i][j]=$(this).text()
                        });
                    });
                }
                return labels;
            };
            
            var fnParse=o.valueParser||parseFloat;
            var dataGroups=tableData.dataGroups=[];
            if(o.parseDirection=='x'){
                self.find('tbody tr').each(function(i,tr){
                    dataGroups[i]={};
                    
                    dataGroups[i].points=[];
                    dataGroups[i].color=colors[i];
                    if(textColors[i]){
                        dataGroups[i].textColor=textColors[i];
                    }
                    $(tr).find('td').each(function(j,td){
                        dataGroups[i].points.push({
                            value:fnParse($(td).text()),
                            elem:td,
                            tableCords:[i,j]
                        });
                    });
                });
            }else{
                var cols=self.find('tbody tr:eq(0) td').size();
                for(var i=0;i<cols;i++){
                    dataGroups[i]={};
                    
                    dataGroups[i].points=[];
                    dataGroups[i].color=colors[i];
                    if(textColors[i]){
                        dataGroups[i].textColor=textColors[i];
                    }
                    self.find('tbody tr').each(function(j){
                        dataGroups[i].points.push({
                            value:$(this).find('td').eq(i).text()*1,
                            elem:this,
                            tableCords:[i,j]
                        });
                    });
                };
                
            }
            var allItems=tableData.allItems=[];
            $(dataGroups).each(function(i,row){
                var count=0;
                $.each(row.points,function(j,point){
                    allItems.push(point);
                    count+=point.value;
                });
                row.groupTotal=count;
            });
            tableData.dataSum=0;
            tableData.topValue=0;
            tableData.bottomValue=Infinity;
            $.each(allItems,function(i,item){
                tableData.dataSum+=fnParse(item.value);
                if(fnParse(item.value,10)>tableData.topValue){
                    tableData.topValue=fnParse(item.value,10);
                }
                if(item.value<tableData.bottomValue){
                    tableData.bottomValue=fnParse(item.value);
                }
            });
            var dataSum=tableData.dataSum;
            var topValue=tableData.topValue;
            var bottomValue=tableData.bottomValue;
            var xAllLabels=tableData.xAllLabels=parseLabels(o.parseDirection);
            var yAllLabels=tableData.yAllLabels=parseLabels(o.parseDirection==='x'?'y':'x');
            var xLabels=tableData.xLabels=[];
            $.each(tableData.xAllLabels,function(i,labels){
                tableData.xLabels.push(labels[0]);
            });
            var totalYRange=tableData.totalYRange=tableData.topValue-tableData.bottomValue;
            var zeroLocX=tableData.zeroLocX=0;
            if($.isFunction(o.xLabelParser)){
                var xTopValue=null;
                var xBottomValue=null;
                $.each(xLabels,function(i,label){
                    label=xLabels[i]=o.xLabelParser(label);
                    if(i===0){
                        xTopValue=label;
                        xBottomValue=label;
                    }
                    if(label>xTopValue){
                        xTopValue=label;
                    }
                    if(label<xBottomValue){
                        xBottomValue=label;
                    }
                });
                var totalXRange=tableData.totalXRange=xTopValue-xBottomValue;
                var xScale=tableData.xScale=(o.width-2*o.lineMargin)/totalXRange;
                var marginDiffX=0;
                if(o.lineMargin){
                    var marginDiffX=-2*xScale-o.lineMargin;
                }
                zeroLocX=tableData.zeroLocX=xBottomValue+o.lineMargin;
                tableData.xBottomValue=xBottomValue;
                tableData.xTopValue=xTopValue;
                tableData.totalXRange=totalXRange;
            }
            var yScale=tableData.yScale=(o.height-2*o.lineMargin)/totalYRange;
            var zeroLocY=tableData.zeroLocY=(o.height-2*o.lineMargin)*(tableData.topValue/tableData.totalYRange)+o.lineMargin;
            var yLabels=tableData.yLabels=[];
            var numLabels=Math.floor((o.height-2*o.lineMargin)/30);
            var loopInterval=tableData.totalYRange/numLabels;
            loopInterval=Math.round(parseFloat(loopInterval)/5)*5;
            loopInterval=Math.max(loopInterval,1);
            for(var j=Math.round(parseInt(tableData.bottomValue)/5)*5;j<=tableData.topValue+loopInterval;j+=loopInterval){
                yLabels.push(j);
            }
            if(yLabels[yLabels.length-1]>tableData.topValue+loopInterval){
                yLabels.pop();
            }else if(yLabels[yLabels.length-1]<=tableData.topValue-10){
                yLabels.push(tableData.topValue);
            }
            $.each(dataGroups,function(i,row){
                row.yLabels=tableData.yAllLabels[i];
                $.each(row.points,function(j,point){
                    point.zeroLocY=tableData.zeroLocY;
                    point.zeroLocX=tableData.zeroLocX;
                    point.xLabels=tableData.xAllLabels[j];
                    point.yLabels=tableData.yAllLabels[i];
                    point.color=row.color;
                });
            });
            try{
                console.log(tableData);
            }catch(e){}
            var charts={};
    
            charts.pie={
                interactionPoints:dataGroups,
                setup:function(){
                    charts.pie.draw(true);
                },
                draw:function(drawHtml){
                    var centerx=Math.round(canvas.width()/2);
                    var centery=Math.round(canvas.height()/2);
                    var radius=centery-o.pieMargin;
                    var counter=0.0;
                    if(drawHtml){
                        canvasContain.addClass('visualize-pie');
                        if(o.pieLabelPos=='outside'){
                            canvasContain.addClass('visualize-pie-outside');
                        }
                        var toRad=function(integer){
                            return(Math.PI/180)*integer;
                        };
                
                        var labels=$('<ul class="visualize-labels"></ul>').insertAfter(canvas);
                    }
                    $.each(dataGroups,function(i,row){
                        var fraction=row.groupTotal/dataSum;
                        if(fraction<=0||isNaN(fraction))
                            return;
                        ctx.beginPath();
                        ctx.moveTo(centerx,centery);
                        ctx.arc(centerx,centery,radius,counter*Math.PI*2-Math.PI*0.5,(counter+fraction)*Math.PI*2-Math.PI*0.5,false);
                        ctx.lineTo(centerx,centery);
                        ctx.closePath();
                        ctx.fillStyle=dataGroups[i].color;
                        ctx.fill();
                        if(drawHtml){
                            var sliceMiddle=(counter+fraction/2);
                            var distance=o.pieLabelPos=='inside'?radius/1.5:radius+radius/5;
                            var labelx=Math.round(centerx+Math.sin(sliceMiddle*Math.PI*2)*(distance));
                            var labely=Math.round(centery-Math.cos(sliceMiddle*Math.PI*2)*(distance));
                            var leftRight=(labelx>centerx)?'right':'left';
                            var topBottom=(labely>centery)?'bottom':'top';
                            var percentage=parseFloat((fraction*100).toFixed(2));
                            row.canvasCords=[labelx,labely];
                            row.zeroLocY=tableData.zeroLocY=0;
                            row.zeroLocX=tableData.zeroLocX=0;
                            row.value=row.groupTotal;
                            if(percentage){
                                var labelval=(o.pieLabelsAsPercent)?percentage+'%':row.groupTotal;
                                var labeltext=$('<span class="visualize-label">'+labelval+'</span>').css(leftRight,0).css(topBottom,0);
                                if(labeltext)
                                    var label=$('<li class="visualize-label-pos"></li>').appendTo(labels).css({
                                        left:labelx,
                                        top:labely
                                    }).append(labeltext);
                                labeltext.css('font-size',radius/8).css('margin-'+leftRight,-labeltext.width()/2).css('margin-'+topBottom,-labeltext.outerHeight()/2);
                                if(dataGroups[i].textColor){
                                    labeltext.css('color',dataGroups[i].textColor);
                                }
                            }
                        }
                        counter+=fraction;
                    });
                }
            };
            (function(){
                var xInterval;
                var drawPoint=function(ctx,x,y,color,size){
                    ctx.moveTo(x,y);
                    ctx.beginPath();
                    ctx.arc(x,y,size/2,0,2*Math.PI,false);
                    ctx.closePath();
                    ctx.fillStyle=color;
                    ctx.fill();
                };
    
                charts.line={
                    interactionPoints:allItems,
                    setup:function(area){
                        if(area){
                            canvasContain.addClass('visualize-area');
                        }
                        else{
                            canvasContain.addClass('visualize-line');
                        }
                        var xlabelsUL=$('<ul class="visualize-labels-x"></ul>').width(canvas.width()).height(canvas.height()).insertBefore(canvas);
                        if(!o.customXLabels){
                            xInterval=(canvas.width()-2*o.lineMargin)/(xLabels.length-1);
                            $.each(xLabels,function(i){
                                var thisLi=$('<li><span>'+this+'</span></li>').prepend('<span class="line" />').css('left',o.lineMargin+xInterval*i).appendTo(xlabelsUL);
                                var label=thisLi.find('span:not(.line)');
                                var leftOffset=label.width()/-2;
                                if(i==0){
                                    leftOffset=0;
                                }
                                else if(i==xLabels.length-1){
                                    leftOffset=-label.width();
                                }
                                label.css('margin-left',leftOffset).addClass('label');
                            });
                        }else{
                            o.customXLabels(tableData,xlabelsUL);
                        }
                        var liBottom=(canvas.height()-2*o.lineMargin)/(yLabels.length-1);
                        var ylabelsUL=$('<ul class="visualize-labels-y"></ul>').width(canvas.width()).height(canvas.height()).insertBefore(scroller);
                        $.each(yLabels,function(i){
                            var value=Math.floor(this);
                            var posB=(value-bottomValue)*yScale+o.lineMargin;
                            if(posB>=o.height-1||posB<0){
                                return;
                            }
                            var thisLi=$('<li><span>'+value+'</span></li>').css('bottom',posB);
                            if(Math.abs(posB)<o.height-1){
                                thisLi.prepend('<span class="line"  />');
                            }
                            thisLi.prependTo(ylabelsUL);
                            var label=thisLi.find('span:not(.line)');
                            var topOffset=label.height()/-2;
                            if(!o.lineMargin){
                                if(i==0){
                                    topOffset=-label.height();
                                }
                                else if(i==yLabels.length-1){
                                    topOffset=0;
                                }
                            }
                            label.css('margin-top',topOffset).addClass('label');
                        });
                        ctx.translate(zeroLocX,zeroLocY);
                        charts.line.draw(area);
                    },
                    draw:function(area){
                        ctx.clearRect(-zeroLocX,-zeroLocY,o.width,o.height);
                        var integer;
                        $.each(dataGroups,function(i,row){
                            integer=o.lineMargin;
                            $.each(row.points,function(j,point){
                                if(o.xLabelParser){
                                    point.canvasCords=[(xLabels[j]-zeroLocX)*xScale-xBottomValue,-(point.value*yScale)];
                                }else{
                                    point.canvasCords=[integer,-(point.value*yScale)];
                                }
                                if(o.lineDots){
                                    point.dotSize=o.dotSize||o.lineWeight*Math.PI;
                                    point.dotInnerSize=o.dotInnerSize||o.lineWeight*Math.PI/2;
                                    if(o.lineDots=='double'){
                                        point.innerColor=o.dotInnerColor;
                                    }
                                }
                                integer+=xInterval;
                            });
                        });
                        self.trigger('vizualizeBeforeDraw',{
                            options:o,
                            table:self,
                            canvasContain:canvasContain,
                            tableData:tableData
                        });
                        $.each(dataGroups,function(h){
                            ctx.beginPath();
                            ctx.lineWidth=o.lineWeight;
                            ctx.lineJoin='round';
                            $.each(this.points,function(g){
                                var loc=this.canvasCords;
                                if(g==0){
                                    ctx.moveTo(loc[0],loc[1]);
                                }
                                ctx.lineTo(loc[0],loc[1]);
                            });
                            ctx.strokeStyle=this.color;
                            ctx.stroke();
                            if(area){
                                var integer=this.points[this.points.length-1].canvasCords[0];
                                if(isFinite(integer))
                                    ctx.lineTo(integer,0);
                                ctx.lineTo(o.lineMargin,0);
                                ctx.closePath();
                                ctx.fillStyle=this.color;
                                ctx.globalAlpha=.3;
                                ctx.fill();
                                ctx.globalAlpha=1.0;
                            }
                            else{
                                ctx.closePath();
                            }
                        });
                        if(o.lineDots){
                            $.each(dataGroups,function(h){
                                $.each(this.points,function(g){
                                    drawPoint(ctx,this.canvasCords[0],this.canvasCords[1],this.color,this.dotSize);
                                    if(o.lineDots==='double'){
                                        drawPoint(ctx,this.canvasCords[0],this.canvasCords[1],this.innerColor,this.dotInnerSize);
                                    }
                                });
                            });
                        }
                    }
                };

            })();
            charts.area={
                setup:function(){
                    charts.line.setup(true);
                },
                draw:charts.line.draw
            };
            (function(){
                var horizontal,bottomLabels;
                charts.bar={
                    setup:function(){
                        horizontal=(o.barDirection=='horizontal');
                        canvasContain.addClass('visualize-bar');
                        bottomLabels=horizontal?yLabels:xLabels;
                        var xInterval=canvas.width()/(bottomLabels.length-(horizontal?1:0));
                        var xlabelsUL=$('<ul class="visualize-labels-x"></ul>').width(canvas.width()).height(canvas.height()).insertBefore(canvas);
                        $.each(bottomLabels,function(i){
                            var thisLi=$('<li><span class="label">'+this+'</span></li>').prepend('<span class="line" />').css('left',xInterval*i).width(xInterval).appendTo(xlabelsUL);
                            if(horizontal){
                                var label=thisLi.find('span.label');
                                label.css("margin-left",-label.width()/2);
                            }
                        });
                        var leftLabels=horizontal?xLabels:yLabels;
                        var liBottom=canvas.height()/(leftLabels.length-(horizontal?0:1));
                        var ylabelsUL=$('<ul class="visualize-labels-y"></ul>').width(canvas.width()).height(canvas.height()).insertBefore(canvas);
                        $.each(leftLabels,function(i){
                            var thisLi=$('<li><span>'+this+'</span></li>').prependTo(ylabelsUL);
                            var label=thisLi.find('span:not(.line)').addClass('label');
                            if(horizontal){
                                label.css({
                                    'min-height':liBottom,
                                    'max-height':liBottom+1,
                                    'vertical-align':'middle'
                                });
                                thisLi.css({
                                    'top':liBottom*i,
                                    'min-height':liBottom
                                });
                                var r=label[0].getClientRects()[0];
                                if(r.bottom-r.top==liBottom){
                                    label.css('line-height',parseInt(liBottom)+'px');
                                }
                                else{
                                    label.css("overflow","hidden");
                                }
                            }
                            else{
                                thisLi.css('bottom',liBottom*i).prepend('<span class="line" />');
                                label.css('margin-top',-label.height()/2)
                            }
                        });
                        charts.bar.draw();
                    },
                    draw:function(){
                        if(horizontal){
                            ctx.rotate(Math.PI/2);
                        }
                        else{
                            ctx.translate(0,zeroLocY);
                        }
                        if(totalYRange<=0)
                            return;
                        var yScale=(horizontal?canvas.width():canvas.height())/totalYRange;
                        var barWidth=horizontal?(canvas.height()/xLabels.length):(canvas.width()/(bottomLabels.length));
                        var linewidth=(barWidth-o.barGroupMargin*2)/dataGroups.length;
                        for(var h=0;h<dataGroups.length;h++){
                            ctx.beginPath();
                            var strokeWidth=linewidth-(o.barMargin*2);
                            ctx.lineWidth=strokeWidth;
                            var points=dataGroups[h].points;
                            var integer=0;
                            for(var i=0;i<points.length;i++){
                                if(points[i].value!=0){
                                    var xVal=(integer-o.barGroupMargin)+(h*linewidth)+linewidth/2;
                                    xVal+=o.barGroupMargin*2;
                                    ctx.moveTo(xVal,0);
                                    ctx.lineTo(xVal,Math.round(-points[i].value*yScale));
                                }
                                integer+=barWidth;
                            }
                            ctx.strokeStyle=dataGroups[h].color;
                            ctx.stroke();
                            ctx.closePath();
                        }
                    }
                };

            })();
            var canvasNode=document.createElement("canvas");
            var canvas=$(canvasNode).attr({
                'height':o.height,
                'width':o.width
            });
            var title=o.title||self.find('caption').text();
            var canvasContain=(container||$('<div '+(o.chartId?'id="'+o.chartId+'" ':'')+'class="visualize '+o.chartClass+'" role="img" aria-label="Chart representing data from the table: '+title+'" />')).height(o.height).width(o.width);
            var scroller=$('<div class="visualize-scroller"></div>').appendTo(canvasContain).append(canvas);
            if(o.appendTitle||o.appendKey){
                var infoContain=$('<div class="visualize-info"></div>').appendTo(canvasContain);
            }
            if(o.appendTitle){
                $('<div class="visualize-title">'+title+'</div>').appendTo(infoContain);
            }
            if(o.appendKey){
                var newKey=$('<ul class="visualize-key"></ul>');
                $.each(yAllLabels,function(i,label){
                    $('<li><span class="visualize-key-color" style="background: '+dataGroups[i].color+'"></span><span class="visualize-key-label">'+label+'</span></li>').appendTo(newKey);
                });
                newKey.appendTo(infoContain);
            };

            if(o.interaction){
                var tracker=$('<div class="visualize-interaction-tracker"/>').css({
                    'height':o.height+'px',
                    'width':o.width+'px',
                    'position':'relative',
                    'z-index':200
                }).insertAfter(canvas);
                var triggerInteraction=function(overOut,data){
                    var data=$.extend({
                        canvasContain:canvasContain,
                        tableData:tableData
                    },data);
                    self.trigger('vizualize'+overOut,data);
                };
    
                var over=false,last=false,started=false;
                tracker.mousemove(function(e){
                    var x,y,x1,y1,data,dist,i,current,selector,zLabel,elem,color,minDist,found,ev=e.originalEvent;
                    x=ev.layerX||ev.offsetX||0;
                    y=ev.layerY||ev.offsetY||0;
                    found=false;
                    minDist=started?30000:(o.type=='pie'?(Math.round(canvas.height()/2)-o.pieMargin)/3:o.lineWeight*4);
                    $.each(charts[o.type].interactionPoints,function(i,current){
                        x1=current.canvasCords[0]+zeroLocX;
                        y1=current.canvasCords[1]+(o.type=="pie"?0:zeroLocY);
                        dist=Math.sqrt((x1-x)*(x1-x)+(y1-y)*(y1-y));
                        if(dist<minDist){
                            found=current;
                            minDist=dist;
                        }
                    });
                    if(o.multiHover&&found){
                        x=found.canvasCords[0]+zeroLocX;
                        y=found.canvasCords[1]+(o.type=="pie"?0:zeroLocY);
                        found=[found];
                        $.each(charts[o.type].interactionPoints,function(i,current){
                            if(current==found[0]){
                                return;
                            }
                            x1=current.canvasCords[0]+zeroLocX;
                            y1=current.canvasCords[1]+zeroLocY;
                            dist=Math.sqrt((x1-x)*(x1-x)+(y1-y)*(y1-y));
                            if(dist<=o.multiHover){
                                found.push(current);
                            }
                        });
                    }
                    over=found;
                    if(over!=last){
                        if(over){
                            if(last){
                                triggerInteraction('Out',{
                                    point:last
                                });
                            }
                            triggerInteraction('Over',{
                                point:over
                            });
                            last=over;
                        }
                        if(last&&!over){
                            triggerInteraction('Out',{
                                point:last
                            });
                            last=false;
                        }
                        started=true;
                    }
                });
                tracker.mouseleave(function(){
                    triggerInteraction('Out',{
                        point:last,
                        mouseOutGraph:true
                    });
                    over=(last=false);
                });
            }
            if(!container){
                canvasContain.insertAfter(this);
            }
            if(typeof(G_vmlCanvasManager)!='undefined'){
                G_vmlCanvasManager.init();
                G_vmlCanvasManager.initElement(canvas[0]);
            }
            var ctx=canvas[0].getContext('2d');
            scroller.scrollLeft(o.width-scroller.width());
            $.each($.visualizePlugins,function(i,plugin){
                plugin.call(self,o,tableData);
            });
            charts[o.type].setup();
            if(!container){
                self.bind('visualizeRefresh',function(){
                    self.visualize(o,$(this).empty());
                });
                self.bind('visualizeRedraw',function(){
                    charts[o.type].draw();
                });
            }
        }).next();
    };

    $.visualizePlugins=[];
})(jQuery);
(function($){
    $.visualizePlugins.push(function visualizeTooltip(options,tableData){
        var o=$.extend({
            tooltip:false,
            tooltipalign:'auto',
            tooltipvalign:'top',
            tooltipclass:'visualize-tooltip',
            tooltiphtml:function(data){
                if(options.multiHover){
                    var html='';
                    for(var i=0;i<data.point.length;i++){
                        html+='<p>'+data.point[i].value+' - '+data.point[i].yLabels[0]+'</p>';
                    }
                    return html;
                }else{
                    return'<p>'+data.point.value+' - '+data.point.yLabels[0]+'</p>';
                }
            },
            delay:false
        },options);
        if(!o.tooltip){
            return;
        }
        var self=$(this),canvasContain=self.next(),scroller=canvasContain.find('.visualize-scroller'),scrollerW=scroller.width(),tracker=canvasContain.find('.visualize-interaction-tracker');
        tracker.css({
            backgroundColor:'white',
            opacity:0,
            zIndex:100
        });
        var tooltip=$('<div class="'+o.tooltipclass+'"/>').css({
            position:'absolute',
            display:'none',
            zIndex:90
        }).insertAfter(scroller.find('canvas'));
        var usescroll=true;
        if(typeof(G_vmlCanvasManager)!='undefined'){
            scroller.css({
                'position':'absolute'
            });
            tracker.css({
                marginTop:'-'+(o.height)+'px'
            });
        }
        self.bind('vizualizeOver',function visualizeTooltipOver(e,data){
            if(data.canvasContain.get(0)!=canvasContain.get(0)){
                return;
            }
            if(o.multiHover){
                var p=data.point[0].canvasCords;
            }else{
                var p=data.point.canvasCords;
            }
            var left,right,top,clasRem,clasAd,bottom,x=Math.round(p[0]+data.tableData.zeroLocX),y=Math.round(p[1]+data.tableData.zeroLocY);
            if(o.tooltipalign=='left'||(o.tooltipalign=='auto'&&x-scroller.scrollLeft()<=scrollerW/2)){
                if($.browser.msie&&($.browser.version==7||$.browser.version==6)){
                    usescroll=false;
                }else{
                    usescroll=true;
                }
                left=x-(usescroll?scroller.scrollLeft():0);
                if(x-scroller.scrollLeft()<0){
                    return;
                }
                left=left+'px';
                right='';
                clasAdd="tooltipleft";
                clasRem="tooltipright";
            }else{
                if($.browser.msie&&$.browser.version==7){
                    usescroll=false;
                }else{
                    usescroll=true;
                }
                right=Math.abs(x-o.width)-(o.width-(usescroll?scroller.scrollLeft():0)-scrollerW);
                if(Math.abs(x-o.width)-(o.width-scroller.scrollLeft()-scrollerW)<0){
                    return;
                }
                left='';
                right=right+'px';
                clasAdd="tooltipright";
                clasRem="tooltipleft";
            }
            tooltip.addClass(clasAdd).removeClass(clasRem).html(o.tooltiphtml(data)).css({
                display:'block',
                top:y+'px',
                left:left,
                right:right
            });
        });
        self.bind('vizualizeOut',function visualizeTooltipOut(e,data){
            tooltip.css({
                display:'none'
            });
        });
    });
})(jQuery);
jQuery(function($){
    $('a.zoombox').zoombox({
        animation:false
    });
    $('.bloc .title').append('<a href="#" class="toggle"></a>');
    $('.bloc .title .tabs').parent().find('.toggle').remove();
    $('.bloc .title .toggle').click(function(){
        $(this).toggleClass('hide').parent().parent().find('.content').slideToggle(300);
        return false;
    });
    $('a[title!=""]').tooltipsy();
    $('table.graph').each(function(){
        var matches=$(this).attr('class').split(/type\-(area|bar|pie|line)/g);
        var options={
            height:'300px',
            width:parseInt($(this).width())-100,
            colors:['#c21c1c','#f1dc2b','#9ccc0a','#0accaa','#0a93cc','#8734c8','#26a4ed','#f45a90','#e9e744']
        };
            
        if(matches[1]!=undefined){
            options.type=matches[1];
        }
        if($(this).hasClass('dots')){
            options.lineDots='double';
        }
        if($(this).hasClass('tips')){
            options.interaction=true;
            options.multiHover=15,options.tooltip=true,options.tooltiphtml=function(data){
                var html='';
                for(var i=0;i<data.point.length;i++){
                    html+='<p class="stats_tooltip"><strong>'+data.point[i].value+'</strong> '+data.point[i].yLabels[0]+'</p>';
                }
                return html;
            }
        }
        $(this).hide().visualize(options);
    });
    $('a[href^="#"][href!="#"]').click(function(){
        cible=$(this).attr('href');
        if(cible=="#"){
            return false;
        }
        scrollTo(cible);
        return false;
    });
    if(!$.browser.msie){
        $('.iphone').iphoneStyle({
            checkedLabel:'YES',
            uncheckedLabel:'NO'
        });
    }
    $(".datepicker").datepicker();
    $('.range').each(function(){
        var cls=$(this).attr('class');
        var matches=cls.split(/([a-zA-Z]+)\-([0-9]+)/g);
        var options={
            animate:true
        };
    
        var elem=$(this).parent();
        elem.append('<div class="uirange"></div>');
        for(i in matches){
            i=i*1;
            if(matches[i]=='max'){
                options.max=matches[i+1]*1
            }
            if(matches[i]=='min'){
                options.min=matches[i+1]*1
            }
        }
        options.slide=function(event,ui){
            elem.find('span:first').empty().append(ui.value);
            elem.find('input:first').val(ui.value);
        }
        elem.find('span:first').empty().append(elem.find('input:first').val());
        options.range='min';
        options.value=elem.find('input:first').val();
        elem.find('.uirange').slider(options);
        $(this).hide();
    });
    $('.input.error input,.input textarea,.input select').focus(function(){
        $(this).parent().removeClass('error');
        $(this).parent().find('.error-message').fadeTo(500,0).slideUp();
        $(this).unbind('focus');
    });
    $('.notif .close').click(function(){
        $(this).parent().fadeTo(500,0).slideUp();
        return false;
    });
    var anchor=window.location.hash;
    $('.tabs').each(function(){
        var current=null;
        var id=$(this).attr('id');
        if(anchor!=''&&$(this).find('a[href="'+anchor+'"]').length>0){
            current=anchor;
        }else if($.cookie('tab'+id)&&$(this).find('a[href="'+$.cookie('tab'+id)+'"]').length>0){
            current=$.cookie('tab'+id);
        }else{
            current=$(this).find('a:first').attr('href');
        }
        $(this).find('a[href="'+current+'"]').addClass('active');
        $(current).siblings().hide();
        $(this).find('a').click(function(){
            var link=$(this).attr('href');
            if(link==current){
                return false;
            }else{
                $(this).addClass('active').siblings().removeClass('active');
                $(link).show().siblings().hide();
                current=link;
                $.cookie('tab'+id,current);
            }
        });
    });
    $('#content .checkall').change(function(){
        $(this).parents('table:first').find('input').attr('checked',$(this).is(':checked'));
    });
    var currentMenu=null;
    $('#sidebar>ul>li').each(function(){
        if($(this).find('li').length==0){
            $(this).addClass('nosubmenu');
        }
    })
    $('#sidebar>ul>li:not([class*="current"])>ul').hide();
    $('#sidebar>ul>li:not([class*="nosubmenu"])>a').click(function(){
        e=$(this).parent();
        $('#sidebar>ul>li.current').removeClass('current').find('ul:first').slideUp();
        e.addClass('current').find('ul:first').slideDown();
    });
    var htmlCollapse=$('#menucollapse').html();
    if($.cookie('isCollapsed')){
        $('body').addClass('collapsed');
        $('#menucollapse').html('&#9654;');
    }
    $('#menucollapse').click(function(){
        var body=$('body');
        body.toggleClass('collapsed');
        isCollapsed=body.hasClass('collapsed');
        if(isCollapsed){
            $(this).html('&#9654;');
        }else{
            $(this).html(htmlCollapse);
        }
        $.cookie('isCollapsed',isCollapsed);
        return false;
    });
    $('.placeholder,#content.login .input').each(function(){
        var label=$(this).find('label:first');
        var input=$(this).find('input:first,textarea:first');
        if(input.val()!=''){
            label.stop().hide();
        }
        input.focus(function(){
            if($(this).val()==''){
                label.stop().fadeTo(500,0.5);
            }
            $(this).parent().removeClass('error').find('.error-message').fadeOut();
        });
        input.blur(function(){
            if($(this).val()==''){
                label.stop().fadeTo(500,1);
            }
        });
        input.keypress(function(){
            label.stop().hide();
        });
        input.keyup(function(){
            if($(this).val()==''){
                label.stop().fadeTo(500,0.5);
            }
        });
        input.bind('cut copy paste',function(e){
            label.stop().hide();
        });
    });
    $('.close').click(function(){
        $(this).parent().fadeTo(500,0).slideUp();
    });
    $(window).resize(function(){
        $('.center').each(function(){
            $(this).css('display','inline');
            var width=$(this).width();
            if(parseInt($(this).height())<100){
                $(this).css({
                    width:'auto'
                });
            }else{
                $(this).css({
                    width:width
                });
            }
            $(this).css('display','block');
        });
        $('.calendar td').height($('.calendar td[class!="padding"]').width());
    });
    $(window).trigger('resize');
    function scrollTo(cible){
        if($(cible).length>=1){
            hauteur=$(cible).offset().top;
        }else{
            return false;
        }
        hauteur-=(windowH()-$(cible).height())/2;
        $('html,body').animate({
            scrollTop:hauteur
        },1000,'easeOutQuint');
        return false;
    }
    function windowH(){
        if(window.innerHeight)return window.innerHeight;
        else{
            return $(window).height();
        }
    }
});
jQuery.easing['jswing']=jQuery.easing['swing'];
jQuery.extend(jQuery.easing,{
    def:'easeOutQuad',
    swing:function(x,t,b,c,d){
        return jQuery.easing[jQuery.easing.def](x,t,b,c,d);
    },
    easeInQuad:function(x,t,b,c,d){
        return c*(t/=d)*t+b;
    },
    easeOutQuad:function(x,t,b,c,d){
        return-c*(t/=d)*(t-2)+b;
    },
    easeInOutQuad:function(x,t,b,c,d){
        if((t/=d/2)<1)return c/2*t*t+b;
        return-c/2*((--t)*(t-2)-1)+b;
    },
    easeInCubic:function(x,t,b,c,d){
        return c*(t/=d)*t*t+b;
    },
    easeOutCubic:function(x,t,b,c,d){
        return c*((t=t/d-1)*t*t+1)+b;
    },
    easeInOutCubic:function(x,t,b,c,d){
        if((t/=d/2)<1)return c/2*t*t*t+b;
        return c/2*((t-=2)*t*t+2)+b;
    },
    easeInQuart:function(x,t,b,c,d){
        return c*(t/=d)*t*t*t+b;
    },
    easeOutQuart:function(x,t,b,c,d){
        return-c*((t=t/d-1)*t*t*t-1)+b;
    },
    easeInOutQuart:function(x,t,b,c,d){
        if((t/=d/2)<1)return c/2*t*t*t*t+b;
        return-c/2*((t-=2)*t*t*t-2)+b;
    },
    easeInQuint:function(x,t,b,c,d){
        return c*(t/=d)*t*t*t*t+b;
    },
    easeOutQuint:function(x,t,b,c,d){
        return c*((t=t/d-1)*t*t*t*t+1)+b;
    },
    easeInOutQuint:function(x,t,b,c,d){
        if((t/=d/2)<1)return c/2*t*t*t*t*t+b;
        return c/2*((t-=2)*t*t*t*t+2)+b;
    },
    easeInSine:function(x,t,b,c,d){
        return-c*Math.cos(t/d*(Math.PI/2))+c+b;
    },
    easeOutSine:function(x,t,b,c,d){
        return c*Math.sin(t/d*(Math.PI/2))+b;
    },
    easeInOutSine:function(x,t,b,c,d){
        return-c/2*(Math.cos(Math.PI*t/d)-1)+b;
    },
    easeInExpo:function(x,t,b,c,d){
        return(t==0)?b:c*Math.pow(2,10*(t/d-1))+b;
    },
    easeOutExpo:function(x,t,b,c,d){
        return(t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b;
    },
    easeInOutExpo:function(x,t,b,c,d){
        if(t==0)return b;
        if(t==d)return b+c;
        if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;
        return c/2*(-Math.pow(2,-10*--t)+2)+b;
    },
    easeInCirc:function(x,t,b,c,d){
        return-c*(Math.sqrt(1-(t/=d)*t)-1)+b;
    },
    easeOutCirc:function(x,t,b,c,d){
        return c*Math.sqrt(1-(t=t/d-1)*t)+b;
    },
    easeInOutCirc:function(x,t,b,c,d){
        if((t/=d/2)<1)return-c/2*(Math.sqrt(1-t*t)-1)+b;
        return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;
    },
    easeInElastic:function(x,t,b,c,d){
        var s=1.70158;
        var p=0;
        var a=c;
        if(t==0)return b;
        if((t/=d)==1)return b+c;
        if(!p)p=d*.3;
        if(a<Math.abs(c)){
            a=c;
            var s=p/4;
        }
        else var s=p/(2*Math.PI)*Math.asin(c/a);
        return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;
    },
    easeOutElastic:function(x,t,b,c,d){
        var s=1.70158;
        var p=0;
        var a=c;
        if(t==0)return b;
        if((t/=d)==1)return b+c;
        if(!p)p=d*.3;
        if(a<Math.abs(c)){
            a=c;
            var s=p/4;
        }
        else var s=p/(2*Math.PI)*Math.asin(c/a);
        return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b;
    },
    easeInOutElastic:function(x,t,b,c,d){
        var s=1.70158;
        var p=0;
        var a=c;
        if(t==0)return b;
        if((t/=d/2)==2)return b+c;
        if(!p)p=d*(.3*1.5);
        if(a<Math.abs(c)){
            a=c;
            var s=p/4;
        }
        else var s=p/(2*Math.PI)*Math.asin(c/a);
        if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;
        return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b;
    },
    easeInBack:function(x,t,b,c,d,s){
        if(s==undefined)s=1.70158;
        return c*(t/=d)*t*((s+1)*t-s)+b;
    },
    easeOutBack:function(x,t,b,c,d,s){
        if(s==undefined)s=1.70158;
        return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b;
    },
    easeInOutBack:function(x,t,b,c,d,s){
        if(s==undefined)s=1.70158;
        if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;
        return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b;
    },
    easeInBounce:function(x,t,b,c,d){
        return c-jQuery.easing.easeOutBounce(x,d-t,0,c,d)+b;
    },
    easeOutBounce:function(x,t,b,c,d){
        if((t/=d)<(1/2.75)){
            return c*(7.5625*t*t)+b;
        }else if(t<(2/2.75)){
            return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;
        }else if(t<(2.5/2.75)){
            return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;
        }else{
            return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;
        }
    },
    easeInOutBounce:function(x,t,b,c,d){
        if(t<d/2)return jQuery.easing.easeInBounce(x,t*2,0,c,d)*.5+b;
        return jQuery.easing.easeOutBounce(x,t*2-d,0,c,d)*.5+c*.5+b;
    }
});