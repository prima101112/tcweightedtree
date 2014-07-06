<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</button>
<a class="brand" href="#">e-jurnal semantic</a>
<div class="nav-collapse collapse">
    <ul class="nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">menu <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><? echo anchor('', 'home') ?></li>
            </ul>
        </li>
    </ul>
    <form class="navbar-form pull-right" action="<?php echo site_url(); ?>user/cek_login" method="post">
        <input class="span2" type="text" placeholder="Username" name="username">
        <input class="span2" type="password" placeholder="Password" name="password">
        <button type="submit" class="btn">Sign in</button>
    </form>
</div><!--/.nav-collapse -->