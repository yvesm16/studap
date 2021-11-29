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
    <label>Attach Document</label><br>
    (If multiple attachments, compile in one pdf file)
  </div>
  <div class="col-md-6" style="text-align: left">
    <input type="file" name="fileUpload" class="form-control-file" id="fileUpload">
  </div>
</div>
<div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
  {{-- <div class="col-md-6" style="text-align: left">
    <label>Active Contact Number</label>
  </div> --}}
  {{-- <div class="col-md-6" style="text-align: left">
    <input type="number" class="form-control" name="contact_number" id="contact_number"  maxlength="11" minlength='11' required>
  </div> --}}
</div>
<div class="row" style="margin-top: 1%; margin-left: 15%; margin-right: 15%">
  <div class="col-md-6" style="text-align: left">
    <label>Active Alternative Email Address</label>
  </div>
  <div class="col-md-6" style="text-align: left">
    <input type="text" class="form-control" name="email" id="email" required>
  </div>
</div>
