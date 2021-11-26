<script src="{{ URL::asset('js/global.js'); }}"></script>
<input type="hidden" id="hdnBaseUrl" value="{{ URL::to('/') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ URL::asset('js/student/global.js'); }}"></script>
<?php
    $filename = basename($_SERVER["REQUEST_URI"]);
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<nav class="navbar navbar-inverse" style="border-radius: 0px !important">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li <?php echo (str_contains($actual_link,'home')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('student/home'); }} ">Home</a></li>
        <li <?php echo (str_contains($actual_link,'schedule')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('student/schedule'); }}">Schedule</a></li>
        <li <?php echo (str_contains($actual_link,'student/appeal')) ? 'class="active"' : ''; ?>><a href="#" class="appeal">Appeal</a></li>
        <li <?php echo (str_contains($actual_link,'student/crediting')) ? 'class="active"' : ''; ?>><a href="#" class="crediting">Crediting</a></li>
        <li <?php echo (str_contains($actual_link,'tracker')) ? 'class="active"' : ''; ?> class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tracker <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ URL::to('student/tracker/consultation') }}">Consultation</a></li>
            <li><a href="{{ URL::to('student/tracker/appeal') }}">Appeal</a></li>
            <li><a href="{{ URL::to('student/tracker/crediting') }}">Crediting</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" style="text-decoration: none; color: white">Hi {{ $fname }} {{ $lname }}!</a></li>
        <li>
          <a href="#"
          data-toggle="popover"
          data-placement="bottom"
          title="Notifications"
          data-html="true"
          data-content="Hello World"
          class="toggle_notification">
          <span class="glyphicon glyphicon-bell notificationBell">
            <!-- <span class="badge" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif !important;">5</span> -->
          </span>
        </a></li>
        <li><a href="#" data-toggle="modal" data-target="#myModal" id="settings"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
        <li><a href="{{ URL::to('logout'); }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <form action="{{ URL::to('/changePassword') }}" method="post">
      <div class="modal-body">
          <div class="form-group">
            <label for="pwd">Current Password:</label>
            <input type="password" class="form-control" id="currentPassword" placeholder="Enter password" name="currentPassword">
          </div>
          <div class="form-group">
            <label for="npwd">New Password:</label>
            <input type="password" class="form-control" id="newPassword" placeholder="Enter password" name="newPassword">
          </div>
          <div class="form-group">
            <label for="npwd">Confirm Password:</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Enter password" name="confirmPassword">
          </div>
          <div class="alert alert-success" style="display: none" id="successPassword">
              Password was successfully updated!
          </div>
          <div class="alert alert-danger" style="display: none" id="failedPassword">
              <span id="failedContent"></span>
          </div>
      </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitChangePassword">Submit</button>
      </div>
    </div>
  </form>

  </div>
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
      container: 'body'
    });

    var BASE_URL = $("#hdnBaseUrl").val();

    $(window).on('load', function() {
      $.ajax({
          url: BASE_URL + '/student/getCourses',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              for(let i = 0; i < data['data'].length; i++){
                $("#course_id").append(new Option(data['data'][i]['text'], data['data'][i]['id']));
              }
            }
          }
      });
      $.ajax({
          url: BASE_URL + '/student/getStudentID',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == false){
              $('#studentIDModal').modal('show');
            }
          }
      });
    });

    $('.crediting').on('click',function(){
      $.ajax({
          url: BASE_URL + '/student/getCourses',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              for(let i = 0; i < data['data'].length; i++){
                $("#course_id").append(new Option(data['data'][i]['text'], data['data'][i]['id']));
              }
            }
          }
      });
      $.ajax({
          url: BASE_URL + '/student/getStudentID',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              window.location.href = BASE_URL + '/student/crediting';
            }else{
              $('#studentIDModal').modal('show');
              return false;
            }
          }
      });
    });

    $('.appeal').on('click',function(){
      $.ajax({
        url: BASE_URL + '/student/getCourses',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {},
        dataType    :'json',
        success: function (data) {
          if(data.result == true){
            for(let i = 0; i < data['data'].length; i++){
              $("#course_id").append(new Option(data['data'][i]['text'], data['data'][i]['id']));
            }
          }
        }
      });
      $.ajax({
        url: BASE_URL + '/student/getStudentID',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {},
        dataType    :'json',
        success: function (data) {
          if(data.result == true){
            window.location.href = BASE_URL + '/student/appeal';
          }else{
            $('#studentIDModal').modal('show');
            return false;
          }
        }
      });
    });

    $('#submitStudentID').on('click',function(){
      $.ajax({
          url: BASE_URL + '/student/postStudentID',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {
            'student_id' : $('#student_id').val(),
            'course_id' : $('#course_id').val()
          },
          dataType    :'json',
          success: function (data) {
          if(data.student_id <10) {
            if(data.result == true){
              $('#successStudentID').css('display','block');
              $('#failedStudentID').css('display','none');
              $('#warningStudentID').css('display','none');

            }else{
              $('#successStudentID').css('display','none');
              $('#failedStudentID').css('display','block');
              $('#warningStudentID').css('display','none');

            }
          }else {
            $('#successStudentID').css('display','none');
            $('#failedStudentID').css('display','none');
            $('#warningStudentID').css('display','block');
          }
          }
      });
    });

});
</script>

<div id="studentIDModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Important Details</h4>
      </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Student ID</label>
            <input type="number" class="form-control" id="student_id" name="student_id" maxlength="10" minlength="10">
          </div>
          <div class="form-group">
            <label>Course</label>
            <select class="form-control" name="course_id" id="course_id">
            </select>
          </div>
          <div class="form-group">
            <div class="alert alert-success" style="display: none" id="successStudentID">
                Data was successfully saved!
            </div>
            <div class="alert alert-warning" style="display: none" id="warningStudentID">
              UST Student number only has 10 digits!
          </div>
            <div class="alert alert-danger" style="display: none" id="failedStudentID">
                Student ID is already existing!
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="submitStudentID">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

  </div>
</div>
