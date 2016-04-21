<?php headway_html_open() ?>
	
<title><?php headway_title(); ?></title>
<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />

<link rel="alternate" type="application/rss+xml" href="<?php echo headway_rss() ?>" title="<?php echo get_bloginfo('name')?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />


<?php wp_head() ?>
<script type='text/javascript' src='<?= get_bloginfo('template_url') ?>/custom/js/custom.js'></script>
<meta name="google-site-verification" content="5euqdZaLKEq9K2z06MpIkmpOy2qdOBEINzh6sg7QcBQ" />
</head> <!-- End <head> -->


<?php headway_page_top() ?>