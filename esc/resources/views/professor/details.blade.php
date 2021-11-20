<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
  <!-- <script src="{{ URL::asset('js/student/index.js'); }}"></script> -->
</head>
<body>

@include('professor.nav')

<div class="container indexMargin home">
  <input type="hidden" value="{{ $creditDetails->slug }}" name="slug" id="slug">
  <div class="row">
    <div class="col-md-12" style="text-align: center">
      <h4>
        UNIVERSITY OF SANTO TOMAS
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="text-align: center">
      <label>
        España Boulevard, Sampaloc, Manila
      </label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="text-align: center">
      <label>
        OFFICE OF THE REGISTRAR
      </label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="text-align: center">
      <h4>
        APPROVAL SHEET FOR COURSES TO BE CREDITED
      </h4>
      <i>(to be accomplish by the transferees/shifters)</i>
    </div>
  </div>
  <div class="row" style="margin-top: 1%">
    <div class="col-md-2" style="text-align: left">
      <label>Student Number</label>
    </div>
    <div class="col-md-4">
      <input type="text" class="form-control" value="{{ $studentDetails->student_id }}" disabled>
    </div>
  </div>
  <div class="row" style="margin-top: 1%">
    <div class="col-md-2" style="text-align: left">
      <label>Student Name</label>
    </div>
    <div class="col-md-4">
      <input type="text" class="form-control" value="{{ $studentDetails->fname }} {{ $studentDetails->lname }}" disabled>
    </div>
    <div class="col-md-2" style="text-align: left">
      <label>New Program<br>to Enroll</label>
    </div>
    <div class="col-md-4">
      <input type="text" class="form-control" id="new_program" value="{{ $newCourse->text }}" name="new_program" disabled>
    </div>
  </div>
  <div class="row" style="margin-top: 1%">
    <div class="col-md-2" style="text-align: left">
      <label>Institute/College</label><br>coming from
    </div>
    <div class="col-md-4">
      <input type="text" class="form-control" id="institute" name="institute" value="{{ $creditDetails->institute }}" required disabled>
    </div>
    <div class="col-md-2" style="text-align: left">
      <label>Original Program<br>Enrolled</label>
    </div>
    <div class="col-md-4">
      <input type="text" class="form-control" value="{{ $currentCourse->text }}" disabled>
    </div>
  </div>
  <div class="row" style="margin-top: 1%">
    <div class="col-md-12">
      <table class="table table-striped" id="formTable">
        <thead>
          <tr>
            <th style="text-align: center" colspan="2">
              Course(s) Taken from other<br>
              Program/College/University
            </th>
            <th style="text-align: center" colspan="2">
              Equivalent Course(s) in the New<br>
              Program to be enrolled
            </th>
            <th style="text-align: center">
              Program Chair/Coordinator's<br>
              Remarks Approval / Disapproval
            </th>
            <th style="text-align: center">
              Signature over Printed<br>
              Name of Program Chair/Coordinator
            </th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <tr>
            <th style="text-align: center">
              Course Abbreviation
            </th>
            <th style="text-align: center">
              Course Title
            </th>
            <th style="text-align: center">
              Course Abbreviation
            </th>
            <th style="text-align: center">
              Course Title
            </th>
            <th></th>
            <th></th>
          </tr>
          @foreach($allSubjects as $subject)
            <tr>
              <td><input class="form-control" type="text" disabled value="{{ $subject->course_abbr }}"></td>
              <td><input class="form-control" type="text" disabled value="{{ $subject->course_title }}"></td>
              <td><input class="form-control" type="text" disabled value="{{ $subject->equivalent_course_abbr }}"></td>
              <td><input class="form-control" type="text" disabled value="{{ $subject->equivalent_course_title }}"></td>
              <td>
                @if($subject->status == 0)
                  <button class="btn btn-primary approveSubject" data-id="{{ $subject->id }}">
                    Approve
                  </button>
                  <button class="btn btn-danger rejectSubject" data-id="{{ $subject->id }}">
                    Decline
                  </button>
                @elseif($subject->status == 5)
                  <span class="label label-danger">Rejected</span><br>
                  {{ $subject->remarks }}
                @else
                  <span class="label label-success">Approved</span>
                @endif
              </td>
              
              <td>
                <div id="signatureDiv">
                  @if($subject->status == 0)
                    &nbsp
                  @else
                    <img src="{{ url(str_replace('public','storage',$signature->path)) }}" width="15%"/>
                      <br>
                      {{ $fname }} {{ $lname }}
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="col-md-12" style="text-align: right; margin-bottom: 1%">
      <!-- <a href="{{ url(str_replace('public','storage',$attached_file_path)) }}"></a> -->
      <button type="button" class="btn btn-success viewDocument">View Document</button>
      <button type="button" class="btn btn-primary completeForm" disabled>Complete Form</button>
    </div>
  </div>
</div>

</body>
</html>

<script>
  $(document).ready(function() {
    var BASE_URL = $("#hdnBaseUrl").val();

    $(window).on('load', function() {
      $.ajax({
          url: BASE_URL + '/credit/getSubjectCreditStatus',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {
            slug : $('#slug').val(),
            status : 0
          },
          dataType    :'json',
          success: function (data) {
            // $('.completeForm').prop('disabled',true);
            // $('.completeForm').prop('disabled',false);
            $('.completeForm').prop('disabled',data.result);
          }
      });
    });

    $('.viewDocument').on('click',function(){
      $('#viewDocumentModal').modal('toggle');
      $("#objectViewDocumentPDF").attr("data", "{{ url(str_replace('public','storage',$attached_file_path)) }}");
      $("#embedViewDocumentPDF").attr("src", "{{ url(str_replace('public','storage',$attached_file_path)) }}");
      // $("#viewDocumentPDF").attr("data", "{{ url(str_replace('public','storage',$attached_file_path)) }}");
    });

    $('#formTable').delegate('.approveSubject','click', function (){
      if (confirm('Are you sure you want to approve this subject?')) {
        $.ajax({
            url: BASE_URL + '/credit/updateDetails',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: {
                slug : $('#slug').val(),
                subject_id : $(this).data('id'),
                status : 1
            },
            dataType    :'json',
            success: function (data) {
              if(data.result == true){
                window.location.href = BASE_URL + '/professor/crediting/details/' + $('#slug').val();
              }
            }
        });
      }
    });

    $('#formTable').delegate('.rejectSubject','click', function (){
      if (confirm('Are you sure you want to reject this subject?')) {
        var remarks = prompt("Please provide details", "");
        $.ajax({
            url: BASE_URL + '/credit/updateDetails',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: {
                subject_id : $(this).data('id'),
                remarks: remarks,
                status : 5
            },
            dataType    :'json',
            success: function (data) {
              if(data.result == true){
                window.location.href = BASE_URL + '/professor/crediting/details/' + $('#slug').val();
              }
            }
        });
      }
    });

    $('.completeForm').on('click',function(){
      if (confirm('Are you sure you want to complete this request?')) {
        $.ajax({
            url: BASE_URL + '/credit/updateCreditStatus',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: {
                slug : $('#slug').val(),
                status : 1
            },
            dataType    :'json',
            success: function (data) {
              if(data.result == true){
                window.location.href = BASE_URL + '/professor/crediting/0';
              }
            }
        });
      }
    });
  });
</script>

@include('global.viewDocumentModal')