$(document).ready(function() {
  var BASE_URL = $("#hdnBaseUrl").val();

  $(function() {
    $('#studentAppealListTable').dataTable({
      "scrollCollapse": true,
      "sDom": '<"top"f>rt<"bottom"ip><"clear">',
      "bServerSide": true,
      "pagingType": "full_numbers",
      "iDisplayLength": 7,
      "sAjaxSource": BASE_URL+ "/ajax?type=studentAppealListTracker",
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [1,2,3]
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

  $('#studentAppealListTable').delegate('.viewDetails','click', function (){
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
            document.getElementById("fourthStepDate").textContent = data.auditDetails[2]['created_at'];
            document.getElementById("fourthStepText").textContent = 'Completed';
          }
          $('#studApDetailsModal').modal('toggle');
        }
      }
    });
  });
});

function convert(input) {
    return moment(input, 'HH:mm').format('h:mm A');
}
