$(document).ready(function() {

    var BASE_URL = $("#hdnBaseUrl").val();
    var status = "all";


    $('#submitChangePassword').on('click', function (){

        $.ajax({
            url: BASE_URL + '/changePassword',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: {
                currentPassword : $('#currentPassword').val(),
                newPassword : $('#newPassword').val(),
                confirmPassword : $('#confirmPassword').val()
            },
            dataType    :'json',
            success: function (data) {
              if(data.result == true){
                $('#successPassword').css('display','block');
                $('#failedPassword').css('display','none');
                document.getElementById("failedContent").textContent = data.text;
              }else{
                $('#successPassword').css('display','none');
                $('#failedPassword').css('display','block');
                document.getElementById("failedContent").textContent = data.text;
              }
            }
        });
    });

    $('#settings').on('click', function (){
      $('#successPassword').css('display','none');
      $('#failedPassword').css('display','none');
      document.getElementById("currentPassword").value = '';
      document.getElementById("newPassword").value = '';
      document.getElementById("confirmPassword").value = '';
    });

});
