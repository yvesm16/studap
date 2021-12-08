<!DOCTYPE html>
<html lang="en">
<head>
  <title>CICS e - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
  <link rel="stylesheet" href="{{ URL::asset('css/student/calendar/html.css'); }}">
  <link rel="stylesheet" href="{{ URL::asset('css/student/calendar/calendar.css'); }}">
  <script src="{{ URL::asset('js/student/calendar/html.js'); }}"></script>
  <script src="{{ URL::asset('js/student/calendar/calendar.js'); }}"></script>
  <script src="{{ URL::asset('js/director/appeal.js'); }}"></script>
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.min.css'); }}" rel="stylesheet">
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.css'); }}" rel="stylesheet">
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.js'); }}"></script>
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.min.js'); }}"></script>
</head>
<body>

@include('director.nav')

<div class="container indexMargin home">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><span id="titlePage">Student Appeal</span></h1>
              <button data-toggle="modal" data-target="#tc" id="add"type="button" class="btn btn-light">Guidelines</button><br>
            <div class="modal fade" id="tc" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Guidelines for Student Appeal on Course Grades</h4>
                  </div>
                  <p >
                    <ul style='text-align:left; margin-right:5%'>
                        <center>
                        <b><i>There are labels indicated for each provided button</i></b><br><br>
                        </center>
                        <b>For the Student Apeeal on Course Grades:</b><br>
                        <li>Pending View Details shows all the pending student appeal request</li>
                    	<li> View Button shows the status tracker of the request</li>
                    	<li>Evaluate Level 1 Button opens a modal that sets a conference with the student and an email will be sent for the details of the conference including the meeting link</li>
                        <li>Evaluate Level 2 Button opens a modal that sets a conference with the involved professor and an email will be sent for the details of the conference including the meeting link</li>
                        <li>Evaluate Level 3 Button opens a modal that sets a conference with the student and involved professor and an email will be sent for the details of the conference including the meeting link</li>
                    	<li>Input the date of the conference with the participants and a preview is provided for the Dean to view the submitted documents of the student</li>
                    	<li> Input the start time and end time of the consultation with the student</li>
                        <li> confirm button approves the request and is transferred to the scheduled tab it will also email the student</li>
                        <li> Close button closes the modal </li><br><br>
                        <b>The remark button is to notify the student on what is the current update on his student (example: The professor and i will be having a conference regarding your appeal)</b><br><br>
                        <center>
                            <b><i>The resolved button is always available for the dean even if the other levels are not yet evaluated</i></b><br><br>
                        </center>
                        <br><br>
                        <b>For the Completed tab:</b><br>
                        <li>This tab shows the requests that has been completed</li>
                        <li>Download Report button produces the pdf version of the list of completed request</li>
                        <li>View button shows the status tracker modal</li>
                        <br><br>
                        <center>
                        <b>You can ignore the evaluation button as the request has already been completed</b>
                        </center>


                        

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
          <div class="col-lg-4 col-md-8">
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
                  <a href="{{ URL::to('director/student_appeal/pending') }}" style="color: #8a6d3b">
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
          <div class="col-lg-4 col-md-8">
              <div class="panel panel-info">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-ok" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ count($scheduled) }}</div>
                              <div>Scheduled</div>
                          </div>
                      </div>
                  </div>
                  <a href="{{ URL::to('director/student_appeal/scheduled') }}" style="color: #31708f">
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
          <!-- <div class="col-lg-3 col-md-6">
              <div class="panel panel-danger">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-remove" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              <div class="huge">{{ count($declined) }}</div>
                              <div>Declined</div>
                          </div>
                      </div>
                  </div>
                  <a href="{{ URL::to('director/student_appeal/declined') }}" style="color: #a94442">
                      <div class="panel-footer" style="background-color: white !important">
                          <span class="pull-right">
                            View Details
                            <span class="glyphicon glyphicon-chevron-right"></span>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
          </div> -->
          <div class="col-lg-4 col-md-8">
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
                  <a href="{{ URL::to('director/student_appeal/completed') }}" style="color: #3c763d">
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
      <div class="row" style="margin-bottom: 1%; text-align: left">
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-default'><span class='glyphicon glyphicon-search'></span></button> - View
        </div>
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span></button> - Evaluate Level 1 Conference with the Student
        </div>
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-info'><span class='glyphicon glyphicon-eye-open'></span></button> - Evaluate Level 2 Conference with the concerned Professor
        </div>
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-warning'><span class='glyphicon glyphicon-eye-open'></span></button> - Evaluate Level 3 Conference with the Student and concerned Professor
        </div>
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-success'><span class='glyphicon glyphicon-ok-sign'></span></button> - Resolve
        </div>
        <!-- <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-danger'><span class='glyphicon glyphicon-remove'></button> - Decline
        </div> -->
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn'><span class='glyphicon glyphicon-bookmark'></button> - Remarks
        </div>
        <div class="col-lg-3 downloadCompletedListReportDiv" style="margin-bottom: 1%;">
          <button class="btn btn-default"><span class="glyphicon glyphicon-cloud-download"></span></button> - Download Report
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="panel-body" style="overflow-x: scroll">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="studentAppealTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Section</th>
                            <th>Program</th>
                            <th>Professor Involve</th>
                            <th>Specific Conern(s)</th>
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

@include('global.studApEvaluationLevel1Modal')
@include('global.studApEvaluationLevel2Modal')
@include('global.studApEvaluationLevel3Modal')
@include('global.studApDetailsModal')
