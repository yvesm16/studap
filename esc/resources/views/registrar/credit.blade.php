<!DOCTYPE html>
<html lang="en">
<head>
  <title>CICS e - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.min.css'); }}" rel="stylesheet">
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.css'); }}" rel="stylesheet">
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.js'); }}"></script>
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.min.js'); }}"></script>
</head>
<body>

@include('registrar.nav')

<div class="container indexMargin home">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><span id="titlePage">Course Crediting</span></h1>
              <button data-toggle="modal" data-target="#tc" id="add"type="button" class="btn btn-light">Guidelines</button><br>
            <div class="modal fade" id="tc" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Guidelines for Course Crediting</h4>
                  </div>
                  <p >
                    <ul style='text-align:left; margin-right:5%'>
                        <center>
                        <b><i>There are labels indicated for each provided button</i></b><br><br>
                        </center>
                        <b>For the Registrar:</b><br>
                        <li>The Pending View Details shows the pending course crediting request</li>
                        <li>The View Details button must be click to show the information of the course crediting request</li>
                        <li>View Document is clicked to show the attached files</li>
                        <li>The approve button places the sign of the Registrar</li>
                        <li>The okay button on the modal must be clicked to confirm the approval of the request</li>
                        <li>The decline button shows that the request is disapprove by the Registrar</li>
                        <li>The reason modal must be filled out if it is disapproved </li>
                        <li>The submit to Registrar button is clicked for the student to be notified that the request has been completed</li>
                        <br><br>
                        <b>In the Completed Tab:</b>
                        <li>Click Completed View Details to show the requests that has been approved by the CICS Registrar </li>
                        <li>Click View Details shows the details of the request </li>
                        <li>The download report button which generates a pdf version of the completed list</li>


                        

                        <br><br>
                    </ul>
                  </p>
                  
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  
                  </div>
                </div>
            
              </div>
            </div><br>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-6 col-md-6">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-question-sign" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ count($pending) }}</div>
                              <div>Pending</div>
                          </div>
                      </div>
                  </div>
                  <a href="{{ URL::to('registrar/crediting/2') }}" style="color: #8a6d3b">
                      <div class="panel-footer" style="background-color: white !important">
                          <span class="pull-right">
                            View Details
                            <span class="glyphicon glyphicon-chevron-right"></span>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
          </div>
          <div class="col-lg-6 col-md-6">
              <div class="panel panel-success">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-ok-circle" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ count($completed) }}</div>
                              <div>Completed</div>
                          </div>
                      </div>
                  </div>
                  <a href="{{ URL::to('registrar/crediting/completed') }}" style="color: #3c763d">
                      <div class="panel-footer" style="background-color: white !important">
                          <span class="pull-right">
                            View Details
                            <span class="glyphicon glyphicon-chevron-right"></span>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      <div class="row downloadCompletedListReportDiv" style="margin-bottom: 1%; text-align: right">
        <div class="col-lg-12" style="margin-bottom: 1%;">
          <button class="btn btn-warning"><span class="glyphicon glyphicon-cloud-download"></span></button> - Download Report
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="panel-body" style="overflow-x: scroll">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="courseCreditTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Course(s) Taken from other Program/College/University</th>
                            <th>Equivalent Course(s) in the New Program to be enrolled</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
            </div>
        </div>
      </div>
  </div>
</div>

</body>
</html>

<script>
  $(document).ready(function(){
    var BASE_URL = $("#hdnBaseUrl").val();
    var pathname = window.location.pathname;
    if(pathname.split('/')[3] == 'completed'){
      $('.downloadCompletedListReportDiv').css('display','block');
    }else{
      $('.downloadCompletedListReportDiv').css('display','none');
    }

    $(function() {
        $('#courseCreditTable').dataTable({
            "scrollCollapse": true,
            "sDom": '<"top"f>rt<"bottom"ip><"clear">',
            "bServerSide": true,
            "pagingType": "full_numbers",
            "iDisplayLength": 7,
            "sAjaxSource": BASE_URL+ "/ajax?type=courseCreditList&status=" + pathname.split('/')[3] + "&minimum_status=2",
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [1,2,3,4,5]
            }],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": "<", // This is the link to the previous page
                    "sNext": ">" // This is the link to the next page
                },
                "sSearch": "",
                "sSearchPlaceholder": "Search Records"
            }
        });
    });

    $('#courseCreditTable').delegate('.viewDetails','click', function (){
      window.location.href = BASE_URL + '/registrar/crediting/details/' + $(this).data('id');
    });

    $('.downloadCompletedListReportDiv').click(function(){
      window.location.href = BASE_URL + '/crediting/details/completed_pdf';
    });
  });
</script>
