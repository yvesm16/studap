$(document).ready(function() {

  var BASE_URL = $("#hdnBaseUrl").val();
  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

  $('#datetimepicker1').datetimepicker({
    'format': 'YYYY-MM-DD',
    'minDate': today
  });
  $('#datetimepicker2').datetimepicker({
    'format': 'LT'
  });
  $('#datetimepicker3').datetimepicker({
    'format': 'LT'
  });
  $('#datetimepicker4').datetimepicker({
    'format': 'YYYY-MM-DD',
    'minDate': today
  });

  $('input[type=radio][name=optradio]').change(function() {
    if (this.value == '1') {
        $('#multiple').prop("disabled", false);
        $('#slot_end_date').prop("disabled", false);
    }
    else if (this.value == '0') {
      $('#multiple').prop("disabled", true);
      $('#slot_end_date').prop("disabled", true);
    }
});

  $('#otherOption').on('click',function(){
    if($(this).data('id') == 0){
      $('#spanIcon').removeClass('glyphicon-chevron-right');
      $('#spanIcon').addClass('glyphicon-chevron-down');
      $(this).data('id',1);
    }else{
      $('#spanIcon').addClass('glyphicon-chevron-right');
      $('#spanIcon').removeClass('glyphicon-chevron-down');
      $(this).data('id',0);
    }
  });

  $(function() {
      $('#slotTable').dataTable({
          "scrollCollapse": true,
          "sDom": '<"top"f>rt<"bottom"ip><"clear">',
          "bServerSide": true,
          "pagingType": "full_numbers",
          "iDisplayLength": 7,
          "sAjaxSource": BASE_URL+ "/ajax?type=professorSlotList",
          "aoColumnDefs": [{
              "bSortable": false,
              "aTargets": [3,4]
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


  $('#slotTable').delegate('.updateStatus','click', function (){
      $.ajax({
          url: BASE_URL + '/professor/updateSlotStatus',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {
              slot_id : $(this).data('id')
          },
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              $('#slotTable').dataTable().api().ajax.reload();
            }
          }
      });
  });

  $('#slotTable').delegate('.updateSlot','click', function (){
      $.ajax({
          url: BASE_URL + '/professor/getSlotDetails',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {
              slot_id : $(this).data('id')
          },
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
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

              $(".addSlotDiv").css('display','none');
              $(".updateSlotDiv").css('display','block');
              $('#successNotification').css('display','none');
              $('#failedNotification').css('display','none');

            }
          }
      });
  });

  $('.updateSlot').on('click', function (){

      $.ajax({
          url: BASE_URL + '/professor/updateSlotDetails',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {
              slot_id : $('#slot_id').val(),
              slot_title : $('#slot_name').val(),
              slot_date : $('#slot_date').val(),
              slot_start : $('#slot_start').val(),
              slot_end : $('#slot_end').val()
          },
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              $(".addSlotDiv").css('display','block');
              $(".updateSlotDiv").css('display','none');
              $('#successNotification').css('display','block');
              $('#failedNotification').css('display','none');
              $('#slot_name').val('');
              $('#slot_date').val('');
              $('#slot_start').val('');
              $('#slot_end').val('');
              document.getElementById("successSlotContent").textContent = data.text;
              $('#slotTable').dataTable().api().ajax.reload();
            }else{
              $('#successNotification').css('display','none');
              $('#failedNotification').css('display','block');
              document.getElementById("failedSlotContent").textContent = data.text;
            }
          }
      });
  });

});

function convert(input) {
    return moment(input, 'HH:mm').format('h:mm A');
}
