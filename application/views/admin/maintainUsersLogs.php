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
            <h3 class="box-title"></h3>
                <h3 id='total'></h3>                      
            <div class="pull-right">
              <a class="btn btn-primary" href="<?php echo base_url(); ?>addUserLog">Add User Log</a>
            </div>            
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
                  <form id="form-filter" class="form-horizontal filter-body">                    
                      <div class="form-group">
                          <div class="col-md-2">                        
                              <?php echo form_dropdown('userName',$user_list,'',"id='userName' class='form-control'");?>
                          </div>
                          <div class="col-md-2">
                              <input type="text" data-date-format="dd" autocomplete="off" name="day" id="day" class="form-control" placeholder="day" title='day' required />
                          </div> 
                          <div class="col-md-2">
                              <input type="text" data-date-format="mm" autocomplete="off" name="month" id="month" class="form-control" placeholder="month" title='month' required />
                          </div> 
                          <div class="col-md-2">
                              <input type="text" data-date-format="yyyy" autocomplete="off" name="year" id="year" class="form-control" placeholder="year" title='year' required />
                          </div>                      
                          <div class="col-sm-4">
                              <!-- <button type="button" id="btn-filter" class="btn btn-primary">filter</button> -->
                              <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                          </div>
                      </div>
                  </form>
              </div>
              <table id="users_logs_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr>                    
                      <th>id</th>                      
                      <th>user name</th>
                      <th>user id </th>
                      <th>process</th>
                      <th>date</th>
                      <th>day</th>
                      <th>actions</th>
                  </tr>
              </thead>
              <tbody class="logs-hover">
              </tbody>
          </table>
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
        <h4 class="modal-title w-100" id="myModalLabel">logs of <span id="logs_user_name"></span> at <span id="logs_date"></span> <span id="day_hours"></span> </h4>
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


var table;

$(document).ready(function() {

    //datatables
    table = $('#users_logs_table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "searchable": true,
        "searching": true,
        "bPaginate": true,
        "bSort" : false,
        "bInfo" : true,

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('usersLogs')?>",
            "type": "POST",
            "data": function ( data ) {                
                data.day = $('#day').datepicker({ dateFormat: 'dd' , viewMode: "days", minViewMode: "days" }).val();
                data.month = $('#month').datepicker({ dateFormat: 'mm' , viewMode: "months", minViewMode: "months" }).val();                
                data.year = $('#year').datepicker({ dateFormat: 'yy' ,viewMode: "years", minViewMode: "years"}).val();
                data.userId = $("#userName  option:selected" ).val();
            },
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ 2 ],
            "visible": false,
            "searchable": false            
        },
        ],

    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
        loadTotal();
    });    

    $("#day").datepicker().on("changeDate", function(e) {
        table.ajax.reload();  //just reload table
        loadTotal(); 
      });

    $("#month").datepicker().on("changeDate", function(e) {
      table.ajax.reload();  //just reload table
      loadTotal(); 
    });

    $("#year").datepicker().on("changeDate", function(e) {
      table.ajax.reload();  //just reload table
      loadTotal();
    });

    $( "select" )
      .change(function () {
        table.ajax.reload();  //just reload table
        loadTotal();
      });

    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
    });
    
  
  });


  jQuery(document).on("click", ".deleteLog", function(){
		var logid = $(this).data("logid");		

		currentRow = $(this);
    hitURL = baseURL + "deleteLogRecord";
    var confirmation = confirm("Are you sure to delete this Record ?");

    if(confirmation)
		{
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { logid : logid}
      }).done(function(data){
        if(data.status = true) {
          alert("successfully TODO deleted"); 
          currentRow.parents('tr').remove();
        }
        else if(data.status = false) { alert("Failed to delet"); }
        else { alert("Access denied..!"); }			
      });
    }
	});

</script>