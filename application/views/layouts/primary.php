<!doctype html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo $this->get_content('title', NULL, TRUE); if ($this->get_content('title_appendage')) echo ' | ' . $this->get_content('title_appendage', NULL, TRUE); ?></title>

	<?php echo $this->get_meta(); ?>

	<meta name="viewport" content="width=device-width">

	<?php if ($this->get_config('css_include_default')): ?>

	<link rel="stylesheet" href="<?php echo $this->get_config['css_path'] . '/style.' . $this->get_config['cache_version']; ?>.css">

	<?php endif; ?>

	<?php

		if ($this->get_config('parse_css'))
			echo $this->get_css();
	?>

	<?php if ($this->get_config('parse_js')): ?>

		<script src="js/libs/modernizr-2.5.2.min.js"></script>

	<?php endif; ?>

</head>

<body id="<?php echo $this->get_content('body_id'); ?>" class="<?php echo trim(trim($this->get_content('section') . ' ' .$this->get_content('page')) . ' ' . $this->get_content('body_class')); ?>">

<div id="wrapper" class="clearfix">

	<header id="primary-header">

	</header> <!-- end #main-header -->

	<div id="content">

		<?php

			echo $this->get_messages();

			echo $this->get_content('primary');

		?>

	</div> <!-- end #content -->

	<footer id="primary-footer">

	</footer> <!-- end #main-footer -->

</div> <!-- end #wrapper -->

<?php if ($this->get_config('parse_js')): ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

<script src="js/plugins.js"></script>

<script src="js/script.js"></script>

<?php echo $this->get_js(); ?>

	<?php if ($this->get_config('js_include_ga')): ?>

	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>

	<?php endif; ?>

<?php endif; ?>

</body>
</html>