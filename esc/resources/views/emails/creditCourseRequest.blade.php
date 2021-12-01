<!DOCTYPE html>
<html>
<head>
    <title>IICS E-Services - New Course Crediting Request</title>
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
          Hello {{ $chairperson_fname }} {{ $chairperson_lname }},
        </p>
        <p>
          <h1>Credit Course Request</h1>
        </p>
        <p>
          <ul>
            <li><b>Student Name</b>: {{ $student_fname }} {{ $student_lname }}</li>
            <li><b>Concerns</b>: {{ $concerns }}</li>
            <!-- <li><b>Contact No.</b>: {{-- $contact_number --}}</li> -->
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
