<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Log History
            <small>Users' Log History</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <?= $userInfo->name." : ".$userInfo->email ?>
                        </h3>
                        <div class="box-tools">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                            <?php } ?>
                            <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                            <?php } ?>
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <th>User Id </th>
                                        <th>User Name</th>
                                        <th>Date and Time</th>
                                        <th>Day</th>
                                        <th>Day work Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                      if(!empty($userRecords))
                      {
                          foreach($userRecords as $record)
                          {
                      ?>
                    <tr>
                        <td>
                          <?php echo $record->userId ?>
                        </td>
                        <td>
                          <?php echo $record->userName ?>
                        </td>                        
                        <td>
                          <?php echo $record->createdDtm ?>
                        </td>
                        <td>
                          <?php echo date('l', strtotime($record->createdDtm));?>
                        </td>
                        <td>
                        <?php echo $record->total ?>
                        </td>
                      </tr>
                                            <?php
                          }
                      }
                      ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>

<!-- Full Height Modal -->
<div class="modal fade" id="day_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

  <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
  <div class="modal-dialog modal-full-height" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">logs of <span id="logs_user_name"></span> at <span id="logs_date"></span> <span id="day_hours"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="day-detail">        
        <ul id="populate"></ul>
      </div>
      </div>
      <div class="modal-footer justify-content-center">
      </div>
    </div>
  </div>
</div>
<!-- Full Height Modal -->

<script>
 // fetch logs of day.
 $('#dataTables-example tbody').on( 'click', 'tr', function () {
            var table = $('#dataTables-example').DataTable();
            var row_data = table.row( this ).data()
            var mydata  = {
                id: row_data[0],
                name: row_data[1] ,                
                date: row_data[2] ,
            }

            var day_hours = 0;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('logs')?>",
                dataType: "json",
                data: mydata,
                success: function(data){                    
                    var items = [];
                    day_hours = data[1];
                    $.each(data[0], function (id, page){
                        var li = $("<li>");
                        li.addClass("col-md-12");
                        var par1 = $("<p>");
                        par1.addClass("col-md-6");
                        par1.text(page['createdDtm']);
                        var par2 = $("<p>");
                        par2.text(page['process']);
                        par2.addClass("col-md-6");
                        li.append(par1);
                        li.append(par2);
                        items.push(li);                        
                    });
                    $("#populate").html(items);
                    $("#day_detail_modal").on("shown.bs.modal", function () {
                    $("#logs_user_name").text(row_data[1]);
                    $("#logs_date").text(row_data[3]);
                    $("#day_hours").text(data[1]);
                }).modal('show');
                },
            });        
    });

</script>