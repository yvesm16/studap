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
            <h1 style='text-align: center;'> Consultation Guidelines</h1>

            <div class='col-sm-12 col-md-6 col-lg-6'>
                <h3 style='text-align: left; margin-left: 25px'> Process Map</h3>
                <img src="{{ URL::asset('img/guideline_cons.png')}}" height="550px" style="margin-top: 1%">
            </div>
            <div class='col-sm-12 col-md-6 col-lg-6 ' style='text-align: left;'>
                <h3 style='text-align: left;'> Step by Step Procedure</h3>

                <p style='font-size: 15px; margin-right: 40px;'><b>Step 1:</b> Login with your registered credentials<br>
                <b>Step 2:</b> Go to the Schedule tab to reserve a consultation<br>
                <b>Step 3:</b> The list of professor is listed in the dropdown bar.<br>
                <b>Step 4:</b> By clicking on the weekly button, you can see the schedule of the professor and choose a time that does not conflict with the schedule of the professor. <br>
                <b>Step 5:</b> Click on the Reserve Slot button to request a consultation with you specificed Professor.<br>
                <b>Step 6:</b> Submit the confirm button when all of the input fields are answered. <br>
                <b>Step 7:</b> The professor will receieve an email notification regarding your request for consultation.<br>
                <b>Step 8:</b> Once evaluated by the professor, an email notification will be sent to you regarding the on the decision of the professor whether it was accepted or not. <br>
                <b>Step 9:</b> An email will also, be sent to you if the the professor have set a meeting link to conduct to consultation.<br>
                <b>Step 10:</b> You can check as well the progress of your request through the status tracker tab (Consultation).<br>
                <b>Step 11:</b> After your consultation meeting, your request will be completed.
            </p>
            </div>
            
        </div>
        <h3 style='margin-top: 50px; ''>CICS E-Services</h3>
    Student Consultation || Student Appeal on Course Grade || Course Crediting
    <br><br>
    </div>

</body>
</html>