<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Group Tasks
      <small>Group Tasks</small>
    </h1>
  </section>
  <section class="content">
    <div class="col-xs-12">

    <?php          
      if($role !== ROLE_EMPLOYEE)
      {
    ?>
      <div class="text-right form-group">
        <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewTask">
          <i class="fa fa-plus"></i> Add Task</a>
      </div>
      <?php }?>
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
                    <th>Task Title</th>
                    <th>Explanation</th>
                    <th>Availability</th>
                    <th>Priority</th>
                    <th>Created by</th>                    
                    <th>Creation Date</th>
                    <th>End Date</th>
                    <th>Show</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($group_tasks))
                      {
                          foreach($group_tasks as $record)
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
                        <?php echo $record->comment ?>
                      </td>
                      <td>
                        <div class="label label-<?php
                        if ($record->statusId == '1')
                        echo 'danger';
                        else if ($record->statusId == '2')
                        echo 'success';
                        ?>">
                          <?php echo $record->status ?>
                        </div>
                      </td>

                      <td>
                        <div class="label label-<?php
                        if ($record->priorityId == '1')
                        echo 'danger';
                        else if ($record->priorityId == '2')
                        echo 'warning';
                        else if ($record->priorityId == '3')
                        echo 'info'
                        ?>">
                          <?php echo $record->priority ?>
                        </div>
                      </td>
                      <td>
                        <?php echo $record->name ?>
                      </td>                     
                      <td>
                        <?php echo $record->createdDtm ?>
                      </td>
                      <td>
                        <?php echo $record->endDtm ?>
                      </td>
                      <td class="text-center">
                        <a class="btn btn-sm btn-info showtask" href="<?php echo base_url().'showTask/'.$record->id; ?>" data-userid="<?php echo $record->id; ?>"
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