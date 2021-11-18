<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IICS E - Services</title>   
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,600;0,700;1,800&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>


<div class="container indexMargin home">
    <div id="outer-box-dashboard">
        <table id="dashboard-table">
            <tr id="tr-dashboard">
                <th id="th-dashboard">Average level of satisfaction from the request</th>
                <th id="th-dashboard">Weekly - Number of backlog of service request</th>
                <th id="th-dashboard">Weekly - Average of Elapsed Time</th>
                <th id="th-dashboard">Weekly - Average Completed Request</th>
                <th id="th-dashboard">Weekly - Number of Accepted Consultation</th>
            </tr>
     
            <tr id="tr-dashboard">
                <td id="td-dashboard">{{$ave}}</td>
                <td id="td-dashboard">12</td>
                <td id="td-dashboard">12</td>
                <td id="td-dashboard">12</td>
                <td id="td-dashboard">12</td>
            </tr>
        </table>
            <hr id="hr-dashboard">


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <table id="dashboard-table2">
                <tr id="tr-dashboard2">
                    <th id="th-dashboard2">The Average level of satisfaction from the request</th>
                    <th id="th-dashboard2"> The Number of backlog of service request</th>
                </tr>
         
                <tr id="tr-dashboard2">
                    <td id="td-dashboard2"><canvas id="rate" class="imgdash" style="width: 350px; height: 150px;"></canvas>
                    </td>
                    <td id="td-dashboard2"><img class="imgdash" src="../images/Screenshot 2021-07-20 171828.png" style="width: 350px; height: 150px;"></td>
                </tr>
            </table>

            <table id="dashboard-table2">
                <tr id="tr-dashboard2">
                    <th id="th-dashboard2">Average of Elapsed Timet</th>
                    <th id="th-dashboard2">The Average Time the Request is Completed</th>
                </tr>
         
                <tr id="tr-dashboard2">
                    <td id="td-dashboard2"><img class="imgdash" src="../images/Screenshot 2021-07-20 171828.png" style="width: 350px; height: 150px;"></td>
                    <td id="td-dashboard2"><img class="imgdash" src="../images/Screenshot 2021-07-20 171828.png" style="width: 350px; height: 150px;"></td>
                </tr>
            </table>

            <table id="dashboard-table2">
                <tr id="tr-dashboard2">
                    <th id="th-dashboard2">Number of Accepted Consultation Appointment</th>
                </tr>
         
                <tr id="tr-dashboard2">
                    <td id="td-dashboard2"><canvas id="acceptReq" class="imgdash" style="width: 350px; height: 150px;"></canvas>
                </tr>
            </table>
            

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

  var ctx = document.getElementById("rate").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["One Star", "Two Star", "Three Star", "Four Star", "Five Star"],
                        datasets: [{
                            label: '',
                            data: [{{$oc}}, {{$tc}}, {{$thc}}, {{$fc}}, {{$fic}}],
                            backgroundColor: [
                                'rgba(186, 166, 175, 0.2)',
                                'rgba(160, 89, 97, 0.2)',
                                'rgba(171, 49, 60, 0.2)',
                                'rgba(180, 50, 60, 0.2)',
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

                var ctx = document.getElementById("acceptReq").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Average Number of Accepted Consultation Request"],
                        datasets: [{
                            label: '',
                            data: [{{$accptReq}}],
                            backgroundColor: [
                                'rgba(186, 166, 175, 0.2)',
                                'rgba(160, 89, 97, 0.2)',
                                'rgba(171, 49, 60, 0.2)',
                                'rgba(180, 50, 60, 0.2)',
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