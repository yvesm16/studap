<!DOCTYPE html>
<html>
<head>
    <title>CICS E-Services - Scheduled Consultation Tomorrow</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style="background-image: url('http://104.237.150.196/esc/public/img/backgrounds.jpeg'); background-size: 100%;">
  <br><br><br><br><br>
  <div style="margin-left: 15%; padding:2%; background-color: white; width:75%; border-radius: 15px;" class="container">
    <div class="row">
      <div class="col-sm-12" style="text-align: center">
        {{-- <img src="http://104.237.150.196/esc/public/img/iicslogo.png" width="100px"> --}}
      </div>
      <div class="col-sm-12">
        <p>
          Good Day! {{ $target_fname }} {{ $target_lname }}
        </p>
        <p>
          <h1>Reminder: Tomorrow is your Consultation</h1>
          with {{ $with_fname }} {{ $with_lname }}
        </p>
        <p>
          <ul>
            <li><b>Start Datetime</b>: {{ $start_time }}</li>
            <li><b>End Datetime</b>: {{ $end_time }}</li>
            <li><b>Meeting Link</b>: <a href="{{ $meeting_link }}">{{ $meeting_link }}</a></li>
          </ul>
        </p>
        <p style="margin-top: 5%">
          Cheers,<br>
          CICS E-Services Support Team
        </p>
      </div>
    </div>
  </div>
  <br><br><br><br><br>
</body>
</html>
