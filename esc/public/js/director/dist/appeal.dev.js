"use strict";

$(document).ready(function () {
  var BASE_URL = $("#hdnBaseUrl").val();
  var pathname = window.location.pathname;

  if (pathname.split('/')[3] == 'completed') {
    $('.downloadCompletedListReportDiv').css('display', 'block');
  } else {
    $('.downloadCompletedListReportDiv').css('display', 'none');
  }

  $('.downloadCompletedListReportDiv').click(function () {
    window.location.href = BASE_URL + '/student_appeal/details/completed_pdf';
  });
  $(function () {
    $('#studentAppealTable').dataTable({
      "scrollCollapse": true,
      "sDom": '<"top"f>rt<"bottom"ip><"clear">',
      "bServerSide": true,
      "pagingType": "full_numbers",
      "iDisplayLength": 7,
      "sAjaxSource": BASE_URL + "/ajax?type=studentAppealList&status=" + pathname.split('/')[3],
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [1, 2, 3, 4, 5]
      }],
      "oLanguage": {
        "oPaginate": {
          "sPrevious": "<",
          // This is the link to the previous page
          "sNext": ">" // This is the link to the next page

        },
        "sSearch": "",
        "sSearchPlaceholder": "Search Records"
      }
    });
  });
  $('#studentAppealTable').delegate('.evaluate', 'click', function () {
    $.ajax({
      url: BASE_URL + '/director/getDirectorAppealDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appeal_slug: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          document.getElementById("transaction_number").textContent = data.transaction_number;
          document.getElementById("student_id").textContent = data.student_id;
          document.getElementById("student_name").textContent = data.student_name;
          document.getElementById("attached1").textContent = data.attached1;
          document.getElementById("attached2").textContent = data.attached2;
          document.getElementById("attached3").textContent = data.attached3;
          document.getElementById("prof_email_involve").textContent = data.prof_email;
          $('#date').val(data.date); // $('#start').val(data.start);
          // $('#end').val(data.end);

          $('#message').val(data.message);
          $('#appeal_id').val(data.transaction_number);
          $("#objectViewDocumentPDF").attr("data", data.attached_file_path);
          $("#embedViewDocumentPDF").attr("src", data.attached_file_path);

          if (data.status > 1) {
            $('#submitStudentAppealEval').css('display', 'none');
          }

          if (data.attached1) {
            document.getElementById("attached1").textContent = data.attached1;
            $('#attached1').css('display', 'block');
          } else {
            $('#attached1').css('display', 'none');
          }

          if (data.attached2) {
            document.getElementById("attached2").textContent = data.attached2;
            $('#attached2').css('display', 'block');
          } else {
            $('#attached2').css('display', 'none');
          }

          if (data.attached3) {
            document.getElementById("attached3").textContent = data.attached3;
            $('#attached3').css('display', 'block');
          } else {
            $('#attached3').css('display', 'none');
          }

          $('#studApEvaluationLevel1Modal').modal('toggle');
        }
      }
    });
  });
  $('#studentAppealTable').delegate('.evaluate2', 'click', function () {
    $.ajax({
      url: BASE_URL + '/director/getDirectorAppealDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appeal_slug: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          document.getElementById("transaction_number-2").textContent = data.transaction_number;
          document.getElementById("student_id-2").textContent = data.student_id;
          document.getElementById("student_name-2").textContent = data.student_name;
          document.getElementById("attached2-2").textContent = data.attached2;
          document.getElementById("attached3-2").textContent = data.attached3;
          $('#date-2').val(data.date); // $('#start-2').val(data.start);
          // $('#end-2').val(data.end);

          $('#prof_email-2').val(data.prof_email);
          $('#message-2').val(data.message);
          $('#appeal_id-2').val(data.transaction_number);
          $("#objectViewDocumentPDF-2").attr("data", data.attached_file_path);
          $("#embedViewDocumentPDF-2").attr("src", data.attached_file_path);

          if (data.status > 1) {
            $('#submitStudentAppealEval-2').css('display', 'none');
          }

          if (data.attached1) {
            document.getElementById("attached1-2").textContent = data.attached1;
            $('#attached1-2').css('display', 'block');
          } else {
            $('#attached1-2').css('display', 'none');
          }

          if (data.attached2) {
            document.getElementById("attached2-2").textContent = data.attached2;
            $('#attached2-2').css('display', 'block');
          } else {
            $('#attached2-2').css('display', 'none');
          }

          if (data.attached3) {
            document.getElementById("attached3-2").textContent = data.attached3;
            $('#attached3-2').css('display', 'block');
          } else {
            $('#attached3-2').css('display', 'none');
          }

          $('#studApEvaluationLevel2Modal').modal('toggle');
        }
      }
    });
  });
  $('#studentAppealTable').delegate('.evaluate3', 'click', function () {
    $.ajax({
      url: BASE_URL + '/director/getDirectorAppealDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appeal_slug: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          document.getElementById("transaction_number-3").textContent = data.transaction_number;
          document.getElementById("student_id-3").textContent = data.student_id;
          document.getElementById("student_name-3").textContent = data.student_name;
          document.getElementById("attached2-3").textContent = data.attached2;
          document.getElementById("attached3-3").textContent = data.attached3;
          $('#date-3').val(data.date); // $('#start-3').val(data.start);
          // $('#end-3').val(data.end);

          $('#prof_email-3').val(data.prof_email);
          $('#message-3').val(data.message);
          $('#appeal_id-3').val(data.transaction_number);
          $("#objectViewDocumentPDF-3").attr("data", data.attached_file_path);
          $("#embedViewDocumentPDF-3").attr("src", data.attached_file_path);

          if (data.status > 1) {
            $('#submitStudentAppealEval-3').css('display', 'none');
          }

          if (data.attached1) {
            document.getElementById("attached1-3").textContent = data.attached1;
            $('#attached1-3').css('display', 'block');
          } else {
            $('#attached1-3').css('display', 'none');
          }

          if (data.attached2) {
            document.getElementById("attached2-3").textContent = data.attached2;
            $('#attached2-3').css('display', 'block');
          } else {
            $('#attached2-3').css('display', 'none');
          }

          if (data.attached3) {
            document.getElementById("attached3-3").textContent = data.attached3;
            $('#attached3-3').css('display', 'block');
          } else {
            $('#attached3-3').css('display', 'none');
          }

          $('#studApEvaluationLevel3Modal').modal('toggle');
        }
      }
    });
  });
  $('#studentAppealTable').delegate('.viewDetails', 'click', function () {
    $('#firstStep').css('background-color', 'gray');
    $('#secondStep').css('background-color', 'gray');
    $('#thirdStep').css('background-color', 'gray');
    $('#fourthStep').css('background-color', 'gray');
    document.getElementById("firstStepDate").textContent = '';
    document.getElementById("firstStepText").textContent = '';
    document.getElementById("secondStepDate").textContent = '';
    document.getElementById("secondStepText").textContent = '';
    document.getElementById("thirdStepDate").textContent = '';
    document.getElementById("thirdStepText").textContent = '';
    document.getElementById("fourthStepDate").textContent = '';
    document.getElementById("fourthStepText").textContent = '';
    $.ajax({
      url: BASE_URL + '/director/getDirectorAppealDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appeal_slug: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          document.getElementById("transaction_no").textContent = data.transaction_number;
          document.getElementById("specific_concern").textContent = data.specific_concern;
          document.getElementById("remarks").textContent = data.remarks;

          if (data.status == 0) {
            $('#firstStep').css('background-color', 'green');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
          } else if (data.status == 1) {
            $('#firstStep').css('background-color', 'green');
            $('#secondStep').css('background-color', 'green');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
            document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
            document.getElementById("secondStepText").textContent = 'Completed';
          } else if (data.status == 3) {
            $('#firstStep').css('background-color', 'green');
            $('#secondStep').css('background-color', 'green');
            $('#thirdStep').css('background-color', 'red');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
            document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
            document.getElementById("secondStepText").textContent = 'Completed';
            document.getElementById("thirdStepDate").textContent = data.auditDetails[2]['created_at'];
            document.getElementById("thirdStepText").textContent = 'Disapproved';
          } else {
            $('#firstStep').css('background-color', 'green');
            $('#secondStep').css('background-color', 'green');
            $('#thirdStep').css('background-color', 'green');
            $('#fourthStep').css('background-color', 'green');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
            document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
            document.getElementById("secondStepText").textContent = 'Completed';
            document.getElementById("thirdStepDate").textContent = data.auditDetails[2]['created_at'];
            document.getElementById("thirdStepText").textContent = 'Completed';
            document.getElementById("fourthStepDate").textContent = data.auditDetails[2]['created_at'];
            document.getElementById("fourthStepText").textContent = 'Completed';
          }

          $('#studApDetailsModal').modal('toggle');
        }
      }
    });
  });
  $('#studentAppealTable').delegate('.acceptAppeal', 'click', function () {
    if (confirm('Are you sure you want to approve this request?')) {
      $.ajax({
        url: BASE_URL + '/director/updateAppealStatus',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
          appeal_slug: $(this).data('id'),
          status: 2
        },
        dataType: 'json',
        success: function success(data) {
          if (data.result == true) {
            $('#studentAppealTable').dataTable().api().ajax.reload();
            alert('Request was successfully updated!');
            window.location.reload();
          }
        }
      });
    }
  });
  $('#studentAppealTable').delegate('.declineAppeal', 'click', function () {
    $('#remarks_appeal_slug').val($(this).data('id'));
    $('#remarksModal').modal('toggle');
  });
  $('#studentAppealTable').delegate('.remarks', 'click', function () {
    $('#remarks_appeal_slug').val($(this).data('id'));
    $.ajax({
      url: BASE_URL + '/director/getDirectorAppealDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appeal_slug: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $('#reasonDetails').val(data.remarks);
          $('#remarksModal').modal('toggle');
        }
      }
    });
  });
  $('#submitRemarks').on('click', function () {
    $.ajax({
      url: BASE_URL + '/director/updateAppealStatus',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appeal_slug: $('#remarks_appeal_slug').val(),
        reasonDetails: $('#reasonDetails').val()
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $('#studentAppealTable').dataTable().api().ajax.reload();
          alert('Remarks was successfully added!');
          window.location.reload();
        }
      }
    });
  });
  $('#submitStudentAppealEval').on('click', function () {
    $('#successNotification').css('display', 'none');
    $('#failedNotification').css('display', 'none');
    $.ajax({
      url: BASE_URL + '/director/postMeeting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        level: $('#level').val(),
        appeal_id: $('#appeal_id').val(),
        date: $('#date').val(),
        start: $('#start').val(),
        end: $('#end').val(),
        message: $('#message').val()
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $('#successNotification').css('display', 'block');
          $('#failedNotification').css('display', 'none');
        } else {
          $('#successNotification').css('display', 'none');
          $('#failedNotification').css('display', 'block');
          document.getElementById("failedText").textContent = data.text;
        }
      }
    });
  });
  $('#submitStudentAppealEval-2').on('click', function () {
    $('#successNotification-2').css('display', 'none');
    $('#failedNotification-2').css('display', 'none');
    $.ajax({
      url: BASE_URL + '/director/postMeeting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        level: $('#level-2').val(),
        appeal_id: $('#appeal_id-2').val(),
        prof_email: $('#prof_email-2').val(),
        date: $('#date-2').val(),
        start: $('#start-2').val(),
        end: $('#end-2').val(),
        message: $('#message-2').val()
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $('#successNotification-2').css('display', 'block');
          $('#failedNotification-2').css('display', 'none');
        } else {
          $('#successNotification-2').css('display', 'none');
          $('#failedNotification-2').css('display', 'block');
          document.getElementById("failedText-2").textContent = data.text;
        }
      }
    });
  });
  $('#submitStudentAppealEval-3').on('click', function () {
    $('#successNotification-3').css('display', 'none');
    $('#failedNotification-3').css('display', 'none');
    $.ajax({
      url: BASE_URL + '/director/postMeeting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        level: $('#level-3').val(),
        appeal_id: $('#appeal_id-3').val(),
        prof_email: $('#prof_email-3').val(),
        date: $('#date-3').val(),
        start: $('#start-3').val(),
        end: $('#end-3').val(),
        message: $('#message-3').val()
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $('#successNotification-3').css('display', 'block');
          $('#failedNotification-3').css('display', 'none');
        } else {
          $('#successNotification-3').css('display', 'none');
          $('#failedNotification-3').css('display', 'block');
          document.getElementById("failedText-3").textContent = data.text;
        }
      }
    });
  });
  $('.datetimepicker2').datetimepicker({
    'format': 'LT'
  });
  $('.datetimepicker3').datetimepicker({
    'format': 'LT'
  });
});

function convert(input) {
  return moment(input, 'HH:mm').format('h:mm A');
} // function startIt(){
//   validateAppointmentTime("start");
// }


function validateAppointmentTimeLevel1(param) {
  //  7am  - 8pm
  var hourArray = ["7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20"];
  var start = $("#start").val();
  start = convertTo24Hour(start.toLowerCase());
  var sHr = start.split(":");
  sHr = sHr[0];
  var end = $("#end").val();
  end = convertTo24Hour(end.toLowerCase());
  var eHr = end.split(":");
  eHr = eHr[0];

  if (hourArray.indexOf(sHr) !== -1) {
    $("#failedNotificationTime").hide();
    $("#failedNotificationTime").css('display', 'none');
    $("#submitStudentAppealEval").attr('disabled', false);
    SumHours(start, end);
  } else {
    $("#failedTextTime").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
    $("#submitStudentAppealEval").attr('disabled', true);
    $("#failedNotificationTime").show();
  }

  if (hourArray.indexOf(eHr) !== -1) {
    $("#failedNotificationTime").hide();
    $("#failedNotificationTime").css('display', 'none');
    $("#submitStudentAppealEval").attr('disabled', false);
    SumHours(start, end);
  } else {
    $("#failedTextTime").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
    $("#submitStudentAppealEval").attr('disabled', true);
    $("#failedNotificationTime").show();
  }

  setTimeout(function () {
    validateAppointmentTimeLevel1("start");
  }, 3000);
}

function validateAppointmentTimeLevel2(param) {
  //  7am  - 8pm
  var hourArray = ["7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20"];
  var start = $("#start-2").val();
  start = convertTo24Hour(start.toLowerCase());
  var sHr = start.split(":");
  sHr = sHr[0];
  var end = $("#end-2").val();
  end = convertTo24Hour(end.toLowerCase());
  var eHr = end.split(":");
  eHr = eHr[0];

  if (hourArray.indexOf(sHr) !== -1) {
    $("#failedNotificationTime-2").hide();
    $("#failedNotificationTime-2").css('display', 'none');
    $("#submitStudentAppealEval-2").attr('disabled', false);
    SumHours(start, end);
  } else {
    $("#failedTextTime-2").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
    $("#submitStudentAppealEval-2").attr('disabled', true);
    $("#failedNotificationTime-2").show();
  }

  if (hourArray.indexOf(eHr) !== -1) {
    $("#failedNotificationTime-2").hide();
    $("#failedNotificationTime-2").css('display', 'none');
    $("#submitStudentAppealEval-2").attr('disabled', false);
    SumHours(start, end);
  } else {
    $("#failedTextTime-2").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
    $("#submitStudentAppealEval-2").attr('disabled', true);
    $("#failedNotificationTime-2").show();
  }

  setTimeout(function () {
    validateAppointmentTimeLevel2("start");
  }, 3000);
}

function validateAppointmentTimeLevel3(param) {
  //  7am  - 8pm
  var hourArray = ["7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20"];
  var start = $("#start-3").val();
  start = convertTo24Hour(start.toLowerCase());
  var sHr = start.split(":");
  sHr = sHr[0];
  var end = $("#end-3").val();
  end = convertTo24Hour(end.toLowerCase());
  var eHr = end.split(":");
  eHr = eHr[0];

  if (hourArray.indexOf(sHr) !== -1) {
    $("#failedNotificationTime-3").hide();
    $("#failedNotificationTime-3").css('display', 'none');
    $("#submitStudentAppealEval-3").attr('disabled', false);
    SumHours(start, end);
  } else {
    $("#failedTextTime-3").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
    $("#submitStudentAppealEval-3").attr('disabled', true);
    $("#failedNotificationTime-3").show();
  }

  if (hourArray.indexOf(eHr) !== -1) {
    $("#failedNotificationTime-3").hide();
    $("#failedNotificationTime-3").css('display', 'none');
    $("#submitStudentAppealEval-3").attr('disabled', false);
    SumHours(start, end);
  } else {
    $("#failedTextTime-3").text("Appointment Availiabilty : 7:00 AM - 8:00 PM");
    $("#submitStudentAppealEval-3").attr('disabled', true);
    $("#failedNotificationTime-3").show();
  }

  setTimeout(function () {
    validateAppointmentTimeLevel3("start");
  }, 3000);
}

function convertTo24Hour(time) {
  var hours = parseInt(time.substr(0, 2));

  if (time.indexOf('am') != -1 && hours == 12) {
    time = time.replace('12', '0');
  }

  if (time.indexOf('pm') != -1 && hours < 12) {
    time = time.replace(hours, hours + 12);
  }

  return time.replace(/(am|pm)/, '');
}

function SumHours(smon, fmon) {
  var diff = 0;

  if (smon && fmon) {
    smon = ConvertToSeconds(smon);
    fmon = ConvertToSeconds(fmon);
    diff = Math.abs(fmon - smon);

    if (diff < 1800) {
      $("#failedTextTime").text("Appointment Minimum Time : 30 Mins");
      $("#failedNotificationTime").show();
      $("#submitStudentAppealEval").attr('disabled', true);
    } else if (diff > 10800) {
      $("#failedTextTime").text("Appointment Maximum Time : 3 Hours");
      $("#failedNotificationTime").show();
      $("#submitStudentAppealEval").attr('disabled', true);
    } else {
      $("#failedNotificationTime").hide();
      $("#failedNotificationTime").css('display', 'none');
      $("#submitStudentAppealEval").attr('disabled', false);
    }
  }
}

function ConvertToSeconds(time) {
  var splitTime = time.split(":");
  return splitTime[0] * 3600 + splitTime[1] * 60;
}