<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Management panel
    </h1>
  </section>

  <section class="content">
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
                <strong>Goal Completion</strong>
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
                      style="width:<?php if (isset($tasksCount)) {
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
                      style="width:<?php if (isset($myfinishedTasksCount)) {
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
                      style="width:<?php if (isset($AllTasksCount)) {
                          $perecent = (($myAllTasksCount) / ($AllTasksCount)) * 100;
                            echo $perecent;
                            echo "%";
                          } else {
                            echo '0';
                          } ?>"></div>
                    </div>
                  </div>
              <?php }else {?>
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
                    style="width:<?php if (isset($tasksCount)) {
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
                      style="width:<?php if (isset($finishedTasksCount)) {
                          $perecent = (($finishedTasksCount) / ($AllTasksCount)) * 100;
                            echo $perecent;
                            echo "%";
                          } else {
                            echo '0';
                          } ?>"></div>
                    </div>
                  </div>              
              <?php }
                if ($role !== ROLE_ADMIN) {
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
                      style="width:<?php if (isset($myWorkHours)) {
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
                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
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
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                <h5 class="description-header">$10,390.90</h5>
                <span class="description-text">TOTAL COST</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                <h5 class="description-header">$24,813.53</h5>
                <span class="description-text">TOTAL PROFIT</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block">
                <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                <h5 class="description-header">1200</h5>
                <span class="description-text">GOAL COMPLETIONS</span>
              </div>
              <!-- /.description-block -->
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="row">
      <?php
      if ($role == ROLE_EMPLOYEE) {
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
      }else {
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
          foreach($groups as $group){                      
            ?>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
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
      if ($role !== ROLE_ADMIN) {
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

          <!-- Browse Usage -->
          <div class="box box-default">
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
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="#">United States of America
                    <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
                <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a>
                </li>
                <li><a href="#">China
                    <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
              </ul>
            </div>
            <!-- /.footer -->
          </div>

          <!--/.box -->
        </div>

      <?php
      }
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
              <?php foreach ($latestTask as $task) { ?>
                <li class="item">
                  <div class="product-img">
                    <img src="<?php echo $task->picture ?>" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"><?php echo $task->title ?>
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

        <!-- calander box -->
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
          <div class="box-body no-padding">
            <!--The calendar -->
            <div id="calendar" style="width: 100%">
              <div class="datepicker datepicker-inline" style="width: 100%">
                <div class="datepicker-days" style="">
                  <table class="table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <th colspan="7" class="datepicker-title" style="display: none;"></th>
                      </tr>
                      <tr>
                        <th class="prev">«</th>
                        <th colspan="5" class="datepicker-switch">October 2019</th>
                        <th class="next">»</th>
                      </tr>
                      <tr>
                        <th class="dow">Su</th>
                        <th class="dow">Mo</th>
                        <th class="dow">Tu</th>
                        <th class="dow">We</th>
                        <th class="dow">Th</th>
                        <th class="dow">Fr</th>
                        <th class="dow">Sa</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="old day" data-date="1569715200000">29</td>
                        <td class="old day" data-date="1569801600000">30</td>
                        <td class="day" data-date="1569888000000">1</td>
                        <td class="day" data-date="1569974400000">2</td>
                        <td class="day" data-date="1570060800000">3</td>
                        <td class="day" data-date="1570147200000">4</td>
                        <td class="day" data-date="1570233600000">5</td>
                      </tr>
                      <tr>
                        <td class="day" data-date="1570320000000">6</td>
                        <td class="day" data-date="1570406400000">7</td>
                        <td class="day" data-date="1570492800000">8</td>
                        <td class="day" data-date="1570579200000">9</td>
                        <td class="day" data-date="1570665600000">10</td>
                        <td class="day" data-date="1570752000000">11</td>
                        <td class="day" data-date="1570838400000">12</td>
                      </tr>
                      <tr>
                        <td class="day" data-date="1570924800000">13</td>
                        <td class="day" data-date="1571011200000">14</td>
                        <td class="day" data-date="1571097600000">15</td>
                        <td class="day" data-date="1571184000000">16</td>
                        <td class="day" data-date="1571270400000">17</td>
                        <td class="day" data-date="1571356800000">18</td>
                        <td class="day" data-date="1571443200000">19</td>
                      </tr>
                      <tr>
                        <td class="day" data-date="1571529600000">20</td>
                        <td class="day" data-date="1571616000000">21</td>
                        <td class="day" data-date="1571702400000">22</td>
                        <td class="day" data-date="1571788800000">23</td>
                        <td class="day" data-date="1571875200000">24</td>
                        <td class="day" data-date="1571961600000">25</td>
                        <td class="day" data-date="1572048000000">26</td>
                      </tr>
                      <tr>
                        <td class="day" data-date="1572134400000">27</td>
                        <td class="day" data-date="1572220800000">28</td>
                        <td class="day" data-date="1572307200000">29</td>
                        <td class="day" data-date="1572393600000">30</td>
                        <td class="day" data-date="1572480000000">31</td>
                        <td class="new day" data-date="1572566400000">1</td>
                        <td class="new day" data-date="1572652800000">2</td>
                      </tr>
                      <tr>
                        <td class="new day" data-date="1572739200000">3</td>
                        <td class="new day" data-date="1572825600000">4</td>
                        <td class="new day" data-date="1572912000000">5</td>
                        <td class="new day" data-date="1572998400000">6</td>
                        <td class="new day" data-date="1573084800000">7</td>
                        <td class="new day" data-date="1573171200000">8</td>
                        <td class="new day" data-date="1573257600000">9</td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="7" class="today" style="display: none;">Today</th>
                      </tr>
                      <tr>
                        <th colspan="7" class="clear" style="display: none;">Clear</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="datepicker-months" style="display: none;">
                  <table class="table-condensed">
                    <thead>
                      <tr>
                        <th colspan="7" class="datepicker-title" style="display: none;"></th>
                      </tr>
                      <tr>
                        <th class="prev">«</th>
                        <th colspan="5" class="datepicker-switch">2019</th>
                        <th class="next">»</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month">Jul</span><span class="month">Aug</span><span class="month">Sep</span><span class="month focused">Oct</span><span class="month">Nov</span><span class="month">Dec</span></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="7" class="today" style="display: none;">Today</th>
                      </tr>
                      <tr>
                        <th colspan="7" class="clear" style="display: none;">Clear</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="datepicker-years" style="display: none;">
                  <table class="table-condensed">
                    <thead>
                      <tr>
                        <th colspan="7" class="datepicker-title" style="display: none;"></th>
                      </tr>
                      <tr>
                        <th class="prev">«</th>
                        <th colspan="5" class="datepicker-switch">2010-2019</th>
                        <th class="next">»</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="7"><span class="year old">2009</span><span class="year">2010</span><span class="year">2011</span><span class="year">2012</span><span class="year">2013</span><span class="year">2014</span><span class="year">2015</span><span class="year">2016</span><span class="year">2017</span><span class="year">2018</span><span class="year focused">2019</span><span class="year new">2020</span></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="7" class="today" style="display: none;">Today</th>
                      </tr>
                      <tr>
                        <th colspan="7" class="clear" style="display: none;">Clear</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="datepicker-decades" style="display: none;">
                  <table class="table-condensed">
                    <thead>
                      <tr>
                        <th colspan="7" class="datepicker-title" style="display: none;"></th>
                      </tr>
                      <tr>
                        <th class="prev">«</th>
                        <th colspan="5" class="datepicker-switch">2000-2090</th>
                        <th class="next">»</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="7"><span class="decade old">1990</span><span class="decade">2000</span><span class="decade focused">2010</span><span class="decade">2020</span><span class="decade">2030</span><span class="decade">2040</span><span class="decade">2050</span><span class="decade">2060</span><span class="decade">2070</span><span class="decade">2080</span><span class="decade">2090</span><span class="decade new">2100</span></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="7" class="today" style="display: none;">Today</th>
                      </tr>
                      <tr>
                        <th colspan="7" class="clear" style="display: none;">Clear</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="datepicker-centuries" style="display: none;">
                  <table class="table-condensed">
                    <thead>
                      <tr>
                        <th colspan="7" class="datepicker-title" style="display: none;"></th>
                      </tr>
                      <tr>
                        <th class="prev">«</th>
                        <th colspan="5" class="datepicker-switch">2000-2900</th>
                        <th class="next">»</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="7"><span class="century old">1900</span><span class="century focused">2000</span><span class="century">2100</span><span class="century">2200</span><span class="century">2300</span><span class="century">2400</span><span class="century">2500</span><span class="century">2600</span><span class="century">2700</span><span class="century">2800</span><span class="century">2900</span><span class="century new">3000</span></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="7" class="today" style="display: none;">Today</th>
                      </tr>
                      <tr>
                        <th colspan="7" class="clear" style="display: none;">Clear</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
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