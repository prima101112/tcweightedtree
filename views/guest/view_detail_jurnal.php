

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
           <? foreach ($jurnal_detail->result() as $row): ?>
           <h2><? echo $row->judul_jurnal; ?></h2>
           <p style="color: #006dcc;"><? echo $row->penulis_jurnal; ?> | <? echo $row->tahun_jurnal; ?></p>
           <p><? echo $row->abstrak_jurnal; ?></p>
           <p><a class="btn" href="#">Download &raquo;</a></p>
              <? endforeach; ?>
       </div><!--/span-->
    </div><!--/row-->

</div><!--/span-->



