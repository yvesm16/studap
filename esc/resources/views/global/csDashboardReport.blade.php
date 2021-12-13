<!DOCTYPE html>
<html lang="en">
<head>
    <title>CICS E - Services</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboardDownloadIndex.css'); }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container indexMargiN home">
    <div id="outer-box-dashboard" class='row'>
        
    <p>
    <img src="{{ URL::asset('img/iicslogo.png')}}" width="100px" style="margin-top: 1%">
    <h1>CICS E-Services</h1>
    <h2> Computer Science Department Dashboard</h2>
    <h3> for Student Consultation</h3>
  </p><br><br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <div class='container'>
        <div class='row'>
            <div class='col-sm-12 col-md-12 col-lg-12' style='align-content:center'>
                <p> The Number of backlog of service request</p>
                <canvas id="backlog" class="imgdash" height='80px'>

            </div>
            <div class='col-sm-12 col-md-12 col-lg-12' style='align-content:center'>
                <p id="th-dashboard2">Number of Declined Request</p>
                <canvas id="decline" class="imgdash" height='80px'>
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
                        labels: ["Number of Accepted Consultation Request"],
                        datasets: [{
                            label: '',
                            data: [{{$accepted}}],
                            backgroundColor: [  
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                            ],
                            borderColor: [
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
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

                var ctx = document.getElementById("backlog").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            'Jose Seno',
                        'Donata Acula',
                        'Jonathan Cabero',
                        "Perla Cosme",
                        'Lawrence Decamora',
                        'Cherry Rose Estabillo',
                        'Charmaine Ponay',
                        'Janette Sideno',
                        'Edwin Torralba'
                        ],
                        datasets: [{
                            label: '',
                            data: [
                                {{$seno2}}, 
                                {{$acula2}},
                                {{$cabero2}},
                                {{$cosme2}},
                                {{$decamora2}},
                                {{$estabillo2}},
                                {{$ponay2}},
                                {{$sideno2}},
                                {{$torralba2}}
                            ],
                            backgroundColor: [
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                            ],
                            borderColor: [
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
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
                        labels: ["Average (minutes)"],
                        datasets: [{
                            label: '',
                            data: [{{$elapsed}}],
                            backgroundColor: [
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                            ],
                            borderColor: [
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
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
                        labels: [
                        'Jose Seno',
                        'Donata Acula',
                        'Jonathan Cabero',
                        "Perla Cosme",
                        'Lawrence Decamora',
                        'Cherry Rose Estabillo',
                        'Charmaine Ponay',
                        'Janette Sideno',
                        'Edwin Torralba'
                        ],
                        datasets: [{
                            label: '',
                            data: [
                                {{$seno}}, 
                                {{$acula}},
                                {{$cabero}},
                                {{$cosme}},
                                {{$decamora}},
                                {{$estabillo}},
                                {{$ponay}},
                                {{$sideno}},
                                {{$torralba}}
                            ],
                            backgroundColor: [
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                'rgba(167, 6, 11, 0.2)',
                                
                            ],
                            borderColor: [
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
                                'rgba(167, 6, 11, 1)',
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