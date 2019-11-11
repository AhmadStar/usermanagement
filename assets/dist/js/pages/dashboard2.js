'use strict';
$(function () {

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */


  $.getJSON('https://ipapi.co/'+$( "#location" ).attr("location")+'/json', function(data){      
      $( "#location" ).text( data.city+' '+data.country)        
      $( "#my_location" ).attr("href", "https://maps.google.com/?q="+data.latitude+","+data.longitude+"")
  });

// Make the dashboard widgets sortable Using jquery UI
$('.connectedSortable').sortable({
  containment         : $('section.content'),
  placeholder         : 'sort-highlight',
  connectWith         : '.connectedSortable',
  handle              : '.box-header, .nav-tabs',
  forcePlaceholderSize: true,
  zIndex              : 999999
});
$('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

// jQuery UI sortable for the todo list
$('.todo-list').sortable({
  placeholder         : 'sort-highlight',
  handle              : '.handle',
  forcePlaceholderSize: true,
  zIndex              : 999999
});

  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------

  if($("#salesChart").length==1){
  // // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);


  var salesChartData = {
    labels: [],
    datasets: [
      {
        label: "Digital Goods",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: []
      }
    ]
  };
  var labels = [];
  var values = [];
  var hitURL = baseURL + "getMonthHours";    
  $.ajax({
    async: false,
    url: hitURL,
    type: 'GET',      
    dataType: 'json',
    success: function(data) {
      $.each( data, function( key, var1 ){
        labels.push(key+1);
        values.push(var1);
      });
    }
  });

  // function fetchChartData() {
  //   return new Promise((resolve, reject) => {
  //     $.ajax({
  //       url: hitURL,
  //       type: 'GET',
  //       dataType: 'json',        
  //       success: function(data) {
  //         resolve(data)
  //       },
  //       error: function(error) {
  //         reject(error)
  //       },
  //     })
  //   })
  // }

  // fetchChartData()
  // .then(data => {
  //     $.each( data, function( key, var1 ){
  //       labels.push(key+1);
  //       values.push(var1);
  //     });      
  // })
  // .catch(error => {
  //   console.log(error)
  // })  

  salesChartData.labels = labels;
  salesChartData.datasets[0].data = values;
  console.log(salesChartData.labels);
  console.log(salesChartData.datasets[0].data);
  
  
  

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

}

  //---------------------------
  //- END MONTHLY SALES CHART -
  //---------------------------

  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
    if($("#pieChart").length==1){
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);

    var PieData = [
      {
        value: 0,
        color: "#f56954",
        highlight: "#f56954",
        label: "Chrome"
      },
      {
        value: 0,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "IE"
      },
      {
        value: 0,
        color: "#f39c12",
        highlight: "#f39c12",
        label: "Firefox"
      },
      {
        value: 0,
        color: "#00c0ef",
        highlight: "#00c0ef",
        label: "Safari"
      },
      {
        value: 0,
        color: "#3c8dbc",
        highlight: "#3c8dbc",
        label: "Opera"
      },
      {
        value: 0,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "Navigator"
      }
    ];

    var hitURL = baseURL + "getBrowseData";   
    var result ; 
      $.ajax({
        async: false,
        url: hitURL,
        type: 'GET',      
        dataType: 'json',
        success: function(data) {
          $.each( data, function( key2, var2 ){
            $.each( PieData, function( key1, var1 ){
              if(var1.label === var2.userAgent){
                var1.value = parseInt(var2.count);
              }
            });
          });  
        }
      });

  // function fetchBrowseData() {
  //   return new Promise((resolve, reject) => {
  //     $.ajax({
  //       url: hitURL,
  //       type: 'GET',
  //       dataType: 'json',        
  //       success: function(data) {
  //         resolve(data)
  //       },
  //       error: function(error) {
  //         reject(error)
  //       },
  //     })
  //   })
  // }

  // fetchBrowseData()
  // .then(data => {
  //       $.each( data, function( key2, var2 ){
  //         $.each( PieData, function( key1, var1 ){
  //           if(var1.label === var2.userAgent){
  //             var1.value = parseInt(var2.count);
  //           }
  //         });
  //       });     
  // })
  // .catch(error => {
  //   console.log(error)
  // })

  // console.log(PieData)                                  
    
  var pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
    //String - A tooltip template
    tooltipTemplate: "<%=value %> <%=label%> users"
  };
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.  
  pieChart.Doughnut(PieData, pieOptions);
  //-----------------
  //- END PIE CHART -
  //-----------------
}

  /* SPARKLINE CHARTS
   * ----------------
   * Create a inline charts with spark line
   */

  //-----------------
  //- SPARKLINE BAR -
  //-----------------
  $('.sparkbar').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type: 'bar',
      height: $this.data('height') ? $this.data('height') : '30',
      barColor: $this.data('color')
    });
  });

  //-----------------
  //- SPARKLINE PIE -
  //-----------------
  $('.sparkpie').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type: 'pie',
      height: $this.data('height') ? $this.data('height') : '90',
      sliceColors: $this.data('color')
    });
  });

  //------------------
  //- SPARKLINE LINE -
  //------------------
  $('.sparkline').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type: 'line',
      height: $this.data('height') ? $this.data('height') : '90',
      width: '100%',
      lineColor: $this.data('linecolor'),
      fillColor: $this.data('fillcolor'),
      spotColor: $this.data('spotcolor')
    });
  });

  //The Calender
  // $("#calendar").datepicker({
  //   "setDate": new Date(),
  //       "autoclose": true
  // });

  $('#calendar').datepicker({
        format:'mm/dd/yyyy',
    }).datepicker("setDate",'now');

});