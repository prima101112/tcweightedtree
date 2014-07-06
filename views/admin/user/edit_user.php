<? if($this->session->userdata('jenis_user')>2 || $this->session->userdata('jenis_user') == NULL){
     redirect('user/index');
} ?>
<div class="container">

    <h1>Edit User Admin</h1>

     <?
        foreach($data_user->result() as $row):
            $username = $row->username;
            $id_user = $row->id_user;
        endforeach;
        ?>
    <div class="row-fluid">
        <?php echo form_open("user/edit_user_up/$id_user"); ?>
        <br>
        <div class="span12">
            <div class="span4"></div>
            <div class="span4"></div>
            <div class="span4">
                <p>
                       <? echo anchor("user/all_user_per_page", 'View All Admin', 'class="btn btn-primary"'); ?>
                       <? echo anchor("user/register_admin", 'Add User Admin', 'class="btn btn-primary"'); ?>
                    </p>
                
            </div>
        </div>
       
        <div class="span9">
            <?php echo $this->session->flashdata('pesan_flash'); ?>
            <div class="row-fluid">
                <div class="span4" style="padding: 4px; font-size: 16px;">Username <font color="red">*</font></div>
                <div class="span5"><?php echo form_input(array('name' => 'username', 'placeholder' => 'masukan username ', 'class' => 'input-xlarge','value'=>$username)); ?></div>
            </div>
            <div class="row-fluid">
                <div class="span4" style="padding: 4px; font-size: 16px;">Password <font color="red">*</font></div>
                <div class="span5"><?php echo form_password(array('name' => 'password', 'placeholder' => 'masukan password', 'class' => 'input-xlarge')); ?></div>
            </div>
            <div class="row-fluid">
                <div class="span4" style="padding: 4px; font-size: 16px;">Ulang Password <font color="red">*</font></div>
                <div class="span5"><?php echo form_password(array('name' => 'password2', 'placeholder' => 'ulangi password', 'class' => 'input-xlarge')); ?></div>
            </div>
            <hr>


           
            <div class="row-fluid">
                <div class="span5" style="padding: 4px; font-size: 12px;"></div>
                <div class="span4"><br><?php echo form_submit('submit', 'submit', 'class="btn btn-large btn-primary"'); ?></div>
            </div>

        </div>
        <? echo form_close(); ?>
    </div><!--/row-->

</div> 