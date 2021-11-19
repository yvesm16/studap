<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
</head>
<body>
  <center>
    <div>  
      <h4>
        UNIVERSITY OF SANTO TOMAS<br>Institute of Information Computing Sciences
      </h4>
      <label>
        Generated On: {{ $generated_on }}
      </label>
      <br>
      <label>
        Generated By: {{ $fname }} {{ $lname }}
      </label>
      <br><br>
      <h4>
        Request Fulfilled List for Consultation
      </h4>
    </div>
  </center>
  <br>
  <table style="font-size: 12px; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">
    <tr>
      <th style="text-align: center">
        ID
      </th>
      <th style="text-align: center">
        Student Name
      </th>
      <th style="text-align: center">
        Email
      </th>
      <th style="text-align: center">
        Date
      </th>
      <th style="text-align: center">
        Start
      </th>
      <th style="text-align: center">
        End
      </th>
      <th style="text-align: center">
        Concern
      </th>
    </tr>
    @foreach($scheduleDetails as $schedule_detail)
      <tr style="text-align: center">
        <td>{{ $schedule_detail->id }}</td>
        <td>{{ $schedule_detail->fname }} {{ $schedule_detail->lname }}</td>
        <td>{{ $schedule_detail->email }}</td>
        <td>{{ date("M d, Y", strtotime('$schedule_detail->created_at')) }}</td>
        <td>{{ date('h:i a', strtotime($schedule_detail->start_time)) }}</td>
        <td>{{ date('h:i a', strtotime($schedule_detail->end_time)) }}</td>
        <td>{{ $schedule_detail->concern_details }}</td>
      </tr>
    @endforeach
  </table>
</body>
</html>