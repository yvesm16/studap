"use strict";

$(document).ready(function () {
  var BASE_URL = $("#hdnBaseUrl").val();
  $(function () {
    $('#studentCreditList').dataTable({
      "scrollCollapse": true,
      "sDom": '<"top"f>rt<"bottom"ip><"clear">',
      "bServerSide": true,
      "pagingType": "full_numbers",
      "iDisplayLength": 7,
      "sAjaxSource": BASE_URL + "/ajax?type=studentCreditList",
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [5]
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
  $('#studentCreditList').delegate('.viewDetails', 'click', function () {
    $('#firstStep').css('background-color', 'gray');
    $('#secondStep').css('background-color', 'gray');
    $('#thirdStep').css('background-color', 'gray');
    $('#fourthStep').css('background-color', 'gray');
    $('#fifthStep').css('background-color', 'gray');
    document.getElementById("firstStepDate").textContent = '';
    document.getElementById("firstStepText").textContent = '';
    document.getElementById("secondStepDate").textContent = '';
    document.getElementById("secondStepText").textContent = '';
    document.getElementById("thirdStepDate").textContent = '';
    document.getElementById("thirdStepText").textContent = '';
    document.getElementById("fourthStepDate").textContent = '';
    document.getElementById("fourthStepText").textContent = '';
    document.getElementById("fifthStepDate").textContent = '';
    document.getElementById("fifthStepText").textContent = '';
    $.ajax({
      url: BASE_URL + '/student/getStudentCreditDetails',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        credit_course_id: $(this).data('id')
      },
      dataType: 'json',
      success: function success(data) {
        if (data.result == true) {
          document.getElementById("student_name").textContent = data.student_name;
          document.getElementById("current_student_id").textContent = data.student_id;
          document.getElementById("institute").textContent = data.institute;
          document.getElementById("new_program").textContent = data.new_program['text'];
          document.getElementById("original_program").textContent = data.original_program['text'];
          document.getElementById("remarksDetail").value = data.remarks ? data.remarks.join("\n") : "";

          if (data.status >= 0) {
            $('#firstStep').css('background-color', 'green');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
          }

          if (data.status >= 1 && data.auditDetails[1]['created_at']) {
            $('#secondStep').css('background-color', 'green');
            document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
            document.getElementById("secondStepText").textContent = 'Completed';
          }

          if (data.status >= 2 && data.auditDetails[2]) {
            $('#thirdStep').css('background-color', 'green');
            document.getElementById("thirdStepDate").textContent = data.auditDetails[2]['created_at'];
            document.getElementById("thirdStepText").textContent = 'Completed';
          }

          if (data.status >= 3 && data.auditDetails[3]) {
            $('#fourthStep').css('background-color', 'green');
            $('#fifthStep').css('background-color', 'green');
            document.getElementById("fourthStepDate").textContent = data.auditDetails[3]['created_at'];
            document.getElementById("fourthStepText").textContent = 'Completed';
            document.getElementById("fifthStepDate").textContent = data.auditDetails[3]['created_at'];
            document.getElementById("fifthStepText").textContent = 'Completed';
          }

          if (data.status == 5) {
            if (!data.auditDetails[2]) {
              $('#secondStep').css('background-color', 'red');
              document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
              document.getElementById("secondStepText").textContent = 'Denied';
            }

            if (!data.auditDetails[3] && data.auditDetails[2]) {
              $('#thirdStep').css('background-color', 'red');
              $('#fourthStep').css('background-color', 'red');
              document.getElementById("thirdStepDate").textContent = data.auditDetails[2]['created_at'];
              document.getElementById("thirdStepText").textContent = 'Denied';
              document.getElementById("fourthStepText").textContent = 'Denied';
            }

            if (data.auditDetails[3]) {
              $('#fourthStep').css('background-color', 'red');
              document.getElementById("fourthStepDate").textContent = data.auditDetails[3]['created_at'];
              document.getElementById("fourthStepText").textContent = 'Denied';
            }

            $('#fifthStep').css('background-color', 'green');
            document.getElementById("fifthStepText").textContent = 'Completed';
          }

          $('#studentCreditTrackerModal').modal('toggle');
        }
      }
    });
  });
});