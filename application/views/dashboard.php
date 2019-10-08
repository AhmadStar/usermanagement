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
          <a href="<?php echo base_url(); ?><?php  echo 'etasks' ?>" class="small-box-footer">See all
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
          <a href="<?php echo base_url(); ?><?php  echo 'efinishedtasks' ?>" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->

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
          <a href="<?php echo base_url(); ?><?php  echo '' ?>" class="small-box-footer">More information
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
          <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'tasks';}else{echo 'etasks';} ?>" class="small-box-footer">See all
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
          <a href="<?php echo base_url(); ?><?php echo 'finishedTasks' ?>" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <?php          
      }
      ?>
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
    </div>
  </section>
</div>