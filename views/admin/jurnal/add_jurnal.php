<script type="text/javascript">
var counter = 1;
var limit = 5;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<input type='text' name='penulis[]' class='input-xlarge' placeholder='isikan penulis'>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}
</script>

<h1>Tambahkan Jurnal</h1>
<div class="row-fluid">
    <?php echo form_open_multipart('jurnal/add_jurnal_up'); ?>
    <br>

    <div class="span9">
        <?php echo $this->session->flashdata('pesan'); ?>
        <div class="row-fluid">
            <div class="span4" style="padding: 4px; font-size: 16px;">Judul <font color="red">*</font></div>
            <div class="span5"><?php echo form_input(array('name' => 'judul', 'placeholder' => 'masukan judul jurnal', 'class' => 'input-xlarge')); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4" style="padding: 4px; font-size: 16px;">Penulis <font color="red">*</font></div>
            <div class="span5" id="dynamicInput"><?php echo form_input(array('name' => 'penulis[]', 'placeholder' => 'isikan penulis', 'class' => 'input-xlarge')); ?></div>
            <input class="btn btn-info" type="button" value="Add another text input" onClick="addInput('dynamicInput');">
        </div>
        <div class="row-fluid">
            <div class="span4" style="padding: 4px; font-size: 16px;">Abstrak </div>
            <div class="span5"><?php echo form_textarea(array('name' => 'abstrak', 'placeholder' => 'abstrak', 'class' => 'input-xlarge')); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4" style="padding: 4px; font-size: 16px;">isi </div>
            <div class="span5"><?php echo form_textarea(array('name' => 'isi', 'placeholder' => 'isi', 'class' => 'input-xxlarge')); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4" style="padding: 4px; font-size: 16px;">Keyword <font color="red">*</font></div>
            <div class="span5"><?php echo form_input(array('name' => 'katakunci', 'placeholder' => 'masukan keyword', 'class' => 'input-xlarge')); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4" style="padding: 4px; font-size: 16px;">Tahun <font color="red">*</font></div>
            <div class="span5"><?php echo form_input(array('name' => 'tahun', 'placeholder' => 'Isikan tahun terbit jurnal', 'class' => 'input-xlarge')); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4" style="padding: 4px; font-size: 16px;">file <font color="red">*</font></div>
            <div class="span5"><?php echo form_upload(array('name' => 'file', 'class' => 'input-xlarge')); ?></div>
        </div>

       
        <hr>
        <div class="row-fluid">
            <div class="span5" style="padding: 4px; font-size: 12px;"><p>pastikan isian benar</p></div>
            <div class="span4"><br><?php echo form_submit('submit', 'submit', 'class="btn btn-large btn-primary"'); ?></div>
        </div>

    </div>
    <? echo form_close(); ?>
</div>