<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Log History
            <small>Users' Log History</small>
        </h1>
    </section>
    <section class="content">
    <div class="">
    <!--  Sales Chart -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $userInfo->name . " : " . $userInfo->email ?> Work Hours Report</h3>

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
            <div class="col-md-12">
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
                <canvas userChart="<?php echo $userInfo->userId ?>" id="userChart" style="height: 180px; width: 1029px;" height="180" width="1029"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>            
          </div>
        </div>
      </div>
    </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <?= $userInfo->name . " : " . $userInfo->email ?>
                        </h3>
                        <div class="box-tools">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <?php
                        $this->load->helper('form');
                        $error = $this->session->flashdata('error');
                        if ($error) {
                            ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php } ?>
                        <?php
                        $success = $this->session->flashdata('success');
                        if ($success) {
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php } ?>
                        <div class="panel-body">
                            <table width="100%" class=" cards table table-striped table-bordered table-hover" id="dataTables-single">
                                <thead class="cards-head">
                                    <tr>
                                        <th>User Id </th>
                                        <th>User Name</th>
                                        <th>Date and Time</th>
                                        <th>Day</th>
                                        <th>Day work Hours</th>
                                    </tr>
                                </thead>
                                <tbody class="logs-hover">
                                    <?php
                                    if (!empty($userRecords)) {
                                        foreach ($userRecords as $record) {
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
                                                    <?php echo date('l', strtotime($record->createdDtm)); ?>
                                                </td>
                                                <td>
                                                    <label>work Hours:</label>
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
<div class="modal fade" id="day_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

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
                    <ul id="populate" class="log-populate"></ul>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
            </div>
        </div>
    </div>
</div>
<!-- Full Height Modal -->


<script>
    $(document).ready(function() {
        $('#dataTables-single').DataTable({
            //Dom Gösterim şekli B-> buttonlar l-> lengthMenu f-> filtre vs.
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-9'i><'col-sm-3'B>>" +
                "<'row'<'col-sm-7 col-centered'p>>",
            lengthMenu: [
                [10, 15, 25, 50, -1],
                [10, 15, 25, 50, "All"]
            ],

            //lang
            language: {
                select: {
                    rows: "%d row selected."
                },

                url: "http://cdn.datatables.net/plug-ins/1.10.12/i18n/English.json"
            },
            buttons: [{
                    extend: "print",
                    text: "Print",
                    exportOptions: {
                        orthogonal: 'export',
                        columns: ':visible'
                    },
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: "Excel",
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: "PDF",
                }
            ],
            "order": [],
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                },
            ],
            "pageLength": 50,
            responsive: true
        });
    });
</script>

<script>
    // fetch logs of day.
    $('#dataTables-single tbody').on('click', 'tr', function() {
        var table = $('#dataTables-single').DataTable();
        var row_data = table.row(this).data()
        var mydata = {
            id: row_data[0],
            name: row_data[1],
            date: row_data[2],
        }

        console.log(mydata)

        var day_hours = 0;

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('logs') ?>",
            dataType: "json",
            data: mydata,
            success: function(data) {
                var items = [];
                day_hours = data[1];
                $.each(data[0], function(id, page) {
                    var li = $("<li>");
                    li.addClass("col-md-12");
                    var par1 = $("<p>");
                    par1.addClass("col-md-5");
                    par1.text(page['createdDtm']);
                    var par2 = $("<p>");
                    par2.text(page['process']);
                    par2.addClass("col-md-5");
                    var i = $("<i>");                        
                    i.addClass("fa fa-trash-o deleteLogDay");
                    li.append(par1);
                    li.append(par2);
                    li.append(i);
                    li.attr("id" , page['id']);
                    items.push(li);
                });
                $("#populate").html(items);
                $("#day_detail_modal").on("shown.bs.modal", function() {
                    $("#logs_user_name").text(row_data[1]);
                    $("#logs_date").text(row_data[3]);
                    $("#day_hours").text(data[1]);
                }).modal('show');
            },
        });
    });

    jQuery(document).on("click", ".deleteLogDay", function(){
		  var logid = $(this).parent().attr("id"),		
      currentRow = $(this);            
		
		var confirmation = confirm("Are you sure to delete this log ?");
		
    hitURL = baseURL + "deleteLogRecord";
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { logid : logid } 
			}).done(function(data){
        console.log(data);
				currentRow.parents('li').remove();
				if(data.status = true) { alert("log record successfully deleted"); }
				else if(data.status = false) { alert("Bonus deletion failed"); }				
			}).fail(function(data){
        alert("Access denied..!");
			});
		}
    });
    
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/userChart.js" charset="utf-8"></script>