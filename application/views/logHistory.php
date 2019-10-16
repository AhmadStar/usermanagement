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
            <h3 class="box-title"> log table size:
              <?php
                  if(isset($dbinfo->total_size))
                  {
                    echo $dbinfo->total_size;
                  }
                  else
                  {
                    echo '0';
                  }                  
                  ?>
                MB</h3>
                <h3 id='total'></h3>
            
            <?php if($role == ROLE_ADMIN){ ?>
            <div class="pull-right">
              <a class="btn btn-danger" href="<?php echo base_url(); ?>backupLogTable">Backup and Delete</a>
            </div>
            <?php }?>
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
                          <div class="col-md-3">                        
                              <?php echo form_dropdown('userName',$employee_list,'',"id='userName' class='form-control'");?>
                          </div>
                          <div class="col-md-3">
                              <input type="text" data-date-format="dd" autocomplete="off" name="day" id="day" class="form-control" placeholder="day" title='day' required />
                          </div> 
                          <div class="col-md-3">
                              <input type="text" data-date-format="mm" autocomplete="off" name="month" id="month" class="form-control" placeholder="month" title='month' required />
                          </div> 
                          <div class="col-md-3">
                              <input type="text" data-date-format="yyyy" autocomplete="off" name="year" id="year" class="form-control" placeholder="year" title='year' required />
                          </div>                  
                      </div>                                                           
                      <div class="form-group">
                          <div class="col-sm-12">
                              <button type="button" id="btn-filter" class="btn btn-primary">filter</button>
                              <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                          </div>
                      </div>
                  </form>
              </div>
              <table id="employee_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr>                    
                      <th>id</th>                      
                      <th>user name</th>
                      <th>user id </th>
                      <th>date</th>
                      <th>day</th>
                      <th>Total</th>
                  </tr>
              </thead>
              <tbody>
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
    table = $('#employee_list_table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "searchable": true,
        "searching": true,
        "bPaginate": true,
        "bSort" : true,
        "bInfo" : true,

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('employee_list')?>",
            "type": "POST",
            "data": function ( data ) {                
                data.day = $('#day').datepicker({ dateFormat: 'dd' , viewMode: "days", minViewMode: "days" }).val();
                data.month = $('#month').datepicker({ dateFormat: 'mm' , viewMode: "months", minViewMode: "months" }).val();                
                data.year = $('#year').datepicker({ dateFormat: 'yy' ,viewMode: "years", minViewMode: "years"}).val();
                data.userName = $("#userName  option:selected" ).text();
                data.userId = "<?php                                        
                    if($this->session->userdata('userId') === '1') echo '';
                    else echo $this->session->userdata('userId')                    
                    ?>";
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
 // fetch logs of day.
 $('#employee_list_table tbody').on( 'click', 'tr', function () {
            var row_data = table.row( this ).data()
            var mydata  = {
                name: row_data[1] ,                
                id: row_data[2],
                date: row_data[3] ,                
            }
            var day_hours = 0;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('logs')?>",
                dataType: "json",
                data: mydata,
                success: function(data){                    
                    var items = [];                    
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
                    $("#logs_date").text(row_data[4]);
                    $("#day_hours").text(data[1]);
                  }).modal('show');
                },
            });
    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
        loadTotal();        
    });

    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
    });

    function loadTotal(){
      var mydata  = {
          userName : $("#userName  option:selected" ).text(),
          month : $('#month').datepicker({ dateFormat: 'mm' , viewMode: "months", minViewMode: "months" }).val(),
          year : $('#year').datepicker({ dateFormat: 'yy' ,viewMode: "years", minViewMode: "years"}).val()               
            }            

            // console.log(mydata.month);

		$.ajax({
        url: '<?php echo site_url('total')?>',
        type: 'POST',
        data: mydata,
        dataType: 'json',
        success: function(data) {
            if(data === 'empty')
              $("#total").html('Please Select a user');
            else{              
              current_month = new Date().getMonth()+1;
              current_year = new Date().getFullYear();
              if(mydata.month != '')
                current_month = mydata.month;
              if(mydata.year != '')
                current_year = mydata.year;


              $("#total").html('Total work hours of '+ 
              $("#userName  option:selected" ).text() +'  '+data+' at '+current_month+' '+ current_year);                            
            }
        }
    });
  }
  
  });

</script>