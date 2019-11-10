<?php
$id = '';
$title = '';
$comment = '';
$priorityId = '';
$statusId = '';
$group_id = '';

if (!empty($taskInfo)) {
    foreach ($taskInfo as $uf) {
        $id = $uf->id;
        $title = $uf->title;
        $comment = $uf->comment;
        $priorityId = $uf->priorityId;
        $statusId = $uf->statusId;
        $employee_id = $uf->employee_id;
        $group_id = $uf->group_id;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Task Management
            <small>Add Task / Edit</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter task information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editTask" action="<?php echo base_url() ?>editTask" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fname">Task Title</label>
                                        <input type="hidden" name="taskId" id="taskId" value="<?php echo $id; ?>">
                                        <input type="text" class="form-control required" value="<?php echo $title; ?>" id="fname" name="fname">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Priority</label>
                                        <select class="form-control required" id="priority" name="priority">
                                            <option value="0">Select priority</option>
                                            <?php
                                            if (!empty($tasks_prioritys)) {
                                                foreach ($tasks_prioritys as $rl) {
                                                    ?>
                                                    <option value="<?php echo $rl->priorityId ?>" <?php if ($rl->priorityId == $priorityId) {
                                                                                                                echo "selected=selected";
                                                                                                            } ?>>
                                                        <?php echo $rl->priority ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="employeename">Employee</label>
                                        <?php echo form_dropdown('employee_id', $employee_list, set_value('employee_id', $employee_id), "employee_id='name' class='form-control'"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Group</label>
                                        <select class="form-control required" id="group" name="group">
                                            <option value="0">Select Group</option>
                                            <?php
                                            if (!empty($groups)) {
                                                foreach ($groups as $gr) {
                                                    ?>
                                                    <option value="<?php echo $gr->id ?>"
                                                        <?php if ($gr->id == $group_id) {
                                                            echo "selected=selected";
                                                        } ?>
                                                    >
                                                        <?php echo $gr->name ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type='file' name='files[]' multiple >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <ul class="list-unstyled clearfix">
                                            <?php foreach ($tasks_images as $image) { ?>
                                                <li id="<?php echo $image->id ?>" style="float:left; width: 33.33333%; padding: 5px;">
                                                    <a href="#" class="remove_picture" style="float: none" title="Remove the selected picture">&times;</a>
                                                    <div class="thumbnail" style="width: 120px; height: 140px;">
                                                        <img src="<?php echo base_url().$image->name; ?>" />
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="repeater">
                                    <div class="col-md-12">
                                        <div class="repeater-heading" align="right">
                                            <button type="button" class="btn btn-primary repeater-add-btn">Add More Links</button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    
                                    <div class="items" data-group="links" >
                                        <div class="item-content">
                                            <div class="form-group">                                                
                                                <div class="col-md-9">
                                                    <label>Enter link </label>
                                                    <input type="text" class="form-control" value="">
                                                </div>
                                                <div class="col-md-3" style="margin-top:24px;" align="center">
                                                    <button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Remove</button>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php foreach ($tasks_links as $key => $link) { ?>                                        
                                        <div class="items<?php echo $link->id?>">
                                            <div class="item-content">
                                                <div class="form-group">                                                
                                                    <div class="col-md-9">
                                                        <label>Enter link </label>                                                    
                                                            <input type="text" class="form-control" value="<?php echo $link->name?>" name="linksOld[<?php echo $link->id?>]">                                                    
                                                    </div>
                                                    <div class="col-md-3" style="margin-top:24px;" align="center">
                                                        <button id="remove-btn" onclick="$(this).parents('.items<?php echo $link->id?>').remove()" class="btn btn-danger">Remove</button>
                                                    </div>                                                
                                                </div>
                                            </div>                                        
                                        </div>
                                        <?php } ?>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comment">Task Description</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="4">
                                                <?php echo $comment; ?>
                                            </textarea>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control required" id="status" name="status">
                                            <option value="0">Select Status</option>
                                            <?php
                                            if (!empty($tasks_situations)) {
                                                foreach ($tasks_situations as $rl) {
                                                    ?>
                                                    <option value="<?php echo $rl->statusId ?>" <?php if ($rl->statusId == $statusId) {
                                                                                                            echo "selected=selected";
                                                                                                        } ?>>
                                                        <?php echo $rl->status ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                    <input type="reset" class="btn btn-default" value="Reset" />
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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

                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function(){
        $('#repeater').createRepeater();    
    });    
</script>
<script src="<?php echo base_url(); ?>assets/js/editTask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/repeater.js" type="text/javascript"></script>