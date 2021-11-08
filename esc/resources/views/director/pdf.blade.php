<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
</head>
<body>
  <center>
    <h4>
      UNIVERSITY OF SANTO THOMAS
    </h4>
    <label>
      España Boulevard, Sampaloc, Manila<br>
    </label>
    <label>
      OFFICE OF THE REGISTRAR
    </label>
    <h4>
      APPROVAL SHEET FOR COURSES TO BE CREDITED
    </h4>
    <i>(to be accomplish by the transferees/shifters)</i>
  </center>
  <br>
  <table>
    <tr>
      <td><b>Student Number:</b></td>
      <td width="50">&nbsp;</td>
      <td>{{ $studentDetails->student_id }}</td>
    </tr>
    <tr>
      <td><b>Student Name:</b></td>
      <td width="50">&nbsp;</td>
      <td>{{ $studentDetails->fname }} {{ $studentDetails->lname }}</td>
    </tr>
    <tr>
      <td><b>New Program to Enroll:</b></td>
      <td width="50">&nbsp;</td>
      <td>{{ $newCourse->text }}</td>
    </tr>
    <tr>
      <td><b>Institute/College coming from:</b></td>
      <td width="50">&nbsp;</td>
      <td>{{ $creditDetails->institute }}</td>
    </tr>
    <tr>
      <td><b>Original Program Enrolled:</b></td>
      <td width="50">&nbsp;</td>
      <td>{{ $currentCourse->text }}</td>
    </tr>
  </table>
  <br>
  <table style="font-size: 12px; border-collapse: collapse" border="1">
    <tr>
      <th style="text-align: center" colspan="2">
        Course(s) Taken from other Program / College / University
      </th>
      <th style="text-align: center" colspan="2">
        Equivalent Course(s) in the New
        Program to be enrolled
      </th>
      <th style="text-align: center" rowspan="2">
        Program Chair/Coordinator's
        Remarks Approval / Disapproval
      </th>
      <th style="text-align: center" rowspan="2">
        Signature over Printed
        Name of Program Chair/Coordinator
      </th>
    </tr>
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
    </tr>
    @foreach($allSubjects as $subject)
      <tr style="text-align: center">
        <td>{{ $subject->course_abbr }}</td>
        <td>{{ $subject->course_title }}</td>
        <td>{{ $subject->equivalent_course_abbr }}</td>
        <td>{{ $subject->equivalent_course_title }}</td>
        <td>
          @if($subject->status == 0)
            <button class="btn btn-primary approveSubject" data-id="{{ $subject->id }}">
              Approve
            </button>
            <button class="btn btn-danger rejectSubject" data-id="{{ $subject->id }}">
              Decline
            </button>
          @elseif($subject->status == 1)
            <span class="label label-success">Approved</span>
          @else
            <span class="label label-danger">Rejected</span><br>
            {{ $subject->remarks }}
          @endif
        </td>
        <td>
          <img src="{{ public_path(str_replace('public','storage',$subject->path)) }}" width="10%"><br>
          <!-- {{ URL::to('/') }}/{{ str_replace('public','storage',$subject->path) }}<br> -->
          {{ $subject->fname }} {{ $subject->lname }}
        </td>
      </tr>
    @endforeach
  </table>
</body>
</html>
