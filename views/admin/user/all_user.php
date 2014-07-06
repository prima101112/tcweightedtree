<? if($this->session->userdata('jenis_user')>2 || $this->session->userdata('jenis_user') == NULL){
     redirect('user/index');
} ?>
<div class="container-fluid">
    <div class="row-fluid">

        <div class="span12">
            <div class="row-fluid">
                <div class="span4">
                    
                </div><!--/span-->
                <div class="span5">
                   
                </div><!--/span-->
                <div class="span3">
                   <p>
                       <? echo anchor("user/all_user_per_page", 'View All Admin', 'class="btn btn-primary"'); ?>
                       <? echo anchor("user/register_admin", 'Add User Admin', 'class="btn btn-primary"'); ?>
                    </p>
                </div><!--/span-->
            </div><!--/row-->
            <hr>
            <div class="row-fluid">
                <div class="span7">
                    <h2>Table User Admin</h2></div>
                <div class="span5">
                     <?php echo form_open('user/search',array('class'=>'form-search')); ?>
                    <div class="input-append">
                        <input type="text" name="keyword" class="span12 search-query">
                        <button type="submit" class="btn">Search</button>
                    </div>
                     </form>
                </div>
                <div class="span9"><?php echo $this->session->flashdata('pesan_flash'); ?><br></div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <th>#</th>
                    <th>id_user</th>
                    <th>username</th>
                    <th>jenis</th>
                    <th>aksi</th>
                   
                    </thead>
                    <tbody>
                        <?php
                        $no = $no = $this->uri->segment(3) + 1;
                        if (isset($data_user)) {
                            foreach ($data_user->result() as $val):
                                $username = $val->username;
                                $id_user = $val->id_user;
                                $jenis = $val->nama_jenis;
                                
                                ?>
                                <tr>
                                    <td><? echo $no; ?></td>
                                    <td><? echo $id_user; ?></td>
                                    <td><? echo $username; ?></td>
                                    <td><? echo $jenis; ?></td>
                                    
                                    <td>
                                        <? echo anchor("user/edit_user/$id_user", '<i class="icon-edit"></i> Edit', 'class="btn btn-small"'); ?>
                                         <? echo anchor("user/delete_user/$id_user", '<i class="icon-trash"></i> Delete', array('class' => 'btn btn-small delete', 'title' => "User")); ?>

                                       
                                    </td>
                                </tr>

                                <?
                                $no++;

                            endforeach;
                        }
                        ?>
                        <tr><td colspan="5"><? echo $pagination; ?></td></tr>
                    </tbody></table>
            </div><!--/row-->

        </div><!--/span-->
    </div><!--/row-->


</div><!--/.fluid-container-->

