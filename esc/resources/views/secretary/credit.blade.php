<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
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

@include('secretary.nav')

<div class="container indexMargin home">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><span id="titlePage">Course Crediting</span></h1>
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
                  <a href="{{ URL::to('secretary/crediting/2') }}" style="color: #8a6d3b">
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
                  <a href="{{ URL::to('secretary/crediting/completed') }}" style="color: #3c763d">
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
                            <th>Email</th>
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
      window.location.href = BASE_URL + '/secretary/crediting/details/' + $(this).data('id');
    });

    $('.downloadCompletedListReportDiv').click(function(){
      window.location.href = BASE_URL + '/crediting/details/completed_pdf';
    });
  });
</script>
