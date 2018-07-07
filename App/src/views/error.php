<!DOCTYPE html>
<html>
<head>
	<title>404</title>

	<!--metadata-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<link rel="icon" type="image/x-icon" href="<?php echo img_url('favicon.ico')?>">

	<link rel="stylesheet" type="text/css" href="<?php echo css_url("error") ?>">
	<link href="<?php echo base_url('assets/fonts/Walkway_SemiBold.ttf'); ?>" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo css_url('materializeCG'); ?>">
</head>
<body>
	<div id="div4" class="flex-container" style="background-image: url(<?php echo img_url('error/chtis.png')?>)">
		<div id="div1" class="flex-item">ERROR 404 <?php echo $message?></div>
		<div id="div2" class="flex-container" style="background-image: url(<?php echo img_url('error/item_box.png')?>)">
			<div id="div3" class="flex-item">
				<a href="<?php echo base_url()?>">
				<img src="<?php echo img_url('error/Map_Icon.png')?>" alt = "site des Ch'tis Gamers" />
				</a>
			</div>
			<div id="div5" class="flex-item">
				<a href="https://www.facebook.com/ChtisGamers/">
				<img src="<?php echo img_url('error/fb.png')?>" alt = "fb" />
				</a>
			</div>

			<div id="div6" class="flex-item">
				<a href="https://www.twitch.tv/chtisgamers">
				<img src="<?php echo img_url('error/twitch.png')?>" alt = "twitch" />
				</a>
			</div>

			<div id="div7" class="flex-item">
				<a href="https://www.youtube.com/channel/UC6KFy2gEWKHSlDE5YP7EInQ">
				<img src="<?php echo img_url('error/youtube.png')?>" alt = "youtube" />
				</a>
			</div>

		</div>
	</div>
</body>
</html>