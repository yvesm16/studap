$(document).ready(function() {

    var BASE_URL = $("#hdnBaseUrl").val();

    $(function() {
        $('#consultationTable').dataTable({
            "scrollCollapse": true,
            "sDom": '<"top"f>rt<"bottom"ip><"clear">',
            "bServerSide": true,
            "pagingType": "full_numbers",
            "iDisplayLength": 7,
            "sAjaxSource": BASE_URL+ "/ajax?type=studentConsultationList",
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [2,3,4]
            }],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": "<", // This is the link to the previous page
                    "sNext": ">" // This is the link to the next page
                },
                "sSearch": "",
                "sSearchPlaceholder": "Search Records"
            }
        });
    });

    $('#consultationTable').delegate('.viewDetails','click', function (){
        $('#firstStep').css('background-color','gray');
        $('#secondStep').css('background-color','gray');
        $('#thirdStep').css('background-color','gray');
        $('#fourthStep').css('background-color','gray');
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
                appointment_id : $(this).data('id')
            },
            dataType    :'json',
            success: function (data) {
              if(data.result == true){
                document.getElementById("student_name").textContent = data.student_name;
                document.getElementById("student_email").textContent = data.student_email;
                document.getElementById("appointment_date").textContent = data.appointment_date;
                document.getElementById("appointment_time").textContent = data.appointment_time;
                $('#meetingLink').val(data.meeting_link);
                $('#remarksDetail').val(data.remarks);
                if(data.status == 1){
                  $('#firstStep').css('background-color','green');
                  document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
                  document.getElementById("firstStepText").textContent = 'Completed';
                }else if (data.status == 2) {
                  if(data.appointment_status == 1){
                    $('#firstStep').css('background-color','green');
                    $('#secondStep').css('background-color','green');
                    document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
                    document.getElementById("firstStepText").textContent = 'Completed';
                    document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
                    document.getElementById("secondStepText").textContent = 'Completed';
                  }else{
                    $('#firstStep').css('background-color','green');
                    $('#secondStep').css('background-color','red');
                    document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
                    document.getElementById("firstStepText").textContent = 'Completed';
                    document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
                    document.getElementById("secondStepText").textContent = 'Disapproved';
                  }
                }else if (data.status == 3) {
                  $('#firstStep').css('background-color','green');
                  $('#secondStep').css('background-color','green');
                  $('#thirdStep').css('background-color','green');
                  document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
                  document.getElementById("firstStepText").textContent = 'Completed';
                  document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
                  document.getElementById("secondStepText").textContent = 'Completed';
                  document.getElementById("thirdStepDate").textContent = data.auditDetails[2]['created_at'];
                  document.getElementById("thirdStepText").textContent = 'Completed';
                }else{
                  $('#firstStep').css('background-color','green');
                  $('#secondStep').css('background-color','green');
                  $('#thirdStep').css('background-color','green');
                  $('#fourthStep').css('background-color','green');
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


});
