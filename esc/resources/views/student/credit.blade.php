<!DOCTYPE html>
<html lang="en">
<head>
  <title>CICS E - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
  <!-- <script src="{{ URL::asset('js/student/index.js'); }}"></script> -->
</head>
<body>

@include('student.nav')

<div class="container indexMargin home">
  <p>
    <h4>Request for Course Crediting</h4>
  </p>
  <p>
    <form action="{{ URL::to('student/postCredit') }}" method="post" enctype="multipart/form-data">
      @csrf
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Initial Information</a></li>
        <li><a data-toggle="tab" href="#menu1" id="nextPage">Subject Information</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          @include('student/crediting/firstPage')
        </div>
        <div id="menu1" class="tab-pane fade">
          @include('student/crediting/secondPage')
        </div>
      </div>
      @if (session('success'))
        <div class="alert alert-success" style="margin-top: 1%">
          <strong>Success!</strong> Credit request was successfully submitted!
        </div>
      @endif
  </p>
</div>

</body>
</html>

<script>
  $(document).ready(function(){
    $('#nextPage').on('click',function(){
      if($('#section').val() == ''){
        alert('Please fill out all fields!');
        return false;
      }
      if($('#concerns').val() == ''){
        alert('Please fill out all fields!');
        return false;
      }
      if(document.getElementById("fileUpload").files.length == 0){
        alert('Please fill out all fields!');
        return false;
      }
      if($('#contact_number').val() == ''){
        alert('Please fill out all fields!');
        return false;
      }
      if($('#email').val() == ''){
        alert('Please fill out all fields!');
        return false;
      }

      if(document.getElementById("fileUpload").files[0].size > 2097152){
        alert('File should be less than 2MB');
        return false;
      }

      if(document.getElementById("fileUpload").files[0].type != 'application/pdf'){
        alert('PDF file only');
        return false;
      }

      $('#new_program').val($("#course_id option:selected").text());
    });
  });
</script>
