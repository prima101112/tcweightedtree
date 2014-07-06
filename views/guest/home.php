<div class="hero-unit">
    <h1 style="letter-spacing: -7px;">Search Journal</h1>
    <p>This is a research of semantic search with weighted tree similarity for e-journal .</p>
    <p>
    <div class="accordion" id="accordion2">

        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle btn-info" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                    Search one form
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner" style="background-color: white;">
                    <?php echo form_open('search/search_one_form'); ?>
                        <hr>
                        Search
                        <div class="input-append">
                            <input class="span4" id="appendedInputButton" type="text" class="fontbig" name="frase">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                        <hr>
                    <? echo form_close(); ?>
                </div>
            </div>
        </div>
<!--        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle btn-danger" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                    Search with properties
                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner" style="background-color: white;">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Judul</label>
                            <div class="controls">
                                <input type="text" id="inputEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Penulis</label>
                            <div class="controls">
                                <input type="password" id="inputPassword" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Keyword</label>
                            <div class="controls">
                                <input type="password" id="inputPassword" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">tahun</label>
                            <div class="controls">
                                <input type="password" id="inputPassword" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>-->

    </div>
    <!--    <form>
            <div class="input-append">
                <input class="span4" id="appendedInputButton" type="text" class="fontbig">
                <button class="btn btn-primary" type="button">Search</button>
            </div>
        </form>-->
</p>
</div>

<!--<div class="row-fluid">
    <div class="span4">
        <h2>Heading</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span4">
        <h2>Heading</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span4">
        <h2>Heading</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
</div>-->