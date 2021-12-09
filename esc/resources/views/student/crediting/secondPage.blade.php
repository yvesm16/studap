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
    <i>(to be accomplished by the transferees/shifters)</i>
  </div>
</div>
<div class="row" style="margin-top: 1%">
  <div class="col-md-2" style="text-align: left">
    <label>Student Number</label>
  </div>
  <div class="col-md-4">
    <input type="text" class="form-control" value="{{ $student_id }}" disabled>
  </div>
</div>
<div class="row" style="margin-top: 1%">
  <div class="col-md-2" style="text-align: left">
    <label>Student Name</label>
  </div>
  <div class="col-md-4">
    <input type="text" class="form-control" value="{{ $fname }} {{ $lname }}" disabled>
  </div>
  <div class="col-md-2" style="text-align: left">
    <label>New Program<br>to Enroll</label>
  </div>
  <div class="col-md-4">
    <input type="text" class="form-control" id="new_program" name="new_program" disabled>
  </div>
</div>
<div class="row" style="margin-top: 1%">
  <div class="col-md-2" style="text-align: left">
    <label>Institute/College</label><br>coming from
  </div>
  <div class="col-md-4">
    <input type="text" class="form-control" id="institute" name="institute" required>
  </div>
  <div class="col-md-2" style="text-align: left">
    <label>Original Program<br>Enrolled</label>
  </div>
  <div class="col-md-4">
    <input type="text" class="form-control" value="{{ $course }}" disabled>
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
            Remarks Approval/Disapproval
          </th>
          <th style="text-align: center">
            Signature over Printed Name<br>
            of Program Chair/Coordinator
          </th>
          <th style="text-align: center">
            Done
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
          <th></th>
        </tr>
        <tr>
          <td><input class="form-control" type="text" name="course_abbr[]" required></td>
          <td><input class="form-control" type="text" name="course_title[]" required></td>
          <td><input class="form-control" type="text" name="equivalent_course_abbr[]" required></td>
          <td><input class="form-control" type="text" name="equivalent_course_title[]" required></td>
          <td>&nbsp</td>
          <td>&nbsp</td>
          <td>&nbsp</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-12" style="text-align: right">
    <button type="button" class="btn btn-default addRow">Add Row</button>
    <button type="submit" class="btn btn-primary">Submit Form</button>
  </div>
</div>
</form>

<script>
  $(document).ready(function(){
    $('.addRow').on('click',function(){
      $("#tableBody").append(
        '<tr>'+
          '<td><input class="form-control" type="text" name="course_abbr[]" id="course_abbr" required></td>'+
          '<td><input class="form-control" type="text" name="course_title[]" id="course_title" required></td>'+
          '<td><input class="form-control" type="text" name="equivalent_course_abbr[]" required></td>'+
          '<td><input class="form-control" type="text" name="equivalent_course_title[]" required></td>'+
          '<td><button type="button" class="btn btn-warning removeRow">Remove Row</button></td>'+
          '<td>&nbsp</td>'+
          '<td>&nbsp</td>'+
        '</tr>'
       );
    });

    $('#formTable').delegate('.removeRow','click', function (){
      $(this).closest('tr').remove();
    });

  });
</script>
