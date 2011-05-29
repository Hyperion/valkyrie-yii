<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/local-common/css/common.css?v20" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/css/wow.css?v10" />
	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/css/profile.css?v10" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/css/character/summary.css?v10" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/css/wiki/wiki.css?v10" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/css/wiki/item.css?v10" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/local-common/css/cms/comments.css?v20" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/wow/static/css/cms.css?v10" />
	<script type="text/javascript" src="/wow/static/local-common/js/third-party/jquery-1.4.4-p1.min.js"></script> 
	<script type="text/javascript" src="/wow/static/local-common/js/core.js?v20"></script> 
	<script type="text/javascript" src="/wow/static/local-common/js/tooltip.js?v20"></script> 
	<script type="text/javascript"> 
	//<![CDATA[
	Core.staticUrl = '/wow/static';
	Core.sharedStaticUrl= '/wow/static/local-common';
	Core.baseUrl = '/wow';
	Core.supportUrl = 'http://eu.battle.net/support/';
	Core.secureSupportUrl= 'https://eu.battle.net/support/';
	Core.project = 'wow';
	Core.locale = 'ru-ru';
	Core.buildRegion = 'eu';
	Core.shortDateFormat= 'dd/MM/Y';
	Core.dateTimeFormat = 'dd/MM/yyyy HH:mm';
	Core.loggedIn = false;
	Flash.videoPlayer = 'http://eu.media.blizzard.com/global-video-player/themes/wow/video-player.swf';
	Flash.videoBase = 'http://eu.media.blizzard.com/wow/media/videos';
	Flash.ratingImage = 'http://eu.media.blizzard.com/global-video-player/ratings/wow/rating-pegi.jpg';
	Flash.expressInstall= 'http://eu.media.blizzard.com/global-video-player/expressInstall.swf';
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-544112-16']);
	_gaq.push(['_setDomainName', '.battle.net']);
	_gaq.push(['_trackPageview']);
	_gaq.push(['_trackPageLoadTime']);
	//]]>
	</script> 
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="wrapper">
	<div id="header"> 
		<div id="search-bar"> 
		<form action="/wow/en/search" method="get" id="search-form"> 
		<div> 
		<input type="submit" id="search-button" value="" tabindex="41"/> 
		<input type="text" name="q" id="search-field" maxlength="200" tabindex="40" alt="Search characters, items, forums and more…" value="Search characters, items, forums and more…" /> 
		</div> 
		</form> 
		</div>
		
		<h1 id="logo"><a href="/wow/en/">World of Warcraft</a></h1>
		
		<div class="header-plate"> 
		<div class="user-plate ajax-update"> 
		<a href="?login" class="card-login"
		onclick="BnetAds.trackImpression('Battle.net Login', 'Character Card', 'New'); return Login.open('https://eu.battle.net/login/login.frag');"> 
		<strong>Log in now</strong> to enhance and personalize your experience!
		</a>
		<div class="card-overlay"></div> 
		</div>
	</div> 
</div>
	<div id="content">
		<div class="content-top"> 
			<div class="content-trail"></div>
			<div class="content-bot"><?php echo $content; ?></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/wow/static/js/wow.js?v10"></script> 
<script type="text/javascript" src="/wow/static/js/profile.js?v10"></script>
<script type="text/javascript" src="/wow/static/js/character/summary.js?v10"></script>
</body></html>
