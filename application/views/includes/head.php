<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Webmak.in | <?php echo $title; ?></title>
    <meta charset="utf-8">
    <link rel="icon" href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/iconmetal.png" />
    <meta name="description" content="Your description">
    <meta name="keywords" content="Your keywords">
    <meta name="author" content="Asif">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/responsive.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/nivo-slider.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/carousel.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/touchTouch.css" type="text/css" media="screen">
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/superfish.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.mobilemenu.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.carouFredSel-6.1.0.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/touchTouch.jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.equalheights.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider({
			prevText: '',
			nextText: ''
      });
        jQuery(".maxheight").equalHeights();  
	$('.list-rooms').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',    
        scroll: 1,
        prev: '#prev2',
        next: '#next2',
        pagination: false,
        mousewheel: true,
        items: {
        height: 'auto',
        width: '270',
        visible: {
        min: 1,
        max: 4
        }
        },
        swipe: {
          onMouse: true,
          onTouch: true
          }
        });
    $('.magnifier').touchTouch();
    });
    </script>

	<!--[if lt IE 8]>
    		<div style='text-align:center'><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/img/upgrade.jpg"border="0"alt=""/></a></div>  
   	<![endif]-->
    <!--[if lt IE 9]>
      <link rel="stylesheet" href="css/docs.css" type="text/css" media="screen">
      <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
</head>
<body>
<!--==============================header=================================-->
<header>
    <div class="container">
		<?php $this->load->view('includes/nav');  ?>
    </div>
</header>