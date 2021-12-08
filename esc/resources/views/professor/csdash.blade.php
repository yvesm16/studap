<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CICS e - Services</title>   
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,600;0,700;1,800&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
    @include('professor.nav')

<div class="container indexMargiN home">
    <div id="outer-box-dashboard" class='row'>
        {{-- <table id="dashboard-table"> --}}
            {{-- <tr id="tr-dashboard"> --}}
        


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <div class='container'>
        <div class='row'>
            {{-- <div class='col-sm-12 col-md-6 col-lg-6' style='align-content:center'>
                <p>The Average level of satisfaction from the request</p>
                <canvas id="rate" class="imgdash" >
            </div> --}}
            {{-- <p>{{$getName}}</p> --}}
            <div class='col-sm-12 col-md-12 col-lg-12' style='align-content:center'>
                <p> The Number of backlog of service request</p>
                <canvas id="backlog" class="imgdash" >

            </div>
            <div class='col-sm-12 col-md-12 col-lg-12' style='align-content:center'>
                <p id="th-dashboard2">Number of Declined Request</p>
                <canvas id="decline" class="imgdash" >
            </div>
            <div  class='col-sm-12 col-md-6 col-lg-6' style='align-content:center'>
                <p id="th-dashboard2">Average of Elapsed Time</p>  
                <canvas id="ETime" class="imgdash" >
            </div>
            {{-- <div class='col-sm-12 col-md-6 col-lg-6' style='align-content:center'>
                <p id="th-dashboard2">The Average Time the Request is Completed</p> 
                <canvas id="completed" class="imgdash" >
            </div> --}}
            <div class='col-sm-12 col-md-12 col-lg-6' style='align-content:center'>
                <p id="th-dashboard2">Number of Accepted Consultation Appointment</p>
                <canvas id="acceptReq" class="imgdash" >
            </div>
            

        </div>
    </div>
</div>          
<!-- The Modal -->
<div id="dashmodal" class="modaldash">

    <!-- The Close Button -->
    <span class="closedash" onclick="document.getElementById('dashmodal').style.display='none'">&times;</span>
  
    <!-- Modal Content (The Image) -->
    <img class="modaldash-content" id="imgdashcontent">
  
    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
  </div>
  <script>
  // Get the modal
  var modal = document.getElementById('imgdash');
  
  // Get the image and insert it inside the modal - use its "alt" text as a caption
  var img = $('.imgdash');
  var modalImg = $("#imgdashcontent");
  var captionText = document.getElementById("caption");
  $('.imgdash').click(function(){
      modal.style.display = "block";
      var newSrc = this.src;
      modalImg.attr('src', newSrc);
      captionText.innerHTML = this.alt;
  });
  
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("closedash")[0];
  
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }


                var ctx = document.getElementById("acceptReq").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Average Number of Accepted Consultation Request"],
                        datasets: [{
                            label: '',
                            data: [4],
                            backgroundColor: [
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)'
                            ],
                            borderColor: [
                                'rgba(186, 166, 175, 1)',
                                'rgba(160, 89, 97, 1)',
                                'rgba(171, 49, 60, 1)',
                                'rgba(180, 50, 60, 1)',
                                'rgba(167, 6, 11, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            responsive: true,
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    precision:0

                                }
                            }]
                        }
                    }
                });

                // var ctx = document.getElementById("completed").getContext('2d');
                // var myChart = new Chart(ctx, {
                //     type: 'bar',
                //     data: {
                //         labels: ["Consultation (minutes)",  "Student Appeal (minutes)" ,  "Course Crediting (minutes)"],
                //         datasets: [{
                //             label: '',
                //             data: [1,2,3],
                //             backgroundColor: [
                //                 'rgba(167, 6, 11, 0.2)',
                //                 'rgba(167, 6, 11, 0.2)',
                //                 'rgba(167, 6, 11, 0.2)',
                //                 'rgba(167, 6, 11, 0.2)',
                //                 'rgba(167, 6, 11, 0.2)'
                //             ],
                //             borderColor: [
                //                 'rgba(186, 166, 175, 1)',
                //                 'rgba(160, 89, 97, 1)',
                //                 'rgba(171, 49, 60, 1)',
                //                 'rgba(180, 50, 60, 1)',
                //                 'rgba(167, 6, 11, 1)'
                //             ],
                //             borderWidth: 1
                //         }]
                //     },
                //     options: {
                //         scales: {
                //             responsive: true,
                //             yAxes: [{
                //                 ticks: {
                //                     beginAtZero:true,
                //                     precision:0

                //                 }
                //             }]
                //         }
                //     }
                // });


                var ctx = document.getElementById("backlog").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Consultation", "Student Appeal", "Course Crediting"],
                        datasets: [{
                            label: '',
                            data: [1,2,3],
                            backgroundColor: [
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)'
                            ],
                            borderColor: [
                                'rgba(186, 166, 175, 1)',
                                'rgba(160, 89, 97, 1)',
                                'rgba(171, 49, 60, 1)',
                                'rgba(180, 50, 60, 1)',
                                'rgba(167, 6, 11, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            responsive: true,
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    precision:0

                                }
                            }]
                        }
                    }
                });

                var ctx = document.getElementById("ETime").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Consultation (minutes) ", "Student Appeal (minutes)", "Course Crediting (minutes)"],
                        datasets: [{
                            label: '',
                            data: [1,2,3],
                            backgroundColor: [
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)'
                            ],
                            borderColor: [
                                'rgba(186, 166, 175, 1)',
                                'rgba(160, 89, 97, 1)',
                                'rgba(171, 49, 60, 1)',
                                'rgba(180, 50, 60, 1)',
                                'rgba(167, 6, 11, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            responsive: true,
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    precision:0

                                }
                            }]
                        }
                    }
                });
                var ctx = document.getElementById("decline").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Consultation", "Course Crediting"],
                        datasets: [{
                            label: '',
                            data: [1,2],
                            backgroundColor: [
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)'
                            ],
                            borderColor: [
                                'rgba(186, 166, 175, 1)',
                                'rgba(160, 89, 97, 1)',
                                'rgba(171, 49, 60, 1)',
                                'rgba(180, 50, 60, 1)',
                                'rgba(167, 6, 11, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            responsive: true,
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    precision:0

                                }
                            }]
                        }
                    }
                });
  </script>
</div>
</body>
</html>