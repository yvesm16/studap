<!DOCTYPE html>
<html lang="en">
<head>
  <title>CICS E - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/index.css'); }}">
  <script src="{{ URL::asset('js/index.js'); }}"></script>
</head>
<body>

<div class="container indexMargin">
  <div class="row">
    <div class="col-sm-8">
      <div class="row">
        <div class="col-sm-12">
          <h1>WELCOME</h1>
        </div>
        <div class="col-sm-12">
          <img src="{{ URL::asset('img/iicslogo.png')}}" width="100px">
        </div>
        <div class="col-sm-12">
          <h1>CICS E-SERVICES</h1>
        </div>
        <div class="col-sm-12">
          <h3>Consultation, Student Appeal and Course Crediting</h3>
        </div>
      </div>
    </div>
    <div class="col-sm-4 loginForm">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Login</a></li>
        <li><a href="{{ URL::to('register'); }}">Register</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <h2 style="text-align: center">Login</h2>
          <form action="{{ URL::to('checkLogin'); }}">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-group">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
            </div>
            <div class="form-group">
              <label><a href="#" data-toggle="modal" data-target="#myModal" style="color: black; text-decoration: none" id="forgotPassword">Forgot password?</a></label>
            </div>
            <div class="form-group">
              @if (session('error'))
                      <div class="alert alert-danger">
                          {{ session('error') }}
                      </div>
              @endif
              @if (session('success'))
                      <div class="alert alert-success">
                          {{ session('success') }}
                      </div>
              @endif
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Forgot Password</h4>
      </div>
      <div class="modal-body">
        <!-- <form action="#"> -->
          <input type="hidden" id="hdnBaseUrl" value="{{ URL::to('/') }}">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="emailForgotPassword" placeholder="Enter email" name="email" required>
          </div>
          <div class="alert alert-success" style="display: none" id="successNotification">
              Please check your email for the instruction.
          </div>
          <div class="alert alert-danger" style="display: none" id="failedNotification">
              Email does not exist!
          </div>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitForgotPassword">Submit</button>
      </div>
    </div>

  </div>
</div>
