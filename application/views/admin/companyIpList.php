<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> All IP
      <small>All IP</small>
    </h1>
  </section>
  <section class="content">
      <div class="row">
        <div class="col-xs-12 text-right">
          <div class="form-group">
            <a class="btn btn-primary addIp">
              <i class="fa fa-plus"></i> Add Ip</a>
          </div>
        </div>
      </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <div class="box-header">
              <h3 class="box-title">Ip List</h3>
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
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th>Ip</th>
                    <th>Brnach</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($ipRecords)) {
                    foreach ($ipRecords as $record) {
                      ?>
                      <tr>
                        <td>
                          <?php echo $record->ip ?>
                        </td>   
                        <td>
                          <?php echo $record->branch ?>
                        </td>                   
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger deleteIp" data-ipid="<?php echo $record->id; ?>" title="Delete">
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

<!-- Full Height Modal -->
<div class="modal fade" id="add_ip_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
    <div class="modal-dialog modal-full-height" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Add Ip</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $this->load->helper("form"); ?>
            <form role="form" id="addIp" method="post" role="form">
                <div class="modal-body" >
                    <div class="md-form">
                        <label for="ip-address" class="control-label">Ip Address:</label>
                        <input type="text" class="form-control" name="ipAddress"  id="ipAddress">
                    </div>
                    <div class="md-form">
                        <label for="branch-name" class="control-label">Branch Name:</label>
                        <input type="text" class="form-control" name="branchName"  id="branchName">
                    </div>
                </div>
            </form>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveIp" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Full Height Modal -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/addIpAddress.js" charset="utf-8"></script>