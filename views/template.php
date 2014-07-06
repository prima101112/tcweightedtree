<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SKRIPSI !! jurnal | semantic | weighted tree | admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">


        <script src="<?php echo base_url(); ?>assets/bootstrap/js/jquery.js"></script>
        <!-- Le styles -->
        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../assets/ico/favicon.png">
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <? include ('admin/nav.php'); ?>
                </div>
            </div>
        </div>

        <div class="container">

            <? include ($content); ?>

        </div> <!-- /container -->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
         <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-dropdown.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-transition.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-alert.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-modal.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-scrollspy.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-tab.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-popover.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-button.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-collapse.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-carousel.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-typeahead.js"></script>

    </body>
</html>
