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
    <h4>Request for Student Appeal on Course Grade</h4>
  </p>
  <p>
    <form action="{{ URL::to('student/postAppeal') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div>
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Email</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="text" class="form-control" value="{{ $email }}" readonly>
          </div>
        </div>

        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Name of Student</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="text" class="form-control" value="{{ $fname }} {{ $lname }}" readonly>
          </div>
        </div>

        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Student Number</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="text" class="form-control" value="{{ $student_id }}" readonly>
          </div>
        </div>
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Program Affiliation</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <select name="course_id" id="course_id" class="form-control">
              @foreach($allCourse as $course)
                  <option value="{{ $course->id }}">{{ $course->text }}</option>
              @endforeach
              </select>
          </div>
        </div>
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Section</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="text" class="form-control" name="section" id="section" required>
          </div>
        </div>
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Specific Concern/s</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="text" class="form-control" name="concerns" id="concerns" required>
          </div>
        </div>
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
            <label>Attach Documents</label><br>
            (If multiple attachments, compile in one pdf file)
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="file" name="fileUpload" class="form-control-file" id="fileUpload">
          </div>
        </div>

        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">          
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" name="fileTypeUploaded1" id="fileTypeUploaded1">
              <label class="form-check-label" for="fileTypeUploaded1">
                Letter of Student Appeal
              </label>
            </div>
          </div>     

          <div class="col-md-6" style="text-align: left">
          </div>
        </div>   
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">          
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" name="fileTypeUploaded2" id="fileTypeUploaded2">
              <label class="form-check-label" for="fileTypeUploaded2">
                Copy of Grades in Blackboard
              </label>
            </div>
          </div>    

          <div class="col-md-6" style="text-align: left">
          </div>   
        </div> 
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">          
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="others">
                <label class="form-check-label" for="others">
                  Others
                </label>
            </div>
          </div>

          <div class="col-md-6 others_input_div" style="text-align: left; display:none">
            <input type="text" class="form-control" name="others" id="others_input">
          </div>
        </div>
        
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Professor Email</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="email" class="form-control" name="prof_email" id="prof_email" required>
          </div>
        </div>

        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          {{-- <div class="col-md-6" style="text-align: left">
              <label>Active Contact Number</label>
          </div> --}}

          {{-- <div class="col-md-6" style="text-align: left">
              <input type="number" class="form-control" name="contact_number" id="contact_number" maxlength="11" minlength='11' required>
          </div> --}}
        </div>
        <div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
          <div class="col-md-6" style="text-align: left">
              <label>Active Alternative Email Address</label>
          </div>

          <div class="col-md-6" style="text-align: left">
              <input type="email" class="form-control" name="email" id="email" required>
          </div>
        </div>

        <div class="col-md-12" style="text-align: right; margin-top: 10px;margin-bottom: 10px">
          <button type="submit" class="btn btn-primary submit-appeal">Submit Form</button>
        </div>
      </div>
      @if (session('success'))
        <div class="alert alert-success" style="margin-top: 7%">
          <strong>Success!</strong> Appeal request was successfully submitted!
        </div>
      @endif
    </form>
  </p>
</div>

</body>
</html>

<script>
  $(document).ready(function(){
    $('#fileTypeUploaded1').on('change',function(){
      if(this.checked) {
        $('#fileTypeUploaded1').val('Letter of Student Appeal');
      } else {
        $('#fileTypeUploaded1').val('');
      }
    });
    $('#fileTypeUploaded2').on('change',function(){
      if(this.checked) {
        $('#fileTypeUploaded2').val('Copy of Grades in blackboard');
      } else {
        $('#fileTypeUploaded2').val('');
      }
    });
    $('#others').on('change',function(){
      if(this.checked) {
        $('.others_input_div').css('display','block')
      } else {
        $('.others_input_div').css('display','none')
        $('#others_input').val('');
      }
    });

    $('.submit-appeal').on('click',function(){
      if($('#others').is(":checked")){
        if($('#others_input').val() == ''){
          alert('Please fill out all fields!');
          return false;
        }
      }
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
    });
  });
</script>
