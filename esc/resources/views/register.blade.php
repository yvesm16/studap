<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/index.css'); }}">
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
          <h1>IICS E-SERVICES</h1>
        </div>
        <div class="col-sm-12">
          <h3>Consultation, Student Appeal and Course Crediting</h3>
        </div>
      </div>
    </div>
    <div class="col-sm-4 loginForm">
      <ul class="nav nav-tabs">
        <li><a href="{{ URL::to('/'); }}">Login</a></li>
        <li class="active"><a data-toggle="tab" href="#home">Register</a></li>
      </ul>
      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <h2 style="text-align: center">Register</h2>
          <form action="{{ URL::to('postRegister'); }}">
            <div class="form-group">
              <label for="fname">First Name:</label>
              <input type="text" class="form-control" id="fname" placeholder="Enter first name" name="fname" value="{{ old('fname') }}" required>
            </div>
            <div class="form-group">
              <label for="lname">Last Name:</label>
              <input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lname" value="{{ old('lname') }}" required>
            </div>
            <div class="form-group">
              <label for="email">UST Email:</label>
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
              <label class="radio-inline">
                <input type="radio" name="type" checked value="0">Student
              </label>
              <label class="radio-inline">
                <input type="radio" name="type" value="1">Faculty
              </label>
            </div>
            <div class="form-group">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
            </div>
            <div class="form-group">
              <label for="pwd">Retype Password:</label>
              <input type="password" class="form-control" id="rpwd" placeholder="Enter retype password" name="rpwd" required>
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
