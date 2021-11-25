<!DOCTYPE html>
<html lang="en">
<head>
  <title>CICS E - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/professor/calendar/html.css'); }}">
  <link rel="stylesheet" href="{{ URL::asset('css/professor/calendar/calendar.css'); }}">
  <script src="{{ URL::asset('js/professor/calendar/html.js'); }}"></script>
  <script src="{{ URL::asset('js/professor/calendar/calendar.js'); }}"></script>
  <script src="{{ URL::asset('js/professor/schedule.js'); }}"></script>
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.min.css'); }}" rel="stylesheet">
  <link href="{{ URL::asset('datatables/css/jquery.dataTables.css'); }}" rel="stylesheet">
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.js'); }}"></script>
  <script src="{{ URL::asset('datatables/js/jquery.dataTables.min.js'); }}"></script>
</head>
<body>

@include('professor.nav')

<div class="container indexMargin">
  <input class="form-control" type="hidden" name="slot_id" id="slot_id" />
  <div class="row">
    <div class="col-md-2">
      <label>Slot Name</label>
      <input class="form-control" type="text" name="slot_name" id="slot_name" />
    </div>
    <div class="col-md-2">
      <label>Date</label>
      <div class='input-group date' id='datetimepicker1'>
         <input type='text' class="form-control" id="slot_date" name="slot_date" />
         <span class="input-group-addon">
         <span class="glyphicon glyphicon-calendar"></span>
         </span>
      </div>
    </div>
    <div class="col-md-2">
      <label>Start</label>
      <div class='input-group date' id='datetimepicker2'>
         <input type='text' class="form-control" id="slot_start" name="slot_start" />
         <span class="input-group-addon">
         <span class="glyphicon glyphicon-calendar"></span>
         </span>
      </div>
    </div>
    <div class="col-md-2">
      <label>End</label>
      <div class='input-group date' id='datetimepicker3'>
         <input type='text' class="form-control" id="slot_end" name="slot_end" />
         <span class="input-group-addon">
         <span class="glyphicon glyphicon-calendar"></span>
         </span>
      </div>
    </div>
    <div class="col-md-2" style="">
      <label>Repeat Slot?</label>
      <div class="radio">
        <label><input type="radio" name="optradio" value="1">Yes - </label>
        <label><input type="radio" name="optradio" checked value="0">No</label>
      </div>
    </div>
    <div class="col-md-2">
      <label>End Date</label>
      <div class='input-group date' id='datetimepicker4'>
         <input type='text' class="form-control" id="slot_end_date" name="slot_end_date" disabled/>
         <span class="input-group-addon">
         <span class="glyphicon glyphicon-calendar"></span>
         </span>
      </div>
    </div>
    <div class="col-md-10">
    </div>
    <div class="col-md-2 addSlotDiv" style="text-align: right; margin-top: 1%">
      <input type="button" class="btn btn-primary reserveSlot" value="Add Slot">
    </div>
    <div class="col-md-2 updateSlotDiv" style="text-align: right; display: none; margin-top: 1%">
      <input type="button" class="btn btn-primary updateSlot" value="Update Slot">
    </div>
    <div class="col-md-12" style="margin-top: 1%">
      <div class="form-group">
        <div class="alert alert-success" style="display: none" id="successNotification">
            <span id="successSlotContent">
              Slot was successfully added!
            </span>
        </div>
        <div class="alert alert-danger" style="display: none" id="failedNotification">
            <span id="failedSlotContent"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="overflow: scroll; margin-top: 1%">
    <ul class="nav nav-tabs">
      <li class="active"><a href="{{ URL::to('professor/schedule'); }}">Calendar</a></li>
      <li><a data-toggle="tab" href="#menu1">Manage Schedule</a></li>
    </ul>
    <div class="tab-content" style="margin-top: 2%">
      <div id="home" class="tab-pane fade in active">
        <input type="hidden" name="professor_id" id="professor_id" value="{{ $id }}">
        <div id='wrap'>
          <div id='calendar' style="display: none"></div>
          <div id='calendarDefault'></div>
          <div style='clear:both'></div>
        </div>
      </div>
      <div id="menu1" class="tab-pane fade">
        <div id="page-wrapper">
            <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="panel-body" style="overflow-x: scroll">
                          <table width="100%" class="table table-striped table-bordered table-hover" id="slotTable">
                              <thead>
                              <tr>
                                  <th>Slot Name</th>
                                  <th>Start</th>
                                  <th>End</th>
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
    </div>
  </div>
</div>

</body>
</html>

<script>
  $("#multiple").select2({
      placeholder: "",
      allowClear: true
  });
</script>
