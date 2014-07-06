<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</button>
<a class="brand" href="#">e-jurnal semantic</a>
<div class="nav-collapse collapse">
    <ul class="nav">
        <li><? echo anchor('indeks/admin', 'Home') ?></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Jurnal <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><? echo anchor('jurnal/all_jurnal_per_page', 'all jurnal') ?></li>
                <li><? echo anchor('jurnal/add_jurnal', 'add jurnal') ?></li>
                <li class="divider"></li>
<!--                <li class="nav-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>-->
            </ul>
        </li>
        <li><? echo anchor('user/logout', 'Logout') ?></li>
    </ul>
</div><!--/.nav-collapse -->