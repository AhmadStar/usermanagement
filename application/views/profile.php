<?php
    $id = '';
    $education = '';
    $location = '';
    $experience = '';
    $notes = '';

    if (!empty($userData)) {
        foreach ($userData as $ud) {
            $id = $ud->id;
            $education = $ud->education;
            $location = $ud->location;
            $experience = $ud->experience;
            $notes = $ud->notes;
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

                        <h3 class="profile-username text-center">Nina Mcintire</h3>

                        <p class="text-muted text-center">Software Engineer</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="pull-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="pull-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="pull-right">13,287</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
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
                        <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Activity</a></li>
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
                        <div class="tab-pane" id="activity">
                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                    <span class="username">
                                        <a href="#">Jonathan Burke Jr.</a>
                                        <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                                    </span>
                                    <span class="description">Shared publicly - 7:30 PM today</span>
                                </div>
                                <!-- /.user-block -->
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore the hate as they create awesome
                                    tools to help create filler text for everyone from bacon lovers
                                    to Charlie Sheen fans.
                                </p>
                                <ul class="list-inline">
                                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                    <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                    </li>
                                    <li class="pull-right">
                                        <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                            (5)</a></li>
                                </ul>

                                <input class="form-control input-sm" type="text" placeholder="Type a comment">
                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post clearfix">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                    <span class="username">
                                        <a href="#">Sarah Ross</a>
                                        <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                                    </span>
                                    <span class="description">Sent you a message - 3 days ago</span>
                                </div>
                                <!-- /.user-block -->
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore the hate as they create awesome
                                    tools to help create filler text for everyone from bacon lovers
                                    to Charlie Sheen fans.
                                </p>

                                <form class="form-horizontal">
                                    <div class="form-group margin-bottom-none">
                                        <div class="col-sm-9">
                                            <input class="form-control input-sm" placeholder="Response">
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                    <span class="username">
                                        <a href="#">Adam Jones</a>
                                        <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                                    </span>
                                    <span class="description">Posted 5 photos - 5 days ago</span>
                                </div>
                                <!-- /.user-block -->
                                <div class="row margin-bottom">
                                    <div class="col-sm-6">
                                        <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <img class="img-responsive" src="../../dist/img/photo2.png" alt="Photo">
                                                <br>
                                                <img class="img-responsive" src="../../dist/img/photo3.jpg" alt="Photo">
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-6">
                                                <img class="img-responsive" src="../../dist/img/photo4.jpg" alt="Photo">
                                                <br>
                                                <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <ul class="list-inline">
                                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                    <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                    </li>
                                    <li class="pull-right">
                                        <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                            (5)</a></li>
                                </ul>

                                <input class="form-control input-sm" type="text" placeholder="Type a comment">
                            </div>
                            <!-- /.post -->
                        </div>
                        <!-- /.tab-pane -->

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
                                                    <button type="button" class="btn btn-primary repeater-add-btn">Add More Links</button>
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