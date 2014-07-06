<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SKRIPSI !! jurnal | semantic | weighted tree</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <script src="<?php echo base_url(); ?>assets/bootstrap/js/jquery.js"></script>

        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
                padding-bottom: 40px;
            }
            input[type="text"]>.fontbig{
                height: 40px
            }
        </style>
        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../assets/ico/favicon.png">
    </head>

    <body style="padding-top: 3px; ">


        <div class="container-fluid" style="padding-top: 0; margin-top:0;">

            <div class="row-fluid">
                <div class="span10" style="padding-left: 10px;"><?
                    include ($content);
                    ?>
                </div>
                
                <div class="span2" style="padding-left: 9px; color: #788c96;">
                    <br><br>
                    <div class="well sidebar-nav">
                        
                        <h4>sign in here</h4>
                        <form action="<?php echo site_url(); ?>user/cek_login" method="post">
                            <input class="span12" type="text" placeholder="Username" name="username"><br>
                            <input class="span12" type="password" placeholder="Password" name="password"><br>
                            <button type="submit" class="btn span12">Sign in</button>
                        </form>
                    </div><!--/.well -->
                    <a href="<? echo base_url(); ?>indeks"><button class="btn" style="width: 100%">Menu</button></a>
                </div>
            </div>

            <hr style="border: 0px; height: 30px; ">



            <footer>
                <p style="font-size: 8pt">&copy; Skripsi 2014 | Prima adi p | <font color="#0b9ade">execution time : <?
                echo $this->benchmark->elapsed_time('code_start', 'code_end');?> sec</font></p>
              <? $this->benchmark->mark('code_end');?>
                <p style="font-size: 8pt"> </p>
            </footer>

        </div> 
       

    </body>
</html>
