<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
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
            <button class="btn btn-primary reserveSlot" data-toggle="modal" data-target="#consultationDialog">Reserve Slot</button>
          </div>
        </div>
        <div class="col-md-2">
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
        <!-- <form action="#"> -->
          <input type="hidden" id="hdnBaseUrl" value="{{ URL::to('/') }}">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="form-group">
            <select class="form-control" id="professor_id" name="professor_id">
              <option disabled selected>Select Professor</option>
              @foreach($allProfessor as $professor)
                <option value="{{ $professor->id }}">{{ $professor->fname }} {{ $professor->lname }}</option>
              @endforeach
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
            <div class='input-group date' id='datetimepicker2'>
               <input type='text' class="form-control" id="appointment_start" name="appointment_start"/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>
          </div>
          <div class="form-group">
            <label>Appointment End</label>
            <div class='input-group date' id='datetimepicker3'>
               <input type='text' class="form-control" id="appointment_end" name="appointment_end"/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>
          </div>
          <div class="form-group">
            <label>Concerns</label>
            @foreach($allActiveConcerns as $concerns)
              @if($concerns->text != 'Others')
                <div class="checkbox">
                  <label><input type="checkbox" class="concerns" value="{{ $concerns->id }}" name="concerns">{{ $concerns->text }}</label>
                </div>
              @else
                <div class="checkbox">
                  <label><input type="checkbox" class="concerns" value="{{ $concerns->id }}" id="others" name="concerns">{{ $concerns->text }}</label>
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
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitConsultationForm">Submit</button>
      </div>
    </div>

  </div>
</div>
