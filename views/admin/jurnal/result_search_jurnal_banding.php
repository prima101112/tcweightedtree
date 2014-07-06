

<div class="container-fluid">
    <div class="row-fluid alert-block">
        <h4 style="color: #333333;">Search Journal</h4>

        <?php echo form_open('search/search_one_form'); ?>


        <div class="input-append">
            <input class="span12" id="appendedInputButton" type="text" class="fontbig" name="frase" style="width: 200%;" value="<? echo $frase ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>

        <? echo form_close(); ?>

    </div>
    <div class="row-fluid">
        <?
        $no = $no = $this->uri->segment(3) + 1;

        $data_cos = $data_jurnal[0];
        $data_tanim = $data_jurnal[1];
        $data_btwc = $data_jurnal[2];
        ?>
        
        <!--cosin ==================================================================================-->
        <div class="span4">
            <div class="row-fluid">
                <p class="alert alert-info">Cosine | <? echo count($data_cos); ?> result</p>
                <?php
                if ($data_cos != null) {
                    rsort($data_cos);
                    for ($i = 0; $i < count($data_cos); $i++) {
                        if ($data_cos[$i]['sim'] != 0) {
                            $id_jurnal = $data_cos[$i]['id'];
                            $judul_jurnal = $data_cos[$i]['judul'];
                            $sim_jurnal = $data_cos[$i]['sim'];
                            $abstrak_jurnal = $data_cos[$i]['abstrak'];
                            ?>
                            <? //echo $id_jurnal; ?>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <div class="span12 row-fluid">
                                            <div class="row-fluid">
                                                <div class="span12"><? echo $no; ?> | <? echo $sim_jurnal; ?> 
                                                    <h5><a href="view_detail_jurnal/<? echo $id_jurnal ?>"> <? echo $judul_jurnal; ?> </a></h5></div>  
                                            </div>
                                        </div>
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <div class="span9" style="font-size: 9pt; line-height: 120%;">
                                                    <p><? echo substr($abstrak_jurnal, 0, 50); ?>.. <a href="view_detail_jurnal/<? echo $id_jurnal ?>">more</a></p></div>  
                                            </div>
                                            <hr style="margin: 7px 0; width: 70%;">
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <?
                            $no++;
                        }
                    }
                } else {
                    ?><div class="row-fluid"><div class="alert alert-warning">search kosong</div></div><?
                }
                ?>
            </div>

        </div> 
        
        <!--tanimoto ===========================================================-->
         <div class="span4">
            <div class="row-fluid">
                   <p class="alert alert-danger">Tanimoto | <? echo count($data_tanim); ?> result</p>
                <?php
                $no = 1;
                if ($data_tanim != null) {
                    rsort($data_tanim);
                    for ($i = 0; $i < count($data_tanim); $i++) {
                        if ($data_tanim[$i]['sim'] != 0) {
                            $id_jurnal = $data_tanim[$i]['id'];
                            $judul_jurnal = $data_tanim[$i]['judul'];
                            $sim_jurnal = $data_tanim[$i]['sim'];
                            $abstrak_jurnal = $data_tanim[$i]['abstrak'];
                            ?>
                            <? //echo $id_jurnal; ?>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <div class="span12 row-fluid">
                                            <div class="row-fluid">
                                                <div class="span12"><? echo $no; ?> | <? echo $sim_jurnal; ?> 
                                                    <h5><a href="view_detail_jurnal/<? echo $id_jurnal ?>"> <? echo $judul_jurnal; ?> </a></h5></div>  
                                            </div>
                                        </div>
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <div class="span9" style="font-size: 9pt; line-height: 120%;">
                                                    <p><? echo substr($abstrak_jurnal, 0, 50); ?>.. <a href="view_detail_jurnal/<? echo $id_jurnal ?>">more</a></p></div>  
                                            </div>
                                            <hr style="margin: 7px 0; width: 70%;">
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <?
                            $no++;
                        }
                    }
                } else {
                    ?><div class="row-fluid"><div class="alert alert-warning">search kosong</div></div><?
                }
                ?>
            </div>

        </div> 
        <!--BTWC =========================================================-->
         <div class="span4">
            <div class="row-fluid">
                <p class="alert alert-success">btwc | <? echo count($data_btwc); ?> result</p>
                <?php
                $no = 1;
                if ($data_btwc != null) {
                    rsort($data_btwc);
                    for ($i = 0; $i < count($data_btwc); $i++) {
                        if ($data_btwc[$i]['sim'] != 0) {
                            $id_jurnal = $data_btwc[$i]['id'];
                            $judul_jurnal = $data_btwc[$i]['judul'];
                            $sim_jurnal = $data_btwc[$i]['sim'];
                            $abstrak_jurnal = $data_btwc[$i]['abstrak'];
                            ?>
                            <? //echo $id_jurnal; ?>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <div class="span12 row-fluid">
                                            <div class="row-fluid">
                                                <div class="span12"><? echo $no; ?> | <? echo $sim_jurnal; ?> 
                                                    <h5><a href="view_detail_jurnal/<? echo $id_jurnal ?>"> <? echo $judul_jurnal; ?> </a></h5></div>  
                                            </div>
                                        </div>
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <div class="span9" style="font-size: 9pt; line-height: 120%;">
                                                    <p><? echo substr($abstrak_jurnal, 0, 50); ?>.. <a href="view_detail_jurnal/<? echo $id_jurnal ?>">more</a></p></div>  
                                            </div>
                                            <hr style="margin: 7px 0; width: 70%;">
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <?
                            $no++;
                        }
                    }
                } else {
                    ?><div class="row-fluid"><div class="alert alert-warning">search kosong</div></div><?
                }
                ?>
            </div>

        </div> 
        
    </div><!--/row-->

</div><!--/span-->



