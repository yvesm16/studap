<script src="{{ URL::asset('js/global.js'); }}"></script>
<input type="hidden" id="hdnBaseUrl" value="{{ URL::to('/') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ URL::asset('js/professor/global.js'); }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/professor/global.css'); }}">
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
        <li <?php echo (str_contains($actual_link,'home')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/home'); }} ">Home</a></li>
        <li <?php echo (str_contains($actual_link,'schedule')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/schedule'); }} ">Schedule</a></li>
        <li <?php echo (str_contains($actual_link,'requests')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/requests/0'); }} ">Requests</a></li>
        
        @if ($isProfessorChairperson)
          <li <?php echo (str_contains($actual_link,'crediting')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/crediting/0'); }}" class="crediting">Crediting</a></li>
          <li <?php echo (str_contains($actual_link,'dashboard/cs')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/dashboard/cs'); }}" class="">CS Dashboard</a></li>
          <li <?php echo (str_contains($actual_link,'dashboard/it')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/dashboard/it'); }}" class="">IT Dashboard</a></li>
          <li <?php echo (str_contains($actual_link,'dashboard/is')) ? 'class="active"' : ''; ?>><a href="{{ URL::to('professor/dashboard/is'); }}" class="">IS Dashboard</a></li>
          
        @endif

        
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
        <h4 class="modal-title">Settings</h4>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Change Password</a></li>
          <li><a data-toggle="tab" href="#menu1">Signature</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <form action="{{ URL::to('/changePassword') }}" method="post">
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
              <div class="form-group">
                <button type="button" class="btn btn-primary" id="submitChangePassword">Submit</button>
              </div>
            </form>
          </div>
          <div id="menu1" class="tab-pane fade" style="padding-top: 1%">
            <form action="{{ URL::to('professor/uploadSignature') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <input type="file" name="fileUpload" class="form-control-file" id="fileUpload">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Upload</button>
              </div>
            </form>
            <p>
              <span id="spanSignature">
                No current signature
              </span>
            </p>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>  

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
      container: 'body'
    });
});
</script>

<script>
  $(document).ready(function(){

    var BASE_URL = $("#hdnBaseUrl").val();

    $('[data-toggle="popover"]').popover({
      container: 'body'
    });

    $(window).on('load', function() {
      $.ajax({
          url: BASE_URL + '/professor/getSignature',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              $("#spanSignature").html('<a href=' + BASE_URL + '/' + data.data['path'].replace('public','storage') + ' target=blank>Current Signature</a>');
            }else{
              document.getElementById("spanSignature").textContent = 'No current signature';
            }
          }
      });
    }); --}}

    $('.crediting').on('click',function(){
      $.ajax({
          url: BASE_URL + '/professor/getSignature',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              window.location.href = BASE_URL + '/professor/crediting/0';
            }else{
              $('#signatureModal').modal('show');
              return false;
            }
          }
      });
    });

  });
</script> 

<div id="successModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Success!</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-success">
          <strong>Success!</strong> Signature was successfully uploaded!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div id="failedModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Failed!</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
          <strong>Failed!</strong> Invalid file format or size is greater than 2MB!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div id="signatureModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Signature</h4>
      </div>
      <form action="{{ URL::to('professor/uploadSignature') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <input type="file" name="fileUpload" class="form-control-file" id="fileUpload">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>

  </div>
</div>
