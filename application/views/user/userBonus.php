<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Log History
            <small>Users' Log History</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <?= $userInfo->name." : ".$userInfo->email ?>
                        </h3>
                        <div class="box-tools">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                            <?php } ?>
                            <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                            <?php } ?>
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <th>Tile</th>
                                        <th>Desc</th>
                                        <th>Date and Time</th>
                                        <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                      if(!empty($userRecords))
                      {
                          foreach($userRecords as $record)
                          {
                      ?>
                    <tr>
                        <td>
                          <?php echo $record->title ?>
                        </td>
                        <td>
                          <?php echo $record->description ?>
                        </td>                
                        <td>
                          <?php echo date('j', strtotime($record->date)).' '.date('M', strtotime($record->date)).' , '.date('Y', strtotime($record->date));?>
                        </td>
                        <td class="text-center">                        
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editBonus/'.$record->id; ?>" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            |
                            <a class="btn btn-sm btn-danger" id="deleteBonus" href="#" data-bonusid="<?php echo $record->id; ?>" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>                            
                        </td>
                      </tr>
                        <?php
                        }
                      }
                      ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>