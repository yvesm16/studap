<!DOCTYPE html>
<html>
<head>
    <title>CICS E-Services - Completed Request in Consultation</title>
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
          Hello {{ $student_fname }} {{ $student_lname }},
        </p>
        <p>
          <h1>Update on your Appointment</h1>
        </p>
        <p>
          <ul>
            <li><b>Professor Name</b>: {{ $professor_fname }} {{ $professor_lname }}</li>
            <li><b>Start Datetime</b>: {{ $start_time }}</li>
            <li><b>End Datetime</b>: {{ $end_time }}</li>
            <li><b>Status</b>: <span style="color: green">Completed</span></li>
          </ul>
        </p>
        <p>
          Thank you for using ESC E-Services in processing your request. Rate your experience while using the website by clicking on the link and help us improve. 
          <a href="https://esc-cics.com/satisfaction">E-Services Student Satisfaction</a>         
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
