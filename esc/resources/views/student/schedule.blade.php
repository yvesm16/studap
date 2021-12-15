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
  <link rel="stylesheet" href="{{ URL::asset('css/student/calendar/html.css'); }}">
  <link rel="stylesheet" href="{{ URL::asset('css/student/calendar/calendar.css'); }}">
  <script src="{{ URL::asset('js/student/calendar/html.js'); }}"></script>
  <script src="{{ URL::asset('js/student/calendar/calendar.js'); }}"></script>
  <script src="{{ URL::asset('js/student/schedule.js'); }}"></script>
  
</head>
<body>

@include('student.nav')

<div class="container indexMargin">
  <div class="row">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-5">
          <div class="form-group">
            <select class="form-control" id="professorList">
              <option disabled selected>Select Professor</option>
              @foreach($allProfessor as $professor)
                <option value="{{ $professor->id }}">{{ $professor->fname }} {{ $professor->lname }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group" style="text-align: right">
            <button class="btn btn-primary reserveSlot" data-toggle="modal" data-target="#consultationDialog" onclick="startIt()">Reserve Slot</button>
          </div>
        </div>
        <div class="col-md-2">
          <button data-toggle="modal" data-target="#tc" id="add"type="button" class="btn btn-light">How to set Consultation</button><br>
            <div class="modal fade" id="tc" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Steps on Scheduling a consultation</h4>
                  </div>
                  <p >
                    <ul style='text-align:left; margin-right:5%'>                
                        <li>On the dropdown list, you can see the list of professor that are currently registered in the system</li>
                        <li>By clicking on your chosen professor, his/her consultation hour schedule is shown in the calendar below</li>
                        <li>There are two tabs placed in the Calendar, "month" tab to view the professor's consultation schedule for the whole month and "week" tab to view the professor's schedule for the week</li>
                        <li>It's better to use the "week" tab to have a clear view on the professor's schedule</li>
                    
                        
                    </ul><br><br>
                    <center>
                      <p style='text-align: justify; margin-left: 5%; margin-right: 5%;'>
                      <b ><i>You must take note on the consultation hours of the specified professor as the system will restrict you from scheduling an appointment not within the professor's consultation hours</i></b><br><br>
                      </p>
                    </center>
                    <center>
                      <p style='text-align: justify; margin-left: 5%; margin-right: 5%;'>
                      <b><i>If you wish to have a consultation with the professor outside the consultation hours, the professor must set the appointment in their respective accounts in the system and you will receive an email notification and a status tracker regarding the consultation meeting details</i></b><br><br>
                      </p>
                    </center></p>
                  </p>
                  
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  
                  </div>
                </div>
            
              </div>
            </div><br>
        </div>
      </div>
    </div>
    <div class="col-sm-12" style="overflow: scroll">
      <div id='wrap'>
        <div id='calendar' style="display: none"></div>
        <div id='calendarDefault'></div>
        <div style='clear:both'></div>
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
        <i>
          Note: <br>
          <ul>
            <li>Check first the availability of the professor before reserving a slot</li>
            <li>You can only reserve a slot within a week</li>
          </ul>
        </i>
        <!-- <form action="#"> -->
          <input type="hidden" id="hdnBaseUrl" value="{{ URL::to('/') }}">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="form-group">
            <select class="form-control" id="professor_id" name="professor_id">
              <option disabled selected>Select Professor</option>
                <optgroup label="IT Department">
                  @foreach($allITProfessor as $it_professor)
                    <option value="{{ $it_professor->id }}">{{ $it_professor->fname }} {{ $it_professor->lname }}</option>
                  @endforeach
                </optgroup>
                <optgroup label="IS Department">
                  @foreach($allISProfessor as $is_professor)
                    <option value="{{ $is_professor->id }}">{{ $is_professor->fname }} {{ $is_professor->lname }}</option>
                  @endforeach
                </optgroup>
                <optgroup label="CS Department">
                  @foreach($allCSProfessor as $cs_professor)
                    <option value="{{ $cs_professor->id }}">{{ $cs_professor->fname }} {{ $cs_professor->lname }}</option>
                  @endforeach
                </optgroup>
            </select>
          </div>
  
          <div class="form-group">
            <label>Appointment Date</label>
            <div class='input-group date' id='datetimepicker1'>
               <input type='text' class="form-control" id="appointment_date" name="appointment_date"/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>
          </div>
          <div class="form-group">
            <label>Appointment Start</label>
            <div class='input-group date' id='datetimepicker2' onclick="validateAppointmentTime('start')">
               <input type='text' class="form-control" id="appointment_start" name="appointment_start"  />
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
               </span>
            </div>
          </div>
          <div class="form-group">
            <label>Appointment End</label>
            <div class='input-group date' id='datetimepicker3' onclick="validateAppointmentTime('end')">
               <input type='text' class="form-control" id="appointment_end" name="appointment_end"/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
               </span>
            </div>
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
          <div class="alert alert-success" style="display: none" id="successNotification">
              Appointment was successfully submitted. Wait for further updates.
          </div>
          <div class="alert alert-danger" style="display: none" id="failedNotification">
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
