<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>
    <?php echo $pageTitle; ?>
  </title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url() . "uploads/favicon.png"; ?>" />
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.4 -->
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- FontAwesome 4.3.0 -->
  <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons 2.0.0 -->
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <!-- Datatables style -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css" />
  <!-- Theme style -->
  <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
  <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />  
  <!-- datetimepicker  -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/bootstrap-datetimepicker.min.css"> 
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/bootstrap-datepicker.min.css"> 
  <!-- custom style file -->
  <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />  


  <!-- jQuery 3.4.1 -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/jQueryUI/jquery-ui-1.10.3.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
  </script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<?php
$picture = $this->user_model->get_picture($this->session->userdata('userId'));
$picture = $picture->picture;

if (($token = $this->input->cookie('site_theme'))) {
  $token = explode("\n", $token);
  $theme = $token[0];
}

if ($role === ROLE_EMPLOYEE) {
  $mytasksCount = $this->user_model->tasksCount($this->session->userdata('userId'));
  $tasks = $this->user_model->getTasks($this->session->userdata('userId'));
  $myfinishedTasksCount = $this->user_model->finishedTasksCount($this->session->userdata('userId'));
}

if ($role === ROLE_ADMIN || $role == ROLE_SLAES) {
  $tasks = $this->user_model->getBendingTasks();
  $AllTasksCount = $this->user_model->AllTasksCount();
  $BendingTasksCount = $this->user_model->BendingTasksCount();
  $tasksCount = $this->user_model->tasksCount();
  $finishedTasksCount = $this->user_model->finishedTasksCount();
}

if ($role === ROLE_CLIENT) {
  $ClientBendingTasksCount = $this->user_model->ClientTasksCount($this->session->userdata('userId'), 3);
  $tasks = $this->user_model->getClientTasks($this->session->userdata('userId'), 3);
  $ClientFinishedTasksCount = $this->user_model->ClientTasksCount($this->session->userdata('userId'), 2);
  $ClientOpenedTasksCount = $this->user_model->ClientTasksCount($this->session->userdata('userId'), 1);
}

$myBonus = $this->user_model->userStars($this->session->userdata('userId'));
$label = array('' , 'danger','warning','info');
?>

<body class="<?php echo $theme ?> sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?php echo base_url(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
          <b>DAS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          <b>DAS</b>Adminstration</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">          
            <li>
              <a id="my_location" href="#" target="_blank">
                <i class="fa fa-map-marker" id="location" location="<?php echo $_SERVER['REMOTE_ADDR'] ?>"></i>
              </a>
            </li>
            <li class="dropdown tasks-menu">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">
                <?php 
                  if ($role == ROLE_EMPLOYEE) echo $mytasksCount;
                  if ($role == ROLE_ADMIN || $role == ROLE_SLAES) echo $BendingTasksCount;
                  if ($role == ROLE_CLIENT ) echo $ClientBendingTasksCount;                                
                ?></span>
             </a>
             <ul class="dropdown-menu item-menu">
              <li class="header"><?php 
                  if ($role == ROLE_EMPLOYEE) echo 'You have '.$mytasksCount.' Tasks';
                  if ($role == ROLE_ADMIN || $role == ROLE_SLAES) echo 'We have '.$BendingTasksCount.' Bending Tasks';
                  if ($role == ROLE_CLIENT ) echo 'We have '.$ClientBendingTasksCount.' Bending Tasks';                            
                ?></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                <?php                 
                
                foreach ($tasks as $task) { ?>
                  <li class="task-item"><!-- Task item -->                                      
                  <div class="task-img">
                    <img src="<?php echo base_url().$task->picture ?>" alt="Product Image">
                  </div>
                  <div class="task-info">
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
                        $label1 = array('danger','success','info','warning','primary');
                      ?>
                    <small class="pull-right label label-<?php echo $label1[rand(0,4)]?>"> <i class="fa fa-clock-o"></i><?php echo $since?></small>
                    </a>                   
                  </div>
                  </li>
                <?php } ?>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                  <?php if ($role == ROLE_EMPLOYEE){?>
                    <a href="<?php echo base_url() . 'tasks' ?>">view my tasks</a>
                  <?php }if ($role == ROLE_ADMIN || $role == ROLE_SLAES){?>
                    <a href="<?php echo base_url() . 'Bendingtasks' ?>">view bending tasks</a>
                  <?php }if ($role == ROLE_CLIENT ){?>
                    <a href="<?php echo base_url() . 'clientBendingTasks' ?>">view bending tasks</a>
                  <?php }?>
              </li>
             </ul>
            </li>
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-history"></i>
              </a>
              <ul class="dropdown-menu">
                <li class="header"> Last Login :
                  <i class="fa fa-clock-o"></i>
                  <?= empty($last_login) ? "First Login" : $last_login; ?>
                </li>
              </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url() . $picture; ?>" class="user-image" alt="User Image" />
                <span class="hidden-xs">
                  <?php echo $name; ?>
                </span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?php echo base_url() . $picture; ?>" class="img-circle" alt="User Image" />
                  <p>
                    <?php echo $name; ?>
                    <small>
                      <?php echo $role_text; ?>
                    </small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <div class="col-xs-6 text-center">
                      <a href="<?php echo base_url(); ?>general">
                        <i class="fa fa-cog"></i>
                        <span>Theme</span>
                      </a>
                    </div>
                    <div class="col-xs-6 text-center">
                        <a href="<?php echo base_url(); ?>profile">
                          <i class="fa fa-user"></i>
                          <span>Profile</span>
                        </a>
                    </div>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo base_url(); ?>updateUser" class="btn btn-default btn-flat">
                      <i class="fa fa-key"></i> Account settings </a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">
                      <i class="fa fa-sign-out"></i> Logout</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo base_url() . $picture; ?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $name; ?></p>
            <a href="<?php echo base_url(); ?>updateUser"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">
            <span>MAIN NAVIGATION</span>
            </i>
          </li>
          <li class="treeview">
            <a href="<?php echo base_url(); ?>dashboard">
              <i class="fa fa-dashboard"></i>
              <span>Home page</span>
              </i>
            </a>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-pie-chart"></i>
              <span>Tasks</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php
              // Rol definetion in application/config/constants.php
              if ($role == ROLE_ADMIN || $role == ROLE_SLAES) {
                ?>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>Bendingtasks">
                    <i class="fa fa-clock-o"></i>
                    <span>Bending Tasks</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-yellow">
                        <?php if (isset($BendingTasksCount)) {
                            echo $BendingTasksCount;
                          } else {
                            echo '011';
                          } ?>
                      </small>
                    </span>
                  </a>
                </li>

                <li class="treeview">
                  <a href="<?php echo base_url(); ?>tasks">
                    <i class="fa fa-tasks"></i>
                    <span>Tasks</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-red">
                        <?php if (isset($tasksCount)) {
                            echo $tasksCount;
                          } else {
                            echo '0';
                          } ?>
                      </small>
                    </span>
                  </a>
                </li>

                <li class="treeview">
                  <a href="<?php echo base_url(); ?>finishedtasks">
                    <i class="fa fa-tasks"></i>
                    <span>Finished Tasks</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-green">
                        <?php if (isset($finishedTasksCount)) {
                            echo $finishedTasksCount;
                          } else {
                            echo '0';
                          } ?>
                      </small>
                    </span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>addNewTask">
                    <i class="fa fa-plus-circle"></i>
                    <span>Add Task</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-green">new</small>
                    </span>
                  </a>
                </li>
              <?php
              }
              if ($role == ROLE_EMPLOYEE) {
                ?>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>tasks">
                    <i class="fa fa-tasks"></i>
                    <span>Tasks</span>
                    <small class="label pull-right bg-green">
                      <?php if (isset($mytasksCount)) {
                          echo $mytasksCount;
                        } else {
                          echo '0';
                        } ?>
                    </small>
                  </a>
                </li>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>finishedtasks">
                    <i class="fa fa-tasks"></i>
                    <span>Finished Tasks</span>
                    <small class="label pull-right bg-red">
                      <?php if (isset($myfinishedTasksCount)) {
                          echo $myfinishedTasksCount;
                        } else {
                          echo '0';
                        } ?>
                    </small>
                  </a>
                </li>
              <?php
              }
              if ($role == ROLE_CLIENT) {
                ?>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>clientBendingTasks">
                    <i class="fa fa-clock-o"></i>
                    <span>Bending Tasks</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-yellow">
                        <?php if (isset($ClientBendingTasksCount)) {
                            echo $ClientBendingTasksCount;
                          } else {
                            echo '011';
                          } ?>
                      </small>
                    </span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>clientOpenedTasks">
                    <i class="fa fa-tasks"></i>
                    <span>Opened Tasks</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-red">
                        <?php if (isset($ClientOpenedTasksCount)) {
                            echo $ClientOpenedTasksCount;
                          } else {
                            echo '011';
                          } ?>
                      </small>
                    </span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>clientFinishedTasks">
                    <i class="fa fa-tasks"></i>
                    <span>Finished Tasks</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-green">
                        <?php if (isset($ClientFinishedTasksCount)) {
                            echo $ClientFinishedTasksCount;
                          } else {
                            echo '011';
                          } ?>
                      </small>
                    </span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>addNewTask">
                    <i class="fa fa-plus-circle"></i>
                    <span>Add Task</span>
                    <span class="pull-right-container">
                      <small class="label pull-right bg-green">new</small>
                    </span>
                  </a>
                </li>
              <?php
              }
              ?>

            </ul>
          </li>
          <?php
          if ($role === ROLE_EMPLOYEE || $role === ROLE_SLAES) {
            ?>
            <li class="treeview">
              <a href="<?php echo base_url(); ?>userStars">
                <i class="fa fa-star"></i>
                <span>My Bonus</span>
                <small class="label pull-right bg-yellow">
                  <?php if (isset($myBonus)) {
                      echo $myBonus;
                    } else {
                      echo '0';
                    } ?>
                </small>
              </a>
            </li>
          <?php
          }
          if ($role == ROLE_ADMIN) {
            ?>
            <li class="treeview">
              <a href="<?php echo base_url(); ?>userListing">
                <i class="fa fa-users"></i>
                <span>Users</span>
              </a>
            </li>

            <li class="treeview">
              <a href="<?php echo base_url(); ?>dailylogs">
                <i class="fa fa-archive"></i>
                <span>Today Log Records</span>
              </a>
            </li> 
            <?php
          }
          if ($role != ROLE_SLAES && $role != ROLE_CLIENT){
            ?>         

          <li class="treeview">
            <a href="<?php echo base_url(); ?>log-history">
              <i class="fa fa-archive"></i>
              <span>Log Records</span>
            </a>
          </li>

          <?php
          }
          if ($role == ROLE_ADMIN) {
            ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-sign-in"></i>
              <span>Manipulate Users Logs</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>addUserLog">
                    <i class="fa fa-plus-circle"></i>
                    <span>Add User Log</span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>maintainUsersLogs">
                    <i class="fa fa-archive"></i>
                    <span>Maintain Users logs</span>
                  </a>
                </li>              
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-gear"></i>
              <span>General Settings</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>log-history-upload">
                    <i class="fa fa-upload"></i>
                    <span>Log History Upload</span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="<?php echo base_url(); ?>log-history-backup">
                    <i class="fa fa-archive"></i>
                    <span>Log History Backup</span>
                  </a>
                </li>              
            </ul>
          </li>
          <?php
          } ?>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>