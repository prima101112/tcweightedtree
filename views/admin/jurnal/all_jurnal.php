
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
                       <? echo anchor("jurnal/all_jurnal_per_page", 'View All Jurnal', 'class="btn btn-primary"'); ?>
                       <? echo anchor("jurnal/add_jurnal", 'Add Jurnal', 'class="btn btn-primary"'); ?>
                    </p>
                </div><!--/span-->
            </div><!--/row-->
            <hr>
            <div class="row-fluid">
                <div class="span7">
                    <h2>Table jurnal Admin</h2></div>
                <div class="span5">
                     <?php //echo form_open('jurnal/search',array('class'=>'form-search')); ?>
<!--                    <div class="input-append">
                        <input type="text" name="keyword" class="span12 search-query">
                        <button type="submit" class="btn">Search</button>
                    </div>
                     </form>-->
                </div>
                <div class="span9"><?php echo $this->session->flashdata('pesan_flash'); ?><br></div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <th>#</th>
                    <th>id_jurnal</th>
                    <th>judul</th>
                    <th>penulis</th>
                    <th>abstrak</th>
                    <th>tree</th>
                   
                    </thead>
                    <tbody>
                        <?php
                        $no = $no = $this->uri->segment(3) + 1;
                        if (isset($data_jurnal)) {
                            foreach ($data_jurnal->result() as $val):
                                $judul_jurnal = $val->judul_jurnal;
                                $penulis_jurnal = $val->penulis_jurnal;
                                $abstrak_jurnal = $val->abstrak_jurnal;
                                $tree_jurnal = unserialize($val->tree_jurnal);
                                
                                $id_jurnal = $val->id_jurnal;
                                
                                
                                ?>
                                <tr>
                                    <td><? echo $no; ?></td>
                                    <td><? echo $id_jurnal; ?></td>
                                    <td><? echo $judul_jurnal; ?></td>
                                    <td><? echo $penulis_jurnal; ?></td>
                                    <td><? echo $abstrak_jurnal; ?></td>
                                    <td><? print_r($tree_jurnal); ?></td>
                                    
                                    <td>
                                        <? //echo anchor("#", '<i class="icon-edit"></i> Edit', 'class="btn btn-small"'); ?>
                                         <? echo anchor("jurnal/delete_jurnal/$id_jurnal", '<i class="icon-trash"></i> Delete', array('class' => 'btn btn-small delete', 'title' => "jurnal")); ?>

                                       
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

