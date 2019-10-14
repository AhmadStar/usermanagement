<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Management panel
    </h1>
  </section>

  <section class="content">
    <div class="row">
    <?php
    if($role == ROLE_EMPLOYEE)
    {
    ?>
     <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>
              <?php if(isset($mytasksCount)) { echo $mytasksCount; } else { echo '0'; } ?>
            </h3>
            <p>My Tasks</p>
          </div>
          <div class="icon">
            <i class="fa fa-tasks"></i>
          </div>
          <a href="<?php echo base_url(); ?><?php  echo 'tasks' ?>" class="small-box-footer">See all
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>
              <?php if(isset($myfinishedTasksCount)) { echo $myfinishedTasksCount; } else { echo '0'; } ?>
            </h3>
            <p>My Finished Tasks</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?php echo base_url(); ?><?php  echo 'finishedtasks' ?>" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->     
      <?php
          }
      if($role != ROLE_EMPLOYEE)
      {
      ?>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>
              <?php if(isset($tasksCount)) { echo $tasksCount; } else { echo '0'; } ?>
            </h3>
            <p>All Tasks</p>
          </div>
          <div class="icon">
            <i class="fa fa-tasks"></i>
          </div>
          <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'tasks';}else{echo 'tasks';} ?>" class="small-box-footer">See all
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>
              <?php if(isset($finishedTasksCount)) { echo $finishedTasksCount; } else { echo '0'; } ?>
            </h3>
            <p>All Finished Tasks</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?php echo base_url(); ?><?php echo 'finishedtasks' ?>" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <?php          
      }
      ?>

    <?php
      if($role !== ROLE_ADMIN)
      {
      ?>
       <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon">
          <div class="inner">
            <h3>
              <?php
              if(isset($userStars)) {
                if($userStars == 0) echo $userStars;
                while($userStars > 0){?>
                     <i class="fa fa-star" style="color:yellow"></i>                                             
                <?php  $userStars--;}
              }
              ?>
            </h3>
            <p>My Bonus</p>
          </div>
          <div class="icon">
            <i class="ion ion-ios-star-outline"></i>
          </div>
          <a href="<?php echo base_url(); ?><?php  echo 'userStars' ?>" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
      <?php
          }
      ?>

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>
              <?php if(isset($logsCount)) { echo $logsCount; } else { echo '0'; } ?>
            </h3>
            <p>Log</p>
          </div>
          <div class="icon">
            <i class="fa fa-archive"></i>
          </div>
          <a href="<?php echo base_url(); ?>log-history" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->

      <?php          
      if($role == ROLE_ADMIN)
      {
      ?>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>
              <?php if(isset($usersCount)) { echo $usersCount; } else { echo '0'; } ?>
            </h3>
            <p>User</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      
      <div class="col-md-6">
        <!-- USERS LIST -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Connected Users</h3>

            <div class="box-tools pull-right">
              <span class="label label-danger"><?php if(isset($connectedUsersCount)) { echo $connectedUsersCount; } else { echo '0'; } ?> Online</span>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <ul class="users-list clearfix">
            <?php foreach($connectedUsers as $user){?>
                <li>
                <a href="<?= base_url().'log-history/'.$user->userId; ?>"><img src="<?php echo $user->picture?>" alt="User Image"></a>
                <a class="users-list-name" href="<?= base_url().'log-history/'.$user->userId; ?>"><?php echo $user->name?></a>
                <span class="users-list-date"><?php echo $user->role?></span>
                <span class="users-list-date"><?php echo date('Y-m-d',strtotime($user->updatedDtm)); echo date('l',strtotime($user->updatedDtm));?></span>
              </li> 
              <?php }?>
            </ul>
            <!-- /.users-list -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">                  
            <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">View All Users
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!--/.box -->
      </div>      

      <?php
          }
      ?>
    <div class="col-md-6">
        <!-- Tasks LIST -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Recently Added Tasks</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              <?php foreach($latestTask as $task){?>
                <li class="item">
                <div class="product-img">
                  <img src="<?php echo $task->picture?>" alt="Product Image">
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title"><?php echo $task->title?>
                    <span class="pull-right label label-<?php
                        if ($task->priorityId == '1')
                        echo 'danger';
                        else if ($task->priorityId == '2')
                        echo 'warning';
                        else if ($task->priorityId == '3')
                        echo 'info'
                        ?>">
                          <?php echo $task->priority ?>
                      </span>
                    </a>
                  <span class="product-description">
                        <?php echo $task->comment?>
                      </span>
                </div>
              </li>
              <?php }?>
              <!-- /.item -->                
            </ul>
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="<?php echo base_url(); ?>tasks" class="small-box-footer">View All Tasks
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>     
  </div>
  </section>
</div>