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
            <h1 style='text-align: center;'> Course Crediting Guidelines</h1>

            <div class='col-sm-12 col-md-6 col-lg-6'>
                <h3 style='text-align: left; margin-left: 25px'> Process Map</h3>
                <img src="{{ URL::asset('img/guideline_cc.png')}}" height="1000px" style="margin-top: 1%">
            </div>
            <div class='col-sm-12 col-md-6 col-lg-6 ' style='text-align: left;'>
                <h3 style='text-align: left;'> Step by Step Procedure</h3>

                <p style='font-size: 15px; margin-right: 40px;'><b>Step 1:</b> Login with your registered credentials.<br>
                <b>Step 2:</b> Go to the Crediting tab to request for a course crediting.<br>
                <b>Step 3:</b> Fill out all the input in the forms provided.<br>
                <b>Step 4:</b> Attach the necessary documents for the crediting of course/s such as scanned transcript of records, screenshot of grade from MyUste Student portal, and course description of the course/s to be credited. <br>
                <b>Step 5:</b> Once the form is completed, click on the subject information tab and answer the approval sheet for courses to be credited.<br>
                <b>Step 6:</b> Click on the submit button when finished.<br>
                <b>Step 7:</b> Your request will be recevied by the Department Chair depending on the program you plan on having an affiliation with.<br>
                <b>Step 8:</b> The department chair will be sent an email notification.<br>
                <b>Step 9:</b> Wait for the evaluation whether it was accepted or declined through email notification and you can view the status tracker tab (Course Crediting) to see the progress of your request.<br>
                <b>Step 10:</b> If your request has been <i>declined</i>, you must submit another request that fulfills the reason of declining if you wish to continue with your concerns.<br>
                If your request has been <i>accepted</i>, an email will be sent to you and your request will be passed on to the CICS Dean.<br>
                <b>Step 11:</b> See Step 10.<br>
                <b>Step 10:</b> If your request has been <i>declined</i>, an email will be sent to you that states the reason of the declining and you must submit another request that fulfills the reason if you wish to continue with your concerns.<br>
                If your request has been <i>accepted</i>, an email will be sent to you and your request will be passed on to the CICS Registrar.<br>
                <b>Step 12:</b> See Step 10.<br>
                <b>Step 13:</b> Once the Registrar has evaluated your request, an email will be sent to you stating that the transaction is complete.
            </p>
            </div>
            
        </div>
        <h3 style='margin-top: 50px; '>CICS E-Services</h3>
    Student Consultation || Student Appeal on Course Grade || Course Crediting
    <br><br>
    </div>

</body>
</html>