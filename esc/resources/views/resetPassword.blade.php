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

<!-- <div class="jumbotron text-center">
  <h1>My First Bootstrap Page</h1>
  <p>Resize this responsive page to see the effect!</p>
</div> -->

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
        <li class="active"><a data-toggle="tab" href="#home">Reset Password</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <h2 style="text-align: center">Set New Password</h2>
          <form action="{{ URL::to('resetPassword') }}">
            <input type="hidden" class="form-control" id="slug" name="slug" value="{{ $slug }}">
            <div class="form-group">
              <label for="pwd">New Password:</label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
            </div>
            <div class="form-group">
              <label for="rpwd">Confirm Password:</label>
              <input type="password" class="form-control" id="cpwd" placeholder="Enter password" name="cpwd">
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
