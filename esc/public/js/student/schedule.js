$(document).ready(function() {

  var BASE_URL = $("#hdnBaseUrl").val();
  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

  $('#datetimepicker1').datetimepicker({
    'format': 'YYYY-MM-DD',
    'minDate': today,
    'maxDate': moment().add(6, 'day')
  });
  $('#datetimepicker2').datetimepicker({
    'format': 'LT'
  });
  $('#datetimepicker3').datetimepicker({
    'format': 'LT'
  });

  $(".concerns").change(function() {
    if($("#others").is(':checked') == true) {
        $('.othersInput').css('display','block');
        $('#othersText').val('');
    }else{
      $('.othersInput').css('display','none');
    }
  });

  $('#submitConsultationForm').on('click', function (){
      $.ajax({
          url: BASE_URL + '/student/postConsultation',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {
              professor_id : $('#professor_id').val(),
              appointment_date : $('#appointment_date').val(),
              appointment_start : $('#appointment_start').val(),
              appointment_end : $('#appointment_end').val(),
              concerns : $('input:radio[name=concerns]:checked').val(),
              othersText : $('#othersText').val()
          },
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              $('#successNotification').css('display','block');
              $('#failedNotification').css('display','none');
            }else{
              $('#successNotification').css('display','none');
              $('#failedNotification').css('display','block');
              document.getElementById("failedText").textContent = data.text;
            }
          }
      });
  });

  $('.reserveSlot').click(function(){
    $('#successNotification').css('display','none');
  });

});
