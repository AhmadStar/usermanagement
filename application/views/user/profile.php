<?php

    $id = '';
    $education = '';
    $location = '';
    $experience = '';
    $notes = '';
    $role = '';
    $picture = '';

    if (!empty($userData)) {
        foreach ($userData as $ud) {
            $id = $ud->id;
            $education = $ud->education;
            $location = $ud->location;
            $experience = $ud->experience;
            $notes = $ud->notes;
            $role = $ud->role;
            $picture = $ud->picture;
        }
    }
?>  
<div class="content-wrapper" style="min-height: 1136px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $picture; ?>" alt="User profile picture">

                        <h3 class="profile-username text-center"><?php echo $name ; ?></h3>

                        <p class="text-muted text-center"><?php echo $role ; ?></p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">About Me</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

                        <p class="text-muted">
                            <?php echo $education?>
                        </p>

                        <hr>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                        <p class="text-muted"><?php echo $location?></p>

                        <hr>

                        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                        <p>
                        <?php foreach ($user_skills as $key => $skill) {                             
                            $label = array('default','primary','success','info','warning','danger');
                        ?>
                            <span class="label label-<?php echo $label[rand(0 , 5)]?>"><?php echo $skill->text; ?></span>
                        <?php }?>
                        </p>

                        <hr>

                        <strong><i class="fa fa-history margin-r-5"></i> Experience</strong>

                        <p><?php echo $experience?>.</p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                        <p><?php echo $notes?>.</p>
                        
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">                        
                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
                        <div class="col-md-12">
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
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">                                                                              
                                <form role="form" id="editProfile" action="<?php echo base_url() ?>editProfile" method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="inputEducation" class="col-sm-2 control-label">Education</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="userId" id="userId" value="<?php echo $id; ?>">
                                            <input type="text" class="form-control" value="<?php echo $education; ?>" id="inputEducation" name="education" placeholder="Education">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputLocation" class="col-sm-2 control-label">Location</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $location; ?>" id="inputLocation" name="location" placeholder="Location">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="inputExperience" placeholder="Experience" name="experience">
                                                <?php echo $experience; ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNotes" class="col-sm-2 control-label">Notes</label>

                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="inputNotes" placeholder="Notes" name="notes">
                                                    <?php echo $notes; ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEducation" class="col-sm-2 control-label">Skills</label>
                                        <div class="col-sm-10" id="repeater">
                                            <div class="col-md-12">
                                                <div class="repeater-heading" align="right">
                                                    <button type="button" class="btn btn-primary repeater-add-btn">Add More Skills</button>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="items" data-group="skills">
                                                <div class="item-content">
                                                    <div class="form-group">
                                                        <div class="col-md-9">
                                                            <label>Enter your skill </label>
                                                            <input type="text" class="form-control" value="">
                                                        </div>
                                                        <div class="col-md-3" style="margin-top:24px;" align="center">
                                                            <button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php foreach ($user_skills as $key => $skill) { ?>
                                                <div class="items<?php echo $skill->id ?>">
                                                    <div class="item-content">
                                                        <div class="form-group">
                                                            <div class="col-md-9">
                                                                <label>Enter your skill </label>
                                                                <input type="text" class="form-control" value="<?php echo $skill->text ?>" name="oldSkills[<?php echo $skill->id ?>]">
                                                            </div>
                                                            <div class="col-md-3" style="margin-top:24px;" align="center">
                                                                <button id="remove-btn" onclick="$(this).parents('.items<?php echo $skill->id ?>').remove()" class="btn btn-danger">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>




<script>
    $(document).ready(function() {
        $('#repeater').createRepeater();
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/repeater.js" type="text/javascript"></script>