<!DOCTYPE html>
<html>
<head>	
	<title><?php echo $title; ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="google" content="notranslate">

	<link rel="icon" type="image/x-icon" href="<?php echo img_url('favicon.ico')?>">

	<meta name="description" content="Site officiel des Ch'tis Gamers, Club de l'école d'ingénieurs du littoral côte d'opale">


	<!-- meta OG -->
	<meta property="og:title" content="Ch'tis Gamers - Eilco">
	<meta property="og:type" content="website">
	<meta property="og:description" content="Site internet des Ch'tis gamers, association de l'école d'ingénieurs du littoral côte d'opale.">
	<meta property="og:url" content="<?php echo base_url()?>">
	<meta property="og:image" content="<?php echo img_url('default.png')?>">

	<meta property="fb:app_id" content="">
	<meta name="twitter:card" content="summary">


	<!--google icone-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!-- styles -->
	<?php foreach($styles as $css): ?>
		<link rel="stylesheet" type="text/css" href="<?php echo css_url($css); ?>">
	<?php endforeach; ?>
	<!-- fonts -->
	<?php foreach($fonts as $font): ?>
		<link href="<?php echo font_url($font); ?>" rel="stylesheet">
	<?php endforeach; ?>
	<!-- remote fonts -->
	<?php foreach($remote_fonts as $font): ?>
		<link href="<?php echo $font ?>" rel="stylesheet" type="text/css">
	<?php endforeach; ?>
</head>
<body>

<?php echo $content; ?>

<?php foreach ($scripts as $script): ?>
	<script type="text/javascript" src="<?php echo js_url($script); ?>"></script>
<?php endforeach; ?>
</body>
</html>