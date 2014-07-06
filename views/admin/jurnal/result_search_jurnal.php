

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
        
        <div class="span11">
            <div class="row-fluid">

                <?php
                $no = $no = $this->uri->segment(3) + 1;
                if ($data_jurnal != null) {
                    rsort($data_jurnal);
                    for ($i = 0; $i < count($data_jurnal); $i++) {
                        if ($data_jurnal[$i]['sim'] != 0) {
                            $id_jurnal = $data_jurnal[$i]['id'];
                            $judul_jurnal = $data_jurnal[$i]['judul'];
                            $sim_jurnal = $data_jurnal[$i]['sim'];
                            $abstrak_jurnal = $data_jurnal[$i]['abstrak'];
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
                                                    <p><? echo substr($abstrak_jurnal, 0, 250); ?>.. <a href="view_detail_jurnal/<? echo $id_jurnal ?>">more</a></p></div>  
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
                }else {
                    ?><div class="row-fluid"><div class="alert alert-warning">search kosong</div></div><?
                }
                ?>
            </div>

        </div> 
    </div><!--/row-->

</div><!--/span-->



