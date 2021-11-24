<!DOCTYPE html>
<html>
<head>
    <title>IICS E-Services - Email Account Verification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style="background-image: url('http://104.237.150.196/esc/public/img/backgrounds.jpeg'); background-size: 100%;">
  <br><br><br><br><br>
  <div style="margin-left: 15%; padding:2%; background-color: white; width:75%; border-radius: 15px;" class="container">
    <div class="row">
      <div class="col-sm-12" style="text-align: center">
        <img src="http://104.237.150.196/esc/public/img/iicslogo.png" width="100px">
      </div>
      <div class="col-sm-12">
        <p>
          Hello {{ $student_fname }} {{ $student_lname }},
        </p>
        <p>
          <h1>Update on your Student Appeal</h1>
        </p>
        <p>
          <ul>
            <li><b>Professor Name</b>: {{ $professor_fname }} {{ $professor_lname }}</li>
            <li><b>Start Datetime</b>: {{ $start_time }}</li>
            <li><b>End Datetime</b>: {{ $end_time }}</li>
            <li><b>Message</b>: {{ $message }}</a></li>
          </ul>
        </p>
        <p style="margin-top: 5%">
          Cheers,<br>
          IICS E-Services Support Team
        </p>
      </div>
    </div>
  </div>
  <br><br><br><br><br>
</body>
</html>
