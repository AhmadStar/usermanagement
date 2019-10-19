<?php

$id = '';
$title = '';
$comment = '';
$priorityId = '';
$statusId = '';


if(!empty($taskInfo))
{
    foreach ($taskInfo as $uf)
    {
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
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Task Information</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <h4 class=""><span >Task Title :</span><?php echo $title; ?></h4>
                <h4 class=""><span >Task Description :</span><?php echo $comment; ?></h4>
                <h4 class=""><span >Employee Name :</span><?php
                    if(isset($user_list[$employee_id]))
                        echo $user_list[$employee_id];
                
                ?></h4>
                <h4 class=""><span >Task Proiotity :</span>
                    <?php 
                    foreach ($tasks_prioritys as $rl)
                    { 
                        if($rl->priorityId == $priorityId)                                    
                            echo $rl->priority;                                
                    }
                    ?>
                </h4>
                <h4 class=""><span >Task Status :</span>
                    <?php 
                    foreach ($tasks_situations as $rl)
                    { 
                        if($rl->statusId == $statusId)                                    
                            echo $rl->status;                                
                    }
                    ?>
                </h4>
                </div>                        
        </div>
    </div>
</section>
</div>