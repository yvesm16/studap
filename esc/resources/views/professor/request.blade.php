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
  <script src="{{ URL::asset('js/professor/requests.js'); }}"></script>
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.min.css'); }}" rel="stylesheet">
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.css'); }}" rel="stylesheet">
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.js'); }}"></script>
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.min.js'); }}"></script>
</head>
<body>

@if($user_type == '1')
    @include('professor.nav')
@elseif($user_type == '3')
    @include('secretary.nav')
@else
    @include('director.nav')
@endif

<input type="hidden" id="status" name="status" value="{{ $status }}">
<div class="container indexMargin home">
    
  <div id="page-wrapper">
      
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><span id="titlePage">Consultations</span></h1>
              <button data-toggle="modal" data-target="#tc" id="add"type="button" class="btn btn-light">Guidelines</button><br>
            <div class="modal fade" id="tc" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Guidelines for Student Consultation</h4>
                  </div>
                  <p >
                    <ul style='text-align:left; margin-right:5%'>
                        <center>
                        <b><i>There are labels indicated for each provided button</i></b><br><br>
                        </center>
                        <b>For the pending tab:</b><br>
                        <li>View Button will show the appointment details and the status of the request</li>
                    	<li>The close button closes the modal</li>
                    	<li>The Blue check box button allows the professor to approve the request and continue the next step</li>
                    	<li>The red x button disapproves the request and the request will transfer to the decline tab</li>
                    	<li>When the professor click on the approve button it will reappear in the approved tab that indicates the request has been approved</li><br><br>
                        <b>For the Approved tab:</b><br>
                        <li>The view button must be clicked, and the meeting link must be entered in the input box</li>
                    	<li>The save link button must be click so the meeting link will be saved to the student</li>
                    	<li>The light blue check button must be clicked when the consultation is about to start</li>
                    	<li>The green button will end the consultation and the request will be on the completed tab</li>
                    	<li>Once the consultation has ended, the request is transfered to the completed tab</li><br><br>
                        <b>For the Completed tab:</b><br>
                        <li>The view details show the details of the request </li>
                    	<li>The save link button must be click so the meeting link will be saved to the student</li>
                    	<li>The download report button allows to generate the table into a pdf file</li>
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
                  
                  <a href="{{ URL::to('professor/requests/0') }}" style="color: #8a6d3b">
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
                  <a href="{{ URL::to('professor/requests/1') }}" style="color: #31708f">
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
                  <a href="{{ URL::to('professor/requests/2') }}" style="color: #a94442">
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
                  <a href="{{ URL::to('professor/requests/4') }}" style="color: #3c763d">
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
          <button class='btn btn-primary'><span class='glyphicon glyphicon-ok'></span></button> - Approve
        </div>
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-danger'><span class='glyphicon glyphicon-remove'></button> - Disapprove
        </div>
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-info'><span class='glyphicon glyphicon-ok-sign'></span></button> - Start
        </div>
        <div class="col-lg-2" style="margin-bottom: 1%">
          <button class='btn btn-success'><span class='glyphicon glyphicon-minus-sign'></span></button> - End
        </div>
        <div class="col-lg-2 downloadCompletedListReportDiv" style="margin-bottom: 1%;">
          <button class="btn btn-warning"><span class="glyphicon glyphicon-cloud-download"></span></button> - Download Report
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
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Concern</th>
                            <th>Status</th>
                            <th style="width: 120px !important">Actions</th>
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
