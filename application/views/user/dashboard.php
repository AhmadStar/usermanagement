<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Management panel
    </h1>
  </section>

  <section class="content">
  <?php
      if ($role != ROLE_SLAES && $role != ROLE_CLIENT){
  ?>
    <div class="">
    <!--  Sales Chart -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">
              <?php
                  if ($role !== ROLE_ADMIN)
                    echo $name;
                  else
                    echo 'Employees';
              ?>
               Work Hours Report</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-wrench"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </div>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
              <p class="text-center">
                <!-- <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong> -->
                <strong>Work Hours at
                  <?php
                  $now = new \DateTime('now');
                  echo $month = $now->format('F');
                  echo ' , ';
                  echo $year = $now->format('Y');
                  ?>
                </strong>
              </p>

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="salesChart" style="height: 180px; width: 1029px;" height="180" width="1029"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              <p class="text-center">
              <?php if ($role != ROLE_CLIENT){ ?>
                <strong>Goal Completion</strong>
              <?php } ?>
              </p>

              <?php
                  if ($role == ROLE_EMPLOYEE) {
              ?>
                  <div class="progress-group">
                    <span class="progress-text">My Tasks from all available Tasks</span>
                    <span class="progress-number">
                      <b>
                        <?php if (isset($mytasksCount)) {
                            echo $mytasksCount;
                          } else {
                            echo '0';
                          } ?>
                      </b>/
                      <?php if (isset($tasksCount)) {
                            echo $tasksCount;
                          } else {
                            echo '0';
                          } ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" 
                      style="width:<?php if (isset($tasksCount) && $tasksCount != 0) {
                          $perecent = (($mytasksCount) / ($tasksCount)) * 100;
                            echo $perecent;
                            echo "%";
                          } else {
                            echo '0';
                          } ?>"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">My Completed Tasks from all</span>
                    <span class="progress-number">
                      <b>
                        <?php if (isset($myfinishedTasksCount)) {
                            echo $myfinishedTasksCount;
                          } else {
                            echo '0';
                          } ?>
                      </b>/
                      <?php if (isset($finishedTasksCount)) {
                            echo $finishedTasksCount;
                          } else {
                            echo '0';
                          } ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" 
                      style="width:<?php if (isset($myfinishedTasksCount) && $myfinishedTasksCount != 0) {
                          $perecent = (($myfinishedTasksCount) / ($finishedTasksCount)) * 100;
                            echo $perecent;
                            echo "%";
                          } else {
                            echo '0';
                          } ?>"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">My Task from all tasks</span>
                    <span class="progress-number">
                      <b>
                        <?php if (isset($myAllTasksCount)) {
                            echo $myAllTasksCount;
                          } else {
                            echo '0';
                          } ?>
                      </b>/
                      <?php if (isset($AllTasksCount)) {
                            echo $AllTasksCount;
                          } else {
                            echo '0';
                          } ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" 
                      style="width:<?php if (isset($AllTasksCount) && $AllTasksCount != 0) {
                          $perecent = (($myAllTasksCount) / ($AllTasksCount)) * 100;
                            echo $perecent;
                            echo "%";
                          } else {
                            echo '0';
                          } ?>"></div>
                    </div>
                  </div>
              <?php }elseif ($role == ROLE_ADMIN || $role == ROLE_SLAES) {?>
                <div class="progress-group">
                    <span class="progress-text">Available Task from all</span>
                    <span class="progress-number">
                      <b>
                        <?php if (isset($tasksCount)) {
                            echo $tasksCount;
                          } else {
                            echo '0';
                          } ?>
                      </b>/
                      <?php if (isset($AllTasksCount)) {
                            echo $AllTasksCount;
                          } else {
                            echo '0';
                          } ?>
                    </span>

                  <div class="progress sm">
                    <div class="progress-bar progress-bar-aqua" 
                    style="width:<?php if (isset($tasksCount) && $tasksCount != 0) {
                        $perecent = (($tasksCount) / ($AllTasksCount)) * 100;
                          echo $perecent;
                          echo "%";
                        } else {
                          echo '0';
                        } ?>"></div>
                  </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Completed Task from all</span>
                    <span class="progress-number">
                      <b>
                        <?php if (isset($finishedTasksCount)) {
                            echo $finishedTasksCount;
                          } else {
                            echo '0';
                          } ?>
                      </b>/
                      <?php if (isset($AllTasksCount)) {
                            echo $AllTasksCount;
                          } else {
                            echo '0';
                          } ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" 
                      style="width:<?php if (isset($finishedTasksCount) && $AllTasksCount != 0 ) {
                          $perecent = (($finishedTasksCount) / ($AllTasksCount)) * 100;
                            echo $perecent;
                            echo "%";
                          } else {
                            echo '0';
                          } ?>"></div>
                    </div>
                  </div>              
              <?php }
                if ($role == ROLE_EMPLOYEE || $role == ROLE_SLAES) {
              ?>
              <!-- /.progress-group -->
              <div class="progress-group">
                <span class="progress-text">My Work Hours from all</span>
                <span class="progress-number">
                  <b>
                    <?php if (isset($myWorkHours)) {
                        $hours = floor($myWorkHours / 3600);
                        $minutes = floor(($myWorkHours / 60) % 60);
                        $seconds = $myWorkHours % 60;
                        echo $hours.':'.$minutes.':'.$seconds;
                      } else {
                        echo '0';
                      } ?>
                </b>/<?php if (isset($AllUserWorkHours)) {
                        $hours = floor($AllUserWorkHours / 3600);
                        $minutes = floor(($AllUserWorkHours / 60) % 60);
                        $seconds = $AllUserWorkHours % 60;
                        echo $hours.':'.$minutes.':'.$seconds;
                      } else {
                        echo '0';
                      } ?>
                </span>

                <div class="progress sm">
                  <div class="progress-bar progress-bar-yellow" 
                      style="width:<?php if (isset($myWorkHours) && $AllUserWorkHours != 0) {
                          $perecent = (($myWorkHours) / ($AllUserWorkHours)) * 100;
                            echo $perecent;
                            echo "%";
                          } else {
                            echo '0';
                          } ?>"></div>
                </div>
              </div>
              <!-- /.progress-group -->
              <?php }?>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i></span>
                <h5 class="description-header"><?php
                if ($role !== ROLE_ADMIN) {
                  $hours = floor($myWorkHours / 3600);
                  $minutes = floor(($myWorkHours / 60) % 60);
                  $seconds = $myWorkHours % 60;
                  echo $hours.':'.$minutes.':'.$seconds;
                }else{
                  $hours = floor($AllUserWorkHours / 3600);
                  $minutes = floor(($AllUserWorkHours / 60) % 60);
                  $seconds = $AllUserWorkHours % 60;
                  echo $hours.':'.$minutes.':'.$seconds;
                }
                ?></h5>
                <span class="description-text">TOTAL WORK HOURS</span>
              </div>
              <!-- /.description-block -->
            </div>           
          </div>
        </div>
      </div>
    </div>
    <?php
       }
    ?>


    <div class="row">
    <?php
      if ($role == ROLE_CLIENT) {
        ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                <?php if (isset($ClientBendingTasksCount)) {
                    echo $ClientBendingTasksCount;
                  } else {
                    echo '0';
                  } ?>
              </h3>
              <p>Bending Tasks</p>
            </div>
            <div class="icon">
              <i class="fa fa-clock-o"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php echo 'clientBendingTasks' ?>" class="small-box-footer">See all
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>
                <?php if (isset($ClientOpenedTasksCount)) {
                    echo $ClientOpenedTasksCount;
                  } else {
                    echo '0';
                  } ?>
              </h3>
              <p>Opened Tasks</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php echo 'clientOpenedTasks' ?>" class="small-box-footer">See all
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
                <?php if (isset($ClientFinishedTasksCount)) {
                    echo $ClientFinishedTasksCount;
                  } else {
                    echo '0';
                  } ?>
              </h3>
              <p>Finished Tasks</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php echo 'clientFinishedTasks' ?>" class="small-box-footer">See all
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      <?php
      }
        elseif ($role == ROLE_EMPLOYEE) {
        ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                <?php if (isset($mytasksCount)) {
                    echo $mytasksCount;
                  } else {
                    echo '0';
                  } ?>
              </h3>
              <p>My Tasks</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php echo 'tasks' ?>" class="small-box-footer">See all
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
                <?php if (isset($myfinishedTasksCount)) {
                    echo $myfinishedTasksCount;
                  } else {
                    echo '0';
                  } ?>
              </h3>
              <p>My Finished Tasks</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php echo 'finishedtasks' ?>" class="small-box-footer">More information
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
            <h3><?php echo $this->user_model->groupTaskCount($group);?></h3>
              <p><?php echo $groupName?>Tasks</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php echo 'groupTasks/'.$group ?>" class="small-box-footer">More information
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      <?php
      }elseif ($role == ROLE_ADMIN || $role == ROLE_SLAES){
        ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>
                <?php if (isset($tasksCount)) {
                    echo $tasksCount;
                  } else {
                    echo '0';
                  } ?>
              </h3>
              <p>All Tasks</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="<?php echo base_url();?><?php echo 'tasks';?>" class="small-box-footer">See all
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
                <?php if (isset($finishedTasksCount)) {
                    echo $finishedTasksCount;
                  } else {
                    echo '0';
                  } ?>
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
          $btn = array('silver','blue','navy','teal','green'
          ,'olive','lime','orange','red','fuchsia','maroon');
          foreach($groups as $group){            
            ?>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-<?php echo $btn[rand(0 , 10)]?>">
                <div class="inner">
                  <h3><?php echo $this->user_model->groupTaskCount($group->id);?></h3>
                  <p><?php echo $group->name?> Tasks</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?php echo base_url(); ?><?php echo 'groupTasks/'.$group->id ?>" class="small-box-footer">More information
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
      <?php
          }
        }
      if ($role == ROLE_SLAES || $role == ROLE_EMPLOYEE) {
        ?>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <h3>
                <?php
                  if (isset($userStars)) {
                    if ($userStars == 0) echo $userStars;
                    while ($userStars > 0) { ?>
                    <i class="fa fa-star" style="color:yellow"></i>
                <?php $userStars--;
                    }
                  }
                  ?>
              </h3>
              <p>My Bonus</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-star-outline"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php echo 'userStars' ?>" class="small-box-footer">More information
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      <?php
      }
      if ($role !== ROLE_CLIENT) {
      ?>

      <?php        
      if ($role !== ROLE_SLAES) {
      ?>
      <!-- ./col log history-->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>
              <?php if (isset($logsCount)) {
                echo $logsCount;
              } else {
                echo '0';
              } ?>
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
        }      
      ?>

      <?php      
      if ($role == ROLE_ADMIN) {
        ?>
        <!-- ./col User Count -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                <?php if (isset($usersCount)) {
                    echo $usersCount;
                  } else {
                    echo '0';
                  } ?>
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
        <!-- Connected User -->
        <div class="col-md-6">
          <!-- USERS LIST -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Connected Users</h3>

              <div class="box-tools pull-right">
                <span class="label label-danger"><?php if (isset($connectedUsersCount)) {
                                                      echo $connectedUsersCount;
                                                    } else {
                                                      echo '0';
                                                    } ?> Online</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                <?php foreach ($connectedUsers as $user) { ?>
                  <li>
                    <a href="<?= base_url() . 'log-history/' . $user->userId; ?>"><img src="<?php echo $user->picture ?>" alt="User Image"></a>
                    <a class="users-list-name" href="<?= base_url() . 'log-history/' . $user->userId; ?>"><?php echo $user->name ?></a>
                    <span class="users-list-date"><?php echo $user->role ?></span>
                    <span class="users-list-date"><?php echo date('Y-m-d', strtotime($user->last_login));
                                                      echo date('l', strtotime($user->last_login)); ?></span>
                  </li>
                <?php } ?>
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
      <?php }?>

      <?php      
      if ($role !== ROLE_CLIENT) {
      ?>
      <!--  Recently Added Tasks -->
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
              <?php foreach ($latestTask as $task) { 
                $label = array('No','danger','warning','info');
                ?>
                <li class="item">
                  <div class="product-img">
                    <img src="<?php echo $task->picture ?>" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="<?php echo base_url() . 'showTask/' . $task->id; ?>" class="product-title"><?php echo $task->title ?>
                      <span class="pull-right label label-<?php echo $label[$task->priorityId]?>">
                        <?php echo $task->priority ?>
                      </span>
                      <?php
                        $since = strtotime(date("H:i:s")) - strtotime($task->createdDtm);
                        $days = floor($since / 86400);
                        $hours = floor($since / 3600);
                        if($hours > 24 )
                            $hours = $hours % 24;
                        $minutes = floor(($since / 60) % 60);
                        $since = '';
                        if($days != 0)
                            $since .= $days.' days ';
                        else{
                        if($hours != 0) $since .=  $hours.':';
                        if($hours == 0)
                            $since .= $minutes.' mins ';
                        else $since .=  $minutes.' hours';
                        }
                        $label = array('danger','success','info','warning','primary');
                      ?>
                    <small class="pull-right label label-<?php echo $label[rand(0,4)]?>"> <i class="fa fa-clock-o"></i><?php echo $since?></small>
                    </a>
                    <span class="product-description">
                      <?php echo $task->comment ?>                      
                    </span>                    
                  </div>
                </li>
              <?php } ?>
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
        <?php      
      }
      ?>
      <?php
      }
      if ($role == ROLE_ADMIN) {
        ?>
        

         <!-- Browse Usage -->
         <div class="col-md-6">
          <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Browser Usage</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="chart-responsive">
                      <canvas id="pieChart" height="155" width="314" style="width: 314px; height: 155px;"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <ul class="chart-legend clearfix">
                      <li><i class="fa fa-circle-o text-red"></i> Chrome</li>
                      <li><i class="fa fa-circle-o text-green"></i> IE</li>
                      <li><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
                      <li><i class="fa fa-circle-o text-aqua"></i> Safari</li>
                      <li><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
                      <li><i class="fa fa-circle-o text-gray"></i> Navigator</li>
                    </ul>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
              <!-- /.footer -->
              </div>
            </div>
      <?php
      }
      ?>
        
      <!-- To do  -->
      <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">To Do List</h3>

              <div class="box-tools pull-right">
                <ul class="pagination pagination-sm inline" id="pagination_link">
                </ul>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
              <ul class="todo-list ui-sortable" id="pagination_data">
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <button type="button" class="btn btn-default pull-right addTodo"><i class="fa fa-plus"></i> Add item</button>
            </div>
          </div>      
     </div>
      
<!-- calander box -->
<div class="col-md-3">
  <div class="box box-solid bg-green-gradient">
    <div class="box-header ui-sortable-handle" style="cursor: move;">
      <i class="fa fa-calendar"></i>

      <h3 class="box-title">Calendar</h3>
      <!-- tools box -->
      <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
          <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bars"></i></button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li><a href="#">Add new event</a></li>
            <li><a href="#">Clear events</a></li>
            <li class="divider"></li>
            <li><a href="#">View calendar</a></li>
          </ul>
        </div>
        <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
        </button>
      </div>
      <!-- /. tools -->
    </div>          
    <!-- /.box-header -->
    <div id="calendar" style="width: 100%"></div>
    <!-- /.box-body -->
    <div class="box-footer text-black">
      <div class="row">
      </div>
      <!-- /.row -->
    </div>
  </div>
</div>
      
    </div>
  </section>
</div>

<!-- Full Height Modal -->
<div class="modal fade" id="edit_todo_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
    <div class="modal-dialog modal-full-height" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Edit Todo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="md-form">
                    <input type="hidden" class="form-control" id="todoid">
                </div>
                <div class="md-form">
                    <input type="text" class="form-control" id="todo-text">
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveTodo" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Full Height Modal -->


<!-- Full Height Modal -->
<div class="modal fade" id="add_todo_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
    <div class="modal-dialog modal-full-height" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Add Todo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="md-form">
                    <input type="text" class="form-control" id="add-todo-text" placeholder="add todo text">
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="addNewTodo" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Full Height Modal -->

<script>

$(document).ready(function(){
  load_data();  
  function load_data(page)  
  {  
        hitURL = baseURL + "todo";
        $.ajax({
            url: hitURL,  
            method:"POST",  
            data:{page:page},
            dataType: "json",
            success:function(data){
              // console.log(data)
              $('#pagination_data').html(data['todo_data']);
              $('#pagination_link').html(data['links']);
            }  
        })  
  }

  jQuery(document).on("click", "#pagination_link li a", function(){      
      load_data($(this).text());
  });

});

</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>