<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> All Tasks
      <small>All Tasks</small>
    </h1>
  </section>
  <section class="content">
      <div class="row">
        <div class="col-xs-12 text-right">
          <div class="form-group">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewTask">
              <i class="fa fa-plus"></i> Add Task</a>
          </div>
        </div>
      </div>    
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <div class="box-header">
              <h3 class="box-title">Tasks List</h3>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if ($error) {
              ?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php } ?>
            <?php
            $success = $this->session->flashdata('success');
            if ($success) {
              ?>
              <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
              </div>
            <?php } ?>
            <div class="panel-body">
              <table width="100%" class="cards table table-striped table-bordered table-hover" id="dataTables-example">
                <thead class="cards-head">
                  <tr>
                    <th>Title</th>
                    <th>Explanation</th>
                    <th>Availability</th>
                    <th>Priority</th>
                    <th>Created by</th>
                    <th>For Employee:</th>
                    <th>Creation Date</th>
                    <th>End Date</th>
                    <th>Edit / Delete / Show</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($taskRecords)) {
                    foreach ($taskRecords as $record) {
                      ?>
                      <tr>
                        <td>
                          <label>Title:</label>
                          <?php echo $record->title ?>
                        </td>
                        <td>
                          <label>Detail:</label>
                          <?php echo $record->comment ?>
                        </td>
                        <td>
                          <label>Status:</label>
                          <div class="label label-<?php
                                                      if ($record->statusId == '1')
                                                        echo 'danger';
                                                      else if ($record->statusId == '2')
                                                        echo 'success';
                                                        else if ($record->statusId == '3')
                                                        echo 'info';
                                                      ?>">
                            <?php echo $record->status ?>
                          </div>
                        </td>

                        <td>
                          <label>Prority:</label>
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
                          <label>Created By:</label>
                          <?php echo $record->name ?>
                        </td>
                        <td>
                          <label>Employee Name:</label>
                          <?php

                              $employee_name = '';
                              foreach ($user_list as $employee) {
                                if ($employee->userId == $record->employee_id)
                                  $employee_name = $employee->name;
                              }
                              echo $employee_name ?>
                        </td>
                        <td>
                          <label>Create Date:</label>
                          <?php echo $record->createdDtm ?>
                        </td>
                        <td>
                          <label>Finish Date:</label>
                          <?php echo $record->endDtm ?>
                        </td>
                        <td class="text-center">
                        <?php if ($record->statusId != 2) { ?>    
                          <a class="btn btn-sm btn-primary" href="<?php echo base_url() . 'editOldTask/' . $record->id; ?>" title="Edit">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn btn-sm btn-danger deleteTask" href="#" data-taskid="<?php echo $record->id; ?>" title="Delete">
                              <i class="fa fa-trash"></i>
                            </a>    
                        <?php } ?>                      
                          <a class="btn btn-sm btn-info showtask" href="<?php echo base_url() . 'showTask/' . $record->id; ?>" data-userid="<?php echo $record->id; ?>" title="Show">
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>