<!DOCTYPE html>
<html lang="en">
<head>
  <title>CICS E - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
  <script src="{{ URL::asset('js/student/consultation.js'); }}"></script>
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.min.css'); }}" rel="stylesheet">
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.css'); }}" rel="stylesheet">
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.js'); }}"></script>
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.min.js'); }}"></script>
</head>
<body>

@include('student.nav')

<div class="container indexMargin">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header">Consultations</h1>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row">
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-question-sign" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ $pending }}</div>
                              <div>Pending</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-info">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-ok" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ $approved }}</div>
                              <div>Approved</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-danger">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-remove" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ $disapproved }}</div>
                              <div>Disapproved</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-6">
              <div class="panel panel-success">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-ok-circle" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ $completed }}</div>
                              <div>Completed</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="panel-body" style="overflow-x: scroll">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="consultationTable">
                        <thead>
                        <tr>
                            <th>Date Created</th>
                            <th>Appointment Date</th>
                            <th>Professor</th>
                            <th>Status</th>
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

@include('global.consultationModal')
