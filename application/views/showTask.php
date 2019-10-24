<?php

$id = '';
$title = '';
$comment = '';
$priorityId = '';
$statusId = '';


if (!empty($taskInfo)) {
    foreach ($taskInfo as $uf) {
        $id = $uf->id;
        $title = $uf->title;
        $comment = $uf->comment;
        $priorityId = $uf->priorityId;
        $statusId = $uf->statusId;
        $employee_id = $uf->employee_id;
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
                        <h4 class=""><span>Employee Name :</span><?php
                                                                    if (isset($user_list[$employee_id]))
                                                                        echo $user_list[$employee_id];

                                                                    ?></h4>
                        <h4 class=""><span>Task Proiotity :</span>
                            <?php
                            foreach ($tasks_prioritys as $rl) {
                                if ($rl->priorityId == $priorityId)
                                    echo $rl->priority;
                            }
                            ?>
                        </h4>
                        <h4 class=""><span>Task Status :</span>
                            <?php
                            foreach ($tasks_situations as $rl) {
                                if ($rl->statusId == $statusId)
                                    echo $rl->status;
                            }
                            ?>
                        </h4>
                        <div class="row">
                            <div class="col-md-12">

                                <div id="mdb-lightbox-ui"></div>

                                <div class="mdb-lightbox">
                                    <h2>Task Links</h2>
                                    <?php foreach ($tasks_links as $link) { ?>
                                        <div class="col-md-4">
                                             <a href="<?php echo $link->name;?>" target="_blank"><?php echo $link->name;?></a>
                                        </div>
                                    <?php } ?>

                                </div>

                            </div>
                        </div>                        
                        <div class="content-section" id="portfolio">
                            <div class="container">
                                <div class="row">
                                    <div class="heading-section col-md-12 text-center">
                                        <h2>Task Images</h2>
                                    </div> <!-- /.heading-section -->
                                </div> <!-- /.row -->
                                <div class="row">
                                <?php foreach ($tasks_images as $image) { ?>
                                    <div class="portfolio-item col-md-3 col-sm-6">
                                        <div class="portfolio-thumb">
                                            <img src="<?php echo base_url() . 'uploads/' . $image->name; ?>" alt="">
                                            <div class="portfolio-overlay">                                                
                                                <a download="<?php echo $image->name?>" href="<?php echo base_url() . 'uploads/' . $image->name; ?>" data-rel="lightbox" class="expand">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </div> <!-- /.portfolio-overlay -->
                                        </div> <!-- /.portfolio-thumb -->
                                    </div> <!-- /.portfolio-item -->
                                    <?php } ?>
                                </div> <!-- /.row -->
                            </div> <!-- /.container -->
                        </div> <!-- /#portfolio -->
                    </div>
                </div>
            </div>
    </section>
</div>