<?php
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCssFile('/css/red.css');
	$cs->registerScriptFile('http://userapi.com/js/api/openapi.js?25');
	$cs->registerScript('1','VK.init({apiId: 2312117, onlyWidgets: true});',0);
?>
<table id="red">
<tr>
    <th>Статистика</th>
    <th>Мы в других проектах</th>
    <th>Благотворительность</th>
</tr>
<tr>
<td>
<script type="text/javascript" src="http://jg.revolvermaps.com/r.js"></script>
<script type="text/javascript">
    rm_f1st('0','220','true','false','000000','61hdalgao7s','true','ff0000');
</script>
<noscript>
    <applet
        codebase="http://rg.revolvermaps.com/j"
        code="core.RE"
        width="220"
        height="220"
        archive="g.jar">
        <param name="cabbase" value="g.cab" />
        <param name="r" value="true" />
        <param name="n" value="false" />
        <param name="i" value="61hdalgao7s" />
        <param name="m" value="0" />
        <param name="s" value="220" />
        <param name="c" value="ff0000" />
        <param name="v" value="true" />
        <param name="b" value="000000" />
        <param name="rfc" value="true" />
    </applet>
</noscript>
</td>
<td>
<img src="<?=Yii::app()->request->baseUrl?>/images/vkontakte.png" />
<img src="<?=Yii::app()->request->baseUrl?>/images/facebook.png" />
<img src="<?=Yii::app()->request->baseUrl?>/images/livejournal.png" />
<div style="height: 20px"></div>
<b>Соц сети</b>
<div id="vk_like" style="margin-left:25px"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "button", width: 250});
</script>
<br />
<iframe src="http://www.facebook.com/plugins/like.php?href=project"
        scrolling="no" frameborder="0"
        style="border:none; width:250px; height:80px">
</iframe>
</td>
<td>
<b>Яндекс деньги:</b> 12345678<br />
<b>Webmoney:</b> R12345678<br /><br />
<i>Просьба указывать в назначании платежа "на развитие проекта"</i>
</td>
</tr>
<tr>
<td colspan="3">
<div id="left">
<div>
<b>Наш банер</b><br />
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
    $("input.banner").change(function(){
        var id = $(this).attr("id");
        var html_code = '<img src="<?=Yii::app()->request->hostInfo?>/images/banner/'+id+'.png" alt="<?=CHtml::encode(Yii::app()->name)?>" />'; 
        var bb_code = '[img alt="<?=CHtml::encode(Yii::app()->name)?>"]<?=Yii::app()->request->hostInfo?>/images/banner/'+id+'.png[/img]';
        $("img.banner").attr({ src: "/images/banner/"+id+".png", alt: '<?=CHtml::encode(Yii::app()->name)?>' });
        $("#html_code").text(html_code);
        $("#bb_code").text(bb_code);
        return false;
    });
});
/*]]>*/
</script>
<input type="radio" name="browser" class="banner" href="#" id="120x240" checked="checked"/>120 x 240 вертикальный баннер<br />
<input type="radio" name="browser" class="banner" href="#" id="468x60" />468 x 60 длинный баннер<br />
<input type="radio" name="browser" class="banner" href="#" id="500x100" />500 x 100 горизонтальный<br />
<input type="radio" name="browser" class="banner" href="#" id="120x90" />120 x 90 кнопка<br />
</div>
<div>
Html код:<br />
<textarea id="html_code" cols="32" rows="5"><img src="<?=Yii::app()->request->hostInfo?>/images/banner/120x240.png" alt="<?=Yii::app()->name?>" /></textarea>
BB код:<br />
<textarea id="bb_code" cols="32" rows="5">[img alt="<?=Yii::app()->name?>"]<?=Yii::app()->request->hostInfo?>/images/banner/120x240.png[/img]</textarea>
</div>
</div>
<div id = "right" class="banner">
<img src="/images/banner/120x240.png" alt="" class="banner" />
</div>
</td>
</tr>
</table>
