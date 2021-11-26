<script src="{{ URL::asset('js/global.js'); }}"></script>
<input type="hidden" id="hdnBaseUrl" value="{{ URL::to('/') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ URL::asset('js/secretary/global.js'); }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/secretary/global.css'); }}">
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
        <li <?php echo (str_contains($actual_link,'home')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('secretary/home'); }} ">Home</a></li>
        <li <?php echo (str_contains($actual_link,'crediting')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('secretary/crediting/2'); }} " class="crediting">Crediting</a></li>
        <li <?php echo (str_contains($actual_link,'manage')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('secretary/manage'); }}">Manage Users</a></li>

        <!-- <li <?php echo (str_contains($actual_link,'users')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/requests/0'); }} ">Users</a></li> -->
        <!-- <li><a href="#">Crediting</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tracker <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Consultation</a></li>
            <li><a href="#">Appeal</a></li>
            <li><a href="#">Crediting</a></li>
          </ul>
        </li> -->
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
    </form>
    </div>

  </div>
</div>

<script>
  $(document).ready(function(){

    var BASE_URL = $("#hdnBaseUrl").val();

    $('[data-toggle="popover"]').popover({
      container: 'body'
    });
  });
</script>
