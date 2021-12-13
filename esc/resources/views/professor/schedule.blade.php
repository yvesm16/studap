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

@if($user_type == '1')
    @include('professor.nav')
@elseif($user_type == '3')
    @include('secretary.nav')
@else
    @include('director.nav')
@endif

<div class="container indexMargin">
  <input class="form-control" type="hidden" name="slot_id" id="slot_id" />
  <div class="row">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-5">
        </div>
        <div class="col-md-2">
        </div>
        <div class="col-sm-3">
          <div class="form-group" style="text-align: right">
            <button class="btn btn-primary setAppointment" data-toggle="modal" data-target="#consultationDialog" onclick="startIt()">Set Appointment</button>
          </div>
        </div>
      </div>
    </div>
  </div>
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
    <!-- <ul class="nav nav-tabs">
      <li class="active"><a href="{{ URL::to('professor/schedule'); }}">Calendar</a></li>
    </ul> -->
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

<div class="modal fade" id="consultationDialog" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Consultation Form</h4>
      </div>
      <div class="modal-body">
        <!-- <form action="#"> -->
          <input type="hidden" id="hdnBaseUrl" value="{{ URL::to('/') }}">
          <meta name="csrf-token" content="{{ csrf_token() }}">
  
          <div class="form-group">
            <label>Name of the Student</label>
            <input type='text' class="form-control" id="student_name" name="student_name"/>
          </div>
          <div class="form-group">
            <label>Email of the Student</label>
            <input type='email' class="form-control" id="student_email" name="student_email"/>
          </div>
          <div class="form-group">
            <label>Appointment Date</label>
            <div class='input-group date' id='datetimepicker1-2'>
               <input type='text' class="form-control" id="appointment_date" name="appointment_date"/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>
          </div>
          <div class="form-group">
            <label>Appointment Start</label>
            <div class='input-group date' id='datetimepicker2-2' onclick="validateAppointmentTime('start')">
               <input type='text' class="form-control" id="appointment_start" name="appointment_start"  />
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
               </span>
            </div>
          </div>
          <div class="form-group">
            <label>Appointment End</label>
            <div class='input-group date' id='datetimepicker3-2' onclick="validateAppointmentTime('end')">
               <input type='text' class="form-control" id="appointment_end" name="appointment_end"/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
               </span>
            </div>
          </div>
          <div class="form-group">
            <label>Meeting Link</label>
            <input type='text' class="form-control" id="meeting_link" name="meeting_link"/>
          </div>
          <div class="form-group">
            <label>Concerns</label>
            @foreach($allActiveConcerns as $concerns)
              @if($concerns->text != 'Others')
                <div class="radio">
                  <label><input type="radio" class="concerns" value="{{ $concerns->id }}" name="concerns">{{ $concerns->text }}</label>
                </div>
              @else
                <div class="radio">
                  <label><input type="radio" class="concerns" value="{{ $concerns->id }}" id="others" name="concerns">{{ $concerns->text }}</label>
                </div>
              @endif
            @endforeach
          </div>
          <div class="form-group othersInput" style="display: none">
            <input type="text" class="form-control" id="othersText" name="othersText">
          </div>
          <div class="alert alert-success" style="display: none" id="successModalNotification">
              Appointment was successfully submitted. Wait for further updates.
          </div>
          <div class="alert alert-danger" style="display: none" id="failedModalNotification">
              <span id="failedText"></span>
          </div>
           <div class="alert alert-danger" style="display: none" id="failedNotificationTime">
              <span id="failedTextTime"></span>
          </div>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitConsultationForm">Submit</button>
      </div>
    </div>

  </div>
</div>
<script>
  $("#multiple").select2({
      placeholder: "",
      allowClear: true
  });
</script>

<script type="text/javascript">


  function startIt(){

   validateAppointmentTime("start");
  }
  function validateAppointmentTime(param){
    //  7am  - 8pm

    var hourArray = ["7","8","9","10","11","12","13","14","15","16","17","18","19","20"];

    var start = $("#appointment_start").val();
    start = convertTo24Hour(start.toLowerCase());

    var sHr = start.split(":");
    sHr     = sHr[0];

    var end = $("#appointment_end").val();
     end = convertTo24Hour(end.toLowerCase());
    var eHr = end.split(":");
    eHr     = eHr[0];
     
   
    if(hourArray.indexOf(sHr) !== -1){
   
          $("#failedNotificationTime").hide();
          $("#failedNotificationTime").css('display','none');
          $("#submitConsultationForm").attr('disabled',false);
           SumHours(start,end);
           
      }else{
       $("#failedTextTime").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
        $("#submitConsultationForm").attr('disabled',true);
       $("#failedNotificationTime").show();
      }

     if(hourArray.indexOf(eHr) !== -1){
          $("#failedNotificationTime").hide();
          $("#failedNotificationTime").css('display','none');
          $("#submitConsultationForm").attr('disabled',false);
           SumHours(start,end);
      } else{
          $("#failedTextTime").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
          $("#submitConsultationForm").attr('disabled',true);
          $("#failedNotificationTime").show();
      }

     setTimeout(function(){ validateAppointmentTime("start"); }, 3000);
   
  }
  function convertTo24Hour(time) {
    var hours = parseInt(time.substr(0, 2));
    if(time.indexOf('am') != -1 && hours == 12) {
        time = time.replace('12', '0');
    }
    if(time.indexOf('pm')  != -1 && hours < 12) {
        time = time.replace(hours, (hours + 12));
    }
    return time.replace(/(am|pm)/, '');
}


  function SumHours(smon,fmon) {
  // console.log(smon+"smon");
  //  console.log(fmon+"fmon");
  var diff = 0 ;
  if (smon && fmon) 
  {
    smon = ConvertToSeconds(smon);
    fmon = ConvertToSeconds(fmon);
    diff = Math.abs( fmon - smon ) ;
    if(diff < 1800){
        // $("#failedText").text("");
        $("#failedTextTime").text("Appointment Minimum Time : 30 Mins");
        $("#failedNotificationTime").show();
        $("#submitConsultationForm").attr('disabled',true);

    }else if(diff >10800){
       $("#failedTextTime").text("Appointment Maximum Time : 3 Hours");
        $("#failedNotificationTime").show();
        $("#submitConsultationForm").attr('disabled',true);

    }else{
         $("#failedNotificationTime").hide();
          $("#failedNotificationTime").css('display','none');
          $("#submitConsultationForm").attr('disabled',false);
      }

    }
  }

  function ConvertToSeconds(time) {
    var splitTime = time.split(":");
    return splitTime[0] * 3600 + splitTime[1] * 60;
  }

  function secondsTohhmmss(secs) {
    var hours = parseInt(secs / 3600);
    var seconds = parseInt(secs % 3600);
    var minutes = parseInt(seconds / 60) ;
    return hours + "hours : " + minutes + "minutes ";
  }

</script>