<?php

$id = '';
$title = '';
$description = '';
$date = '';


if(!empty($bonusInfo))
{
    foreach ($bonusInfo as $uf)
    {
        $id = $uf->id;
        $title = $uf->title;
        $description = $uf->description;
        $date = $uf->date;
    }
}


?>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Bonus Detail
    </h1>
    
</section>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Bonus Information</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <h4 class=""><span >Title :</span><?php echo $title; ?></h4>
                    <h4 class=""><span >Description :</span><?php echo $description; ?></h4>
                    <h4 class=""><span >Date :</span><?php echo $date?></h4>
                </div>
        </div>
    </div>
</section>
</div>