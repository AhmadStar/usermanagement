<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> User Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNew">
                        <i class="fa fa-plus"></i> Add User</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">User List</h3>
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
                        <?php }
                        $success = $this->session->flashdata('success');
                        if ($success) {
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php } ?>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover cards" id="dataTables-example">
                                <thead class="cards-head">
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Telephone number</th>
                                        <th>Month Stars</th>
                                        <th>Role</th>
                                        <th>Work Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($userRecords)) {
                                        foreach ($userRecords as $record) {
                                            ?>
                                            <tr>
                                                <td class="text-center user-picture">
                                                    <img src="<?php echo base_url() . $record->picture; ?>" class="img-circle user-image" alt="User Image">
                                                </td>
                                                <td>
                                                    <label>Name:</label>
                                                    <?php echo $record->name ?>
                                                </td>
                                                <td>
                                                    <label>Email:</label>
                                                    <?php echo $record->email ?>
                                                </td>
                                                <td>
                                                    <label>Telephone:</label>
                                                    <?php echo $record->mobile ?>
                                                </td>
                                                <td>
                                                    <label>Bonus:</label>


                                                    <?php
                                                        if (isset($userBonus[$record->userId])) {
                                                            while ($userBonus[$record->userId] > 0) {
                                                    ?>
                                                        <i class="fa fa-star" style="color:yellow"></i>
                                                    <?php $userBonus[$record->userId]--;
                                                            }
                                                        } else
                                                            echo '';
                                                    ?>
                                                </td>
                                                <td>
                                                    <label>Role:</label>
                                                    <?php echo $record->role ?>
                                                </td>
                                                <td>
                                                    <label>Work:</label>
                                                    <?php echo  $record->workType == 1 ? 'Office Work' : 'Remote' ?>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-sm btn-primary" href="<?= base_url() . 'log-history/' . $record->userId; ?>" title="Log History">
                                                        <i class="fa fa-history"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-warning" href="<?= base_url() . 'user-bonus/' . $record->userId; ?>" title="User Bonus">
                                                        <i class="fa fa-star"></i>
                                                    </a> |
                                                    <a class="btn btn-sm btn-info" href="<?php echo base_url() . 'editOld/' . $record->userId; ?>" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-success favourite_icon addbonus" href="#" data-userid="<?php echo $record->userId; ?>" data-name="<?php echo $record->name; ?>" title="Add Bonus">
                                                        <i class="fa fa-star"></i>
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
<div class="modal fade" id="add_bonus_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
    <div class="modal-dialog modal-full-height" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">ADD Bonus for <span id="bonus_user_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="md-form">
                    <input type="hidden" class="form-control" id="userId">
                </div>
                <div class="md-form">
                    <input type="text" class="form-control" id="bonus-title" placeholder="Bonus Title">
                </div>
                <div class="md-form">
                    <textarea type="text" id="bonus-desc" class="form-control md-textarea" placeholder="Description" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="savebonus" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Full Height Modal -->


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>