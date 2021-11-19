"use strict";

$(document).ready(function () {
  var BASE_URL = $("#hdnBaseUrl").val();
  var url = window.location.href; // console.log(url.split('/')[5]);

  if (url.split('/')[5] == 0) {
    document.getElementById("titlePage").textContent = 'Pending Consultations';
    $('.downloadCompletedListReportDiv').css('display', 'none');
  } else if (url.split('/')[5] == 1) {
    document.getElementById("titlePage").textContent = 'Approved Consultations';
    $('.downloadCompletedListReportDiv').css('display', 'none');
  } else if (url.split('/')[5] == 4) {
    document.getElementById("titlePage").textContent = 'Complete Consultations';
    $('.downloadCompletedListReportDiv').css('display', 'block');
  } else {
    document.getElementById("titlePage").textContent = 'Rejected Consultations';
    $('.downloadCompletedListReportDiv').css('display', 'none');
  }

  $('.downloadCompletedListReportDiv').click(function () {
    window.location.href = BASE_URL + '/schedule/details/completed_pdf';
  });
  $(function () {
    $('#consultationTable').dataTable({
      "scrollCollapse": true,
      "sDom": '<"top"f>rt<"bottom"ip><"clear">',
      "bServerSide": true,
      "pagingType": "full_numbers",
      "iDisplayLength": 10,
      "sAjaxSource": BASE_URL + "/ajax?type=professorConsultationList&status=" + $('#status').val(),
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [4, 5, 6, 7]
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
  $('#submitConsultationForm').on('click', function () {
    var concerns = [];
    $("input:checkbox[name=concerns]:checked").each(function () {
      concerns.push($(this).val());
    });
    $.ajax({
      url: BASE_URL + '/student/postConsultation',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        professor_id: $('#professor_id').val(),
        appointment_date: $('#appointment_date').val(),
        appointment_start: $('#appointment_start').val(),
        appointment_end: $('#appointment_end').val(),
        concerns: concerns,
        othersText: $('#othersText').val()
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $('#successNotification').css('display', 'block');
          $('#slotTable').dataTable().api().ajax.reload();
        }
      }
    });
  });
  $('#slotTable').delegate('.updateStatus', 'click', function () {
    $.ajax({
      url: BASE_URL + '/professor/updateSlotStatus',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        slot_id: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $('#slotTable').dataTable().api().ajax.reload();
        }
      }
    });
  });
  $('#consultationTable').delegate('.viewDetails', 'click', function () {
    $('#firstStep').css('background-color', 'gray');
    $('#secondStep').css('background-color', 'gray');
    $('#thirdStep').css('background-color', 'gray');
    $('#fourthStep').css('background-color', 'gray');
    $('#meetingLink').val('');
    document.getElementById("firstStepDate").textContent = '';
    document.getElementById("firstStepText").textContent = '';
    document.getElementById("secondStepDate").textContent = '';
    document.getElementById("secondStepText").textContent = '';
    document.getElementById("thirdStepDate").textContent = '';
    document.getElementById("thirdStepText").textContent = '';
    document.getElementById("fourthStepDate").textContent = '';
    document.getElementById("fourthStepText").textContent = '';
    $.ajax({
      url: BASE_URL + '/professor/getAppointmentDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appointment_id: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          document.getElementById("student_name").textContent = data.student_name;
          document.getElementById("student_email").textContent = data.student_email;
          document.getElementById("appointment_date").textContent = data.appointment_date;
          document.getElementById("appointment_time").textContent = data.appointment_time;
          $('#appointment_id').val(data.appointment_id);
          $('#meetingLink').val(data.meeting_link);

          if (data.remarks == null) {
            $('.remarksDiv').css('display', 'none');
          } else {
            document.getElementById("remarksSpan").textContent = data.remarks;
          }

          if (data.status == 1) {
            $('#firstStep').css('background-color', 'green');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
          } else if (data.status == 2) {
            if (data.appointment_status == 1) {
              $('#firstStep').css('background-color', 'green');
              $('#secondStep').css('background-color', 'green');
              document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
              document.getElementById("firstStepText").textContent = 'Completed';
              document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
              document.getElementById("secondStepText").textContent = 'Completed';
            } else {
              $('#firstStep').css('background-color', 'green');
              $('#secondStep').css('background-color', 'red');
              document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
              document.getElementById("firstStepText").textContent = 'Completed';
              document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
              document.getElementById("secondStepText").textContent = 'Disapproved';
            }
          } else if (data.status == 3) {
            $('#firstStep').css('background-color', 'green');
            $('#secondStep').css('background-color', 'green');
            $('#thirdStep').css('background-color', 'green');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
            document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
            document.getElementById("secondStepText").textContent = 'Completed';
            document.getElementById("thirdStepDate").textContent = data.auditDetails[2]['created_at'];
            document.getElementById("thirdStepText").textContent = 'Completed';
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
            document.getElementById("fourthStepDate").textContent = data.auditDetails[3]['created_at'];
            document.getElementById("fourthStepText").textContent = 'Completed';
          }

          $('#requestModal').modal('toggle');
        }
      }
    });
  });
  $('#consultationTable').delegate('.approvedAppointment', 'click', function () {
    if (confirm('Are you sure you want to approve this appointment?')) {
      $.ajax({
        url: BASE_URL + '/professor/updateAppointmentStatus',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
          appointment_id: $(this).data('id'),
          status: 1
        },
        dataType: 'json',
        success: function success(data) {
          if (data.result == true) {
            $('#consultationTable').dataTable().api().ajax.reload();
            alert('Appointment was successfully updated!');
            window.location.reload();
          }
        }
      });
    }
  });
  $('#consultationTable').delegate('.disapproveAppointment', 'click', function () {
    $('#remarks_appointment_id').val($(this).data('id'));
    $('#remarksModal').modal('toggle');
  });
  $('#submitRemarks').on('click', function () {
    if (confirm('Are you sure you want to reject this appointment?')) {
      $.ajax({
        url: BASE_URL + '/professor/updateAppointmentStatus',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
          appointment_id: $('#remarks_appointment_id').val(),
          reasonDetails: $('#reasonDetails').val(),
          status: 2
        },
        dataType: 'json',
        success: function success(data) {
          if (data.result == true) {
            $('#consultationTable').dataTable().api().ajax.reload();
            alert('Appointment was successfully updated!');
            window.location.reload();
          }
        }
      });
    }
  });
  $('#consultationTable').delegate('.startAppointment', 'click', function () {
    if (confirm('Are you sure you want to start this appointment?')) {
      $.ajax({
        url: BASE_URL + '/professor/updateAppointmentStatus',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
          appointment_id: $(this).data('id'),
          status: 3
        },
        dataType: 'json',
        success: function success(data) {
          if (data.result == true) {
            $('#consultationTable').dataTable().api().ajax.reload();
            alert('Appointment was successfully updated!');
            window.location.reload();
          }
        }
      });
    }
  });
  $('#consultationTable').delegate('.endAppointment', 'click', function () {
    if (confirm('Are you sure you want to complete this appointment?')) {
      $.ajax({
        url: BASE_URL + '/professor/updateAppointmentStatus',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
          appointment_id: $(this).data('id'),
          status: 4
        },
        dataType: 'json',
        success: function success(data) {
          if (data.result == true) {
            $('#consultationTable').dataTable().api().ajax.reload();
            alert('Appointment was successfully updated!');
            window.location.reload();
          }
        }
      });
    }
  });
  $('#slotTable').delegate('.updateSlot', 'click', function () {
    $.ajax({
      url: BASE_URL + '/professor/getSlotDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        slot_id: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          var slotDate = data.data['start_time'].split(' ')[0];
          var slotStartTime = data.data['start_time'].split(' ')[1];
          slotStartTime = convert(slotStartTime);
          var slotEndTime = data.data['end_time'].split(' ')[1];
          slotEndTime = convert(slotEndTime);
          var slotTitle = data.data['title'];
          $('#slot_id').val(data.data['id']);
          $('#slot_name').val(slotTitle);
          $('#slot_date').val(slotDate);
          $('#slot_start').val(slotStartTime);
          $('#slot_end').val(slotEndTime);
          $(".addSlotDiv").css('display', 'none');
          $(".updateSlotDiv").css('display', 'block');
          $('#successNotification').css('display', 'none');
          $('#failedNotification').css('display', 'none');
        }
      }
    });
  });
  $('.updateSlot').on('click', function () {
    $.ajax({
      url: BASE_URL + '/professor/updateSlotDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        slot_id: $('#slot_id').val(),
        slot_title: $('#slot_name').val(),
        slot_date: $('#slot_date').val(),
        slot_start: $('#slot_start').val(),
        slot_end: $('#slot_end').val()
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          $(".addSlotDiv").css('display', 'block');
          $(".updateSlotDiv").css('display', 'none');
          $('#successNotification').css('display', 'block');
          $('#failedNotification').css('display', 'none');
          $('#slot_name').val('');
          $('#slot_date').val('');
          $('#slot_start').val('');
          $('#slot_end').val('');
          document.getElementById("successSlotContent").textContent = data.text;
          $('#slotTable').dataTable().api().ajax.reload();
        } else {
          $('#successNotification').css('display', 'none');
          $('#failedNotification').css('display', 'block');
          document.getElementById("failedSlotContent").textContent = data.text;
        }
      }
    });
  });
  $('.saveLink').on('click', function () {
    $.ajax({
      url: BASE_URL + '/professor/updateMeeting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        appointment_id: $('#appointment_id').val(),
        data: $('#meetingLink').val(),
        transaction: 0
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          alert('Appointment meeting link was successfully updated');
        }
      }
    });
  });
});

function convert(input) {
  return moment(input, 'HH:mm').format('h:mm A');
}