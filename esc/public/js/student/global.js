$(document).ready(function() {

  var BASE_URL = $("#hdnBaseUrl").val();
  var message = "";

  $.ajax({
      url: BASE_URL + '/getNotification',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {},
      dataType    :'json',
      async : false,
      success: function (data) {
        if(data.result == true){
          notif = data.notification;
          if(notif.length > 0){
            $('.notificationBell').css('color','red');
            for(var i=0; i < notif.length; i++){
              var text = "";
              $.ajax({
                  url: BASE_URL + '/getNotificationDetails',
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: 'POST',
                  data: {
                    'id' : notif[i]['id']
                  },
                  dataType    :'json',
                  async : false,
                  success: function (data) {
                    if(data.result == true){
                      if(data.type == 2){
                        if(data.status == 1){
                          text = "<div class='alert alert-success'><strong>Good News!</strong> " + data.fname + " " + data.lname + " has completed your credit course request.</div>";
                        }
                      }else{
                        if(data.status == 1){
                          text = "<div class='alert alert-success'><strong>Good News!</strong> " + data.fname + " " + data.lname + " approves appointment.</div>";
                        }else if (data.status == 2) {
                          text = "<div class='alert alert-danger'><strong>Sorry!</strong> " + data.fname + " " + data.lname + " declines appointment.</div>";
                        }else if (data.status == 3) {
                          text = "<div class='alert alert-info'><strong>Hey!</strong> " + data.fname + " " + data.lname + " started your appointment.</div>";
                        }else{
                          text = "<div class='alert alert-warning'><strong>Hello!</strong> " + data.fname + " " + data.lname + " has completed your appointment.</div>";
                        }
                      }
                      message = message + text;
                    }
                  }
              });
            }
          }else{
            $('.notificationBell').css('color','white');
            message = "No updates.";
          }
          $('.toggle_notification').attr('data-content',message);

        }
      }
  });


  var notif_status = 0;

  $('.toggle_notification').on('click',function(){
    if(notif_status == 0){
      $.ajax({
          url: BASE_URL + '/updateNotificationStatus',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              notif_status = 1;
            }
          }
      });
      $('.notificationBell').css('color','white');
    }else{
      $.ajax({
          url: BASE_URL + '/getNotification',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {},
          dataType    :'json',
          success: function (data) {
            if(data.result == true){
              notif = data.notification
              var message = "";
              if(notif.length > 0){
                $('.notificationBell').css('color','red');
                for(var i=0; i < notif.length; i++){
                  var text = "";
                  text = "<div class='alert alert-info'><strong>New!</strong> " + notif[i]['fname'] + " " + notif[i]['lname'] + " is asking for an appointment.</div>";
                  message = message + text;
                }
              }else{
                message = "No updates.";
              }
              $('.toggle_notification').attr('data-content',message);
            }
          }
      });
      notif_status = 0;
    }
  });

});
