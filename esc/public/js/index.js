$(document).ready(function() {

    var BASE_URL = $("#hdnBaseUrl").val();
    var status = "all";


    $('#submitForgotPassword').on('click', function (){

        $.ajax({
            url: BASE_URL + '/forgotPassword',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: {
                email : $('#emailForgotPassword').val()
            },
            dataType    :'json',
            success: function (data) {
              if(data.success){
                $('#successNotification').css('display','block');
                $('#failedNotification').css('display','none');
              }else{
                $('#successNotification').css('display','none');
                $('#failedNotification').css('display','block');
              }

            }
        });
    });

    $('#forgotPassword').on('click', function (){
      $('#successNotification').css('display','none');
      $('#failedNotification').css('display','none');
      document.getElementById("emailForgotPassword").value = '';
    });


});
