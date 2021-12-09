<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
</head>
<body>
  <center>
    <h4>
      UNIVERSITY OF SANTO TOMAS
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
      <td><b>Student Number:</b>{{ $studentDetails->student_id }}</td>
      
      
    </tr>
    <tr>
      <td><b>Student Name:</b>{{ $studentDetails->fname }} {{ $studentDetails->lname }}</td>
      <td width="50">&nbsp;</td>
      <td><b>New Program to Enroll:</b>{{ $newCourse->text }}</td>
    </tr>
  
    <tr>
      <td><b>Institute/College coming from:</b>{{ $creditDetails->institute }}</td>
      <td width="50">&nbsp;</td>
      <td><b>Original Program Enrolled:</b>{{ $currentCourse->text }}</td>
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
          @elseif($subject->status == 5)
            <span class="label label-danger">Rejected</span><br>
            {{ $subject->remarks }}
          @else
            <span class="label label-success">Approved</span>
          @endif
        </td>
        <td>
          @if($subject->status != 0 && $subject->status != 5)
            <img src="{{ public_path(str_replace('public','storage',$chairperson_signature_path)) }}" width="10%"><br>
            {{ $chairperson_fname }} {{ $chairperson_lname }}
          @endif
        </td>
      </tr>
    @endforeach
  </table>
  
  <br>
  <table>    
    <tr>
      <td>Endorsed by:</td>
      <td width="100">&nbsp;</td>
      <td>Noted by:</td>
    </tr>
    <tr>
      <td>
        @if($creditDetails->status >= 3 && $creditDetails->status != 5)
          <img src="{{ public_path(str_replace('public','storage',$director_signature_path)) }}" width="25%"/>
          <br>
          {{ $director_fname }} {{ $director_lname }}
        @endif
      </td>
      <td width="100">&nbsp;</td>
      <td>
        @if($creditDetails->status >= 3 && $creditDetails->status != 5)
          <img src="{{ public_path(str_replace('public','storage',$registrar_signature_path)) }}" width="25%"/>
          <br>
          {{ $registrar_fname }} {{ $registrar_lname }}
        @endif
      </td>
    </tr>
    <tr>
      <td width="200"><hr></td>
      <td>&nbsp;</td>
      <td width="200"><hr></td>
    </tr>
    <tr>
      <td>Dean</td>
      <td width="100">&nbsp;</td>
      <td>Registrar</td>
    </tr>
    <tr>
      <td></td>
      <td width="100"></td>
      <td style="text-align:right">UST:SO33-00FO62a</td>
    </tr>
  </table>
</body>
</html>
