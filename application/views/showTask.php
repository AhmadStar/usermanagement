<?php

$id = '';
$title = '';
$comment = '';
$priority = '';
$status = '';
$employee_id = '';
$groupName = '';
$createdBy = '';
$finish_detail = '';

if (!empty($taskInfo)) {
    foreach ($taskInfo as $uf) {
        $id = $uf->id;
        $title = $uf->title;
        $comment = $uf->comment;
        $priority = $uf->priority;
        $status = $uf->status;
        $employee_id = $uf->employee_id;
        $groupName = $uf->groupName;
        $createdBy = $uf->createdBy;
        $finish_detail = $uf->finish_detail;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Task Management
        </h1>

    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Task Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h4 class=""><span>Task Title :</span><?php echo $title; ?></h4>
                        <h4 class=""><span>Task Description :</span><?php echo $comment; ?></h4>
                        <h4 class=""><span>created By :</span>
                            <?php
                            if (isset($createdBy))
                                echo $createdBy;
                            ?>
                        </h4>
                        <h4 class=""><span>Group Name :</span>
                            <?php
                            if (isset($groupName))
                                echo $groupName;
                            else
                                echo 'Not for Group';
                            ?>
                        </h4>
                        <h4 class=""><span>Employee Name :</span>
                            <?php
                            if (isset($user_list[$employee_id]))
                                echo $user_list[$employee_id];
                            else
                                echo 'Not for Employee';

                            ?>
                        </h4>
                        <h4 class=""><span>Task Proiotity :</span>
                            <?php
                            echo $priority;
                            ?>
                        </h4>
                        <h4 class=""><span>Task Status :</span>
                            <?php
                            echo $status;
                            ?>
                        </h4>
                        <h4 class=""><span>Finish Details :</span>
                            <?php
                            if ($finish_detail) {
                                echo $finish_detail;
                            } else {
                                echo 'Not finished yet';
                            }
                            ?>
                        </h4>
                        <!-- Links section -->
                        <section id="links">
                            <div class="container-fluid">
                                <h2 class="section-title mb-2 h1">Task Links</h2>
                                <p class="text-center text-muted h5">Here we put all links related to current task.</p>
                                <div class="row mt-5">
                                    <?php foreach ($tasks_links as $key => $link) { ?>
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                            <div class="card">
                                                <div class="card-block block-1">
                                                    <h3 class="card-title">Link<? echo $key ?> </h3>
                                                    <p class="card-text"><?php echo $link->name; ?></p>
                                                    <a href="<?php echo $link->name; ?>" target="_blank" title="Open link" class="read-more">Open link<i class="fa fa-angle-double-right ml-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </section>
                        <!-- /Links section -->

                        <!-- files section -->
                        <section class="files padding-lg" style="<?php if(count($tasks_images) == 0) echo 'visibility: hidden' ?>">
                            <div class="container">
                                <div class="row heading heading-icon">
                                    <h2>Task Files</h2>
                                </div>
                                <ul class="row">
                                    <?php foreach ($tasks_images as $image) { ?>
                                        <li class="col-12 col-md-6 col-lg-3">
                                            <div class="cnt-block equal-hight" style="height: 349px;">
                                                <figure><img src="<?php echo base_url() . 'uploads/' . $image->name; ?>" class="img-responsive" alt=""></figure>
                                                <ul class="follow-us clearfix">
                                                    <li>
                                                        <a download="<?php echo $image->name ?>" href="<?php echo base_url() . 'uploads/' . $image->name; ?>" data-rel="lightbox" class="expand">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </section>
                        <!-- /files section -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>