<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
	
<link rel="stylesheet" type="text/css" media="all" href="/css/local-common/common.css" /> 
<link rel="stylesheet" type="text/css" media="all" href="/css/wow/wow.css" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
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
	//]]>
</script>
</head>
<body class="<?=$this->body_class?>">
<div id="wrapper">
	<div id="header"> 
		<div id="search-bar"> 
		<form action="/wow/search" method="get" id="search-form"> 
		<div> 
		<input type="submit" id="search-button" value="" tabindex="41"/> 
		<input type="text" name="q" id="search-field" maxlength="200" tabindex="40" alt="Search characters, items, forums and more…" value="Search characters, items, forums and more…" /> 
		</div> 
		</form> 
		</div>
		
		<h1 id="logo"><a href="/">World of Warcraft</a></h1>
		
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
			<div class="content-trail">
<?php 
$this->widget('zii.widgets.CBreadcrumbs', array(
    'links'=>$this->breadcrumbs,
));
?>
                         </div>
			<div class="content-bot"><?php echo $content; ?></div>
		</div>
	</div>
</div>
</body></html>
