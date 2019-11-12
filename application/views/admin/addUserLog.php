<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> User Management
            <small>Add User Log</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Log information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUserLog" action="<?php echo base_url() ?>addUserLog" method="post" role="form">
                        <div class="box-body">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">User</label>
                                        <?php echo form_dropdown('user_id',$users,'',"user_id='name' class='form-control'");?>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Date and Time</label>    
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' onkeydown="return false" name="createdDtm" id="createdDtm" class="form-control" autocomplete="off"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>                                        
                                    <script type="text/javascript">
                                        $(function () {
                                            $('#datetimepicker').datetimepicker({});
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="process">process</label>
                                        <select name="process" class="form-control">
                                            <option value="">Choose a process</option>
                                            <option value="Logout">logout</option>
                                            <option value="Login">login</option>
                                        </select>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                    <div class="row">
                            <div class="col-md-12">
                                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                            </div>
                        </div>
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
                </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/addUserLog.js" type="text/javascript"></script>