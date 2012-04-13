<!doctype html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo $kindling->get_content('title', NULL, TRUE); if ($kindling->get_content('title_appendage')) echo ' | ' . $kindling->get_content('title_appendage', NULL, TRUE); ?></title>

	<?php echo $kindling->get_meta(); ?>

	<meta name="viewport" content="width=device-width">

	<?php echo $kindling->get_css(); ?>

	<script src="<?php echo $kindling->get_config('js_uri'); ?>libs/modernizr-2.5.2.min.js"></script>

</head>

<body id="<?php echo $kindling->get_content('body_id'); ?>" class="<?php echo trim(trim($kindling->get_content('section') . ' ' .$kindling->get_content('page')) . ' ' . $kindling->get_content('body_class')); ?>">

<div id="wrapper" class="clearfix">

	<header id="primary-header">

	</header> <!-- end #primary-header -->

	<div id="content">

		<?php

			echo $kindling->get_messages();

			echo $kindling->get_content('primary');

		?>

	</div> <!-- end #content -->

	<footer id="primary-footer">

	</footer> <!-- end #primary-footer -->

</div> <!-- end #wrapper -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/libs/jquery-1.7.2.min.js"><\/script>')</script>

<?php echo $kindling->get_js(); ?>

<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>