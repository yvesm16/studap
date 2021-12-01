<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CICS e-Services</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
  <!-- <script src="{{ URL::asset('js/student/index.js'); }}"></script> -->
</head>
<body>
@include('student.nav')

    <div class="container indexMargin home">
        <div class='row'>
            <h1 style='text-align: center;'> Student Appeal on Course Grades Guidelines</h1>

            <div class='col-sm-12 col-md-6 col-lg-6'>
                <h3 style='text-align: left; margin-left: 25px'> Process Map</h3>
                <img src="{{ URL::asset('img/guideline_sa.png')}}" height="550px" style="margin-top: 1%">
            </div>
            <div class='col-sm-12 col-md-6 col-lg-6 ' style='text-align: left; '>
                <h3 style='text-align: left;'> Step by Step Procedure</h3>

                <p style='font-size: 15px; margin-right: 40px;'><b>Step 1:</b> Login with your registered credentials.<br>
                <b>Step 2:</b> Go to the Appeal tab.<br>
                <b>Step 3:</b> Fill up the request form and upload the necessary documents needed such as Letter
                of Student Appeal, Copy of grades in Blackboard, and etc. <br>
                <b>Step 4:</b> If all inputs are successfully answered, click on submit. <br>
                <b>Step 5:</b> Your request will be sent to directly to the CICS Dean.<br>
                <b>Step 6:</b> An email notification will be sent to you for an update once the dean has evaluated your request. <br>
                <b>Step 7:</b> You can view the progress of your request in the student appeal status tracker.<br>
                </p>
            </div>
            
        </div>
        <h3 style='margin-top: 50px; ''>CICS E-Services</h3>
    Student Consultation || Student Appeal on Course Grade || Course Crediting
    <br><br>
    </div>

</body>
</html>