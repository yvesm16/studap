$(document).ready(function() {
  var BASE_URL = $("#hdnBaseUrl").val();
  var pathname = window.location.pathname;

  if(pathname.split('/')[3] == 'completed'){
    $('.downloadCompletedListReportDiv').css('display','block');
  }else{
    $('.downloadCompletedListReportDiv').css('display','none');
  }
  
  $('.downloadCompletedListReportDiv').click(function(){
    window.location.href = BASE_URL + '/student_appeal/details/completed_pdf';
  });

  $(function() {
    $('#studentAppealTable').dataTable({
      "scrollCollapse": true,
      "sDom": '<"top"f>rt<"bottom"ip><"clear">',
      "bServerSide": true,
      "pagingType": "full_numbers",
      "iDisplayLength": 7,
      "sAjaxSource": BASE_URL+ "/ajax?type=studentAppealList&status=" + pathname.split('/')[3],
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [1,2,3,4,5]
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

  $('#studentAppealTable').delegate('.evaluate','click', function (){
      $.ajax({
        url: BASE_URL + '/director/getDirectorAppealDetails',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
          appeal_slug : $(this).data('id')
        },
        dataType    :'json',
        success: function (data) {
          if(data.result == true){
            document.getElementById("transaction_number").textContent = data.transaction_number;
            document.getElementById("student_id").textContent = data.student_id;
            document.getElementById("student_name").textContent = data.student_name;
            document.getElementById("attached2").textContent = data.attached2;
            document.getElementById("attached3").textContent = data.attached3;
            $('#message').val(data.message);
            $('#appeal_id').val(data.transaction_number);
            $("#objectViewDocumentPDF").attr("data", data.path);
            $("#embedViewDocumentPDF").attr("src", data.path);
            $('#studApEvaluationModal').modal('toggle');

            if (data.status > 0) {
              $('#submitStudentAppealEval').css('display','none');
            }
            
            if (data.attached1) {
              document.getElementById("attached1").textContent = data.attached1;
              $('#attached1').css('display','block');
            } else {
              $('#attached1').css('display','none');
            }

            if (data.attached2) {
              document.getElementById("attached2").textContent = data.attached2;
              $('#attached2').css('display','block');
            } else {
              $('#attached2').css('display','none');
            }
            
            if (data.attached3) {
              document.getElementById("attached3").textContent = data.attached3;
              $('#attached3').css('display','block');
            } else {
              $('#attached3').css('display','none');
            }
          }
        }
      });
  });

  $('#studentAppealTable').delegate('.viewDetails','click', function (){
    $('#firstStep').css('background-color','gray');
    $('#secondStep').css('background-color','gray');
    $('#thirdStep').css('background-color','gray');
    $('#fourthStep').css('background-color','gray');
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
        appeal_slug : $(this).data('id')
      },
      dataType    :'json',
      success: function (data) {
        if(data.result == true){
          document.getElementById("transaction_no").textContent = data.transaction_number;
          document.getElementById("specific_concern").textContent = data.specific_concern;
          document.getElementById("remarks").textContent = data.remarks;
          if(data.status == 0){
            $('#firstStep').css('background-color','green');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
          }else if (data.status == 1) {
            $('#firstStep').css('background-color','green');
            $('#secondStep').css('background-color','green'); 
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
            document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
            document.getElementById("secondStepText").textContent = 'Completed';
          }else if (data.status == 3) {
            $('#firstStep').css('background-color','green');
            $('#secondStep').css('background-color','green');
            $('#thirdStep').css('background-color','red');
            document.getElementById("firstStepDate").textContent = data.auditDetails[0]['created_at'];
            document.getElementById("firstStepText").textContent = 'Completed';
            document.getElementById("secondStepDate").textContent = data.auditDetails[1]['created_at'];
            document.getElementById("secondStepText").textContent = 'Completed';
            document.getElementById("thirdStepDate").textContent = data.auditDetails[2]['created_at'];
            document.getElementById("thirdStepText").textContent = 'Disapproved';
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
          $('#studApDetailsModal').modal('toggle');
        }
      }
    });
  });

  $('#studentAppealTable').delegate('.acceptAppeal','click', function (){
      if (confirm('Are you sure you want to approve this request?')) {
        $.ajax({
            url: BASE_URL + '/director/updateAppealStatus',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: {
              appeal_slug : $(this).data('id'),
              status: 2
            },
            dataType    :'json',
            success: function (data) {
              if(data.result == true){
                $('#studentAppealTable').dataTable().api().ajax.reload();
                alert('Request was successfully updated!');
                window.location.reload();
              }
            }
        });
      }

  });

  $('#studentAppealTable').delegate('.declineAppeal','click', function (){
      $('#remarks_appeal_slug').val($(this).data('id'));
      $('#remarksModal').modal('toggle');
  });

  $('#submitRemarks').on('click',function(){
    if (confirm('Are you sure you want to reject this request?')) {
      $.ajax({
        url: BASE_URL + '/director/updateAppealStatus',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
          appeal_slug : $('#remarks_appeal_slug').val(),
          reasonDetails : $('#reasonDetails').val(),
          status: 3
        },
        dataType    :'json',
        success: function (data) {
          if(data.result == true){
            $('#studentAppealTable').dataTable().api().ajax.reload();
            alert('Request was successfully updated!');
            window.location.reload();
          }
        }
      });
    }
  });

  // $('#consultationTable').delegate('.startAppointment','click', function (){
  //     if (confirm('Are you sure you want to start this appointment?')) {
  //       $.ajax({
  //           url: BASE_URL + '/professor/updateAppointmentStatus',
  //           headers: {
  //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //           },
  //           type: 'POST',
  //           data: {
  //               appointment_id : $(this).data('id'),
  //               status: 3
  //           },
  //           dataType    :'json',
  //           success: function (data) {
  //             if(data.result == true){
  //               $('#consultationTable').dataTable().api().ajax.reload();
  //               alert('Appointment was successfully updated!');
  //               window.location.reload();
  //             }
  //           }
  //       });
  //     }

  // });

  // $('#consultationTable').delegate('.endAppointment','click', function (){
  //     if (confirm('Are you sure you want to complete this appointment?')) {
  //       $.ajax({
  //           url: BASE_URL + '/professor/updateAppointmentStatus',
  //           headers: {
  //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //           },
  //           type: 'POST',
  //           data: {
  //               appointment_id : $(this).data('id'),
  //               status: 4
  //           },
  //           dataType    :'json',
  //           success: function (data) {
  //             if(data.result == true){
  //               $('#consultationTable').dataTable().api().ajax.reload();
  //               alert('Appointment was successfully updated!');
  //               window.location.reload();
  //             }
  //           }
  //       });
  //     }

  // });

  // $('#slotTable').delegate('.updateSlot','click', function (){
  //     $.ajax({
  //         url: BASE_URL + '/professor/getSlotDetails',
  //         headers: {
  //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //         },
  //         type: 'POST',
  //         data: {
  //             slot_id : $(this).data('id')
  //         },
  //         dataType    :'json',
  //         success: function (data) {
  //           if(data.result == true){
  //             var slotDate = data.data['start_time'].split(' ')[0];
  //             var slotStartTime = data.data['start_time'].split(' ')[1];
  //             slotStartTime = convert(slotStartTime);
  //             var slotEndTime = data.data['end_time'].split(' ')[1];
  //             slotEndTime = convert(slotEndTime);
  //             var slotTitle = data.data['title'];

  //             $('#slot_id').val(data.data['id']);
  //             $('#slot_name').val(slotTitle);
  //             $('#slot_date').val(slotDate);
  //             $('#slot_start').val(slotStartTime);
  //             $('#slot_end').val(slotEndTime);

  //             $(".addSlotDiv").css('display','none');
  //             $(".updateSlotDiv").css('display','block');
  //             $('#successNotification').css('display','none');
  //             $('#failedNotification').css('display','none');

  //           }
  //         }
  //     });
  // });

  // $('.updateSlot').on('click', function (){

  //     $.ajax({
  //         url: BASE_URL + '/professor/updateSlotDetails',
  //         headers: {
  //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //         },
  //         type: 'POST',
  //         data: {
  //             slot_id : $('#slot_id').val(),
  //             slot_title : $('#slot_name').val(),
  //             slot_date : $('#slot_date').val(),
  //             slot_start : $('#slot_start').val(),
  //             slot_end : $('#slot_end').val()
  //         },
  //         dataType    :'json',
  //         success: function (data) {
  //           if(data.result == true){
  //             $(".addSlotDiv").css('display','block');
  //             $(".updateSlotDiv").css('display','none');
  //             $('#successNotification').css('display','block');
  //             $('#failedNotification').css('display','none');
  //             $('#slot_name').val('');
  //             $('#slot_date').val('');
  //             $('#slot_start').val('');
  //             $('#slot_end').val('');
  //             document.getElementById("successSlotContent").textContent = data.text;
  //             $('#slotTable').dataTable().api().ajax.reload();
  //           }else{
  //             $('#successNotification').css('display','none');
  //             $('#failedNotification').css('display','block');
  //             document.getElementById("failedSlotContent").textContent = data.text;
  //           }
  //         }
  //     });
  // });

  // $('#submitStudentAppealEval').on('click',function(){
    // $.ajax({
    //     url: BASE_URL + '/director/updateMeeting',
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     type: 'POST',
    //     data: {
    //         appointment_id : $('#appointment_id').val(),
    //         data : $('#meetingLink').val(),
    //         transaction : 0
    //     },
    //     dataType    :'json',
    //     success: function (data) {
    //       if(data.result == true){
    //         alert('Appointment meeting link was successfully updated');
    //       }
    //     }
    // });
  //   console.log('hi');
  // });

});

function convert(input) {
    return moment(input, 'HH:mm').format('h:mm A');
}
