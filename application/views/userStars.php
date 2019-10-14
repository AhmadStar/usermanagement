<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> All Usesr Bonus
      <small>All User bonus</small>
    </h1>
  </section>
  <section class="content">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
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
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>date</th>                    
                    <th>Show</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($bonusRecords))
                      {
                          foreach($bonusRecords as $record)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $record->id ?>
                      </td>
                      <td>
                        <?php echo $record->title ?>
                      </td>
                      <td>
                        <?php echo $record->description ?>
                      </td>
                      <td>
                        <?php echo $record->date ?>
                      </td>
                      <td class="text-center">
                        <a class="btn btn-sm btn-info showtask" href="<?php echo base_url().'showBonus/'.$record->id; ?>" data-userid="<?php echo $record->id; ?>"
                          title="Show">
                          <i class="fa fa-eye"></i>
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