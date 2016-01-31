<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Luis Rodriguez">
        <meta name="author" content="Luis Rodriguez">

        <title>Carlos Luis Rodriguez Nieto</title>

        <!-- Web Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo $resources_path; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- Font Awesome CSS -->
        <link href="<?php echo $resources_path; ?>/css/font-awesome.min.css" rel="stylesheet" media="screen">
        <!-- Animate css -->
        <link href="<?php echo $resources_path; ?>/css/animate.css" rel="stylesheet">
        <!-- Magnific css -->
        <link href="<?php echo $resources_path; ?>/css/magnific-popup.css" rel="stylesheet">
        <!-- Custom styles CSS -->
        <link href="<?php echo $resources_path; ?>/css/style.css" rel="stylesheet" media="screen">
        <!-- Responsive CSS -->
        <link href="<?php echo $resources_path; ?>/css/responsive.css" rel="stylesheet">
        <!-- JGROW CSS -->
        <link href="<?php echo base_url("resources/css/styles.min.css"); ?>" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="<?php echo base_url("resources/img/favicon.ico"); ?>">

        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.stellar.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.sticky.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/smoothscroll.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/wow.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.countTo.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.inview.min.js"></script> 
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.easypiechart.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.shuffle.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.magnific-popup.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/froogaloop2.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/jquery.fitvids.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo base_url("resources/js/jgrowl.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('site/js/core'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('site/js/mvc/layout'); ?>"></script>
    </head>
    <body>
        <?php echo $content; ?>
        <script type="text/javascript">
            Core.init();
        </script>
    </body>

</html>