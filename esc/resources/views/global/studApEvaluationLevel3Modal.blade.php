<div class="modal fade" id="studApEvaluationLevel3Modal" role="dialog" style="width: 100%">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Evaluation Level 3 of Student Appeal on Course Grade</h3>
      </div>
      <div class="modal-body">
        
        <div class="container">
          <div class="row">
            <div class="col-md-5">
              <div class="row">
                <label>Transaction Number:</label>
                <span id="transaction_number-3"></span>
              </div>
              <div class="row">
                <label>Student ID:</label>
                <span id="student_id-3"></span>
              </div>
              <div class="row">
                <label>Student Name:</label>
                <span id="student_name-3"></span>
              </div>       
              <br>

              <div class="row">
                <label>Submitted Attachments:</label><br>
                <span style="display:none" id="attached1-3"><br></span>
                <span style="display:none" id="attached2-3"><br></span>
                <span style="display:none" id="attached3-3"></span>
              </div>    
              <br>
              
              <!-- <form id="student-appeal-eval-3" action="{{ URL::to('director/postMeeting') }}" method="post" enctype="multipart/form-data">
                @csrf -->
                <input class="form-control" id="level-3" type="hidden" name="level" value="3">
                <input class="form-control" id="appeal_id-3" type="hidden" name="appeal_id">
                <div class="row">
                  <div class="col-md-10">
                    <label>Email of Professor:</label>
                    <input class="form-control" id="prof_email-3" type="email" name="prof_email" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-10">
                    <label>Date:</label>
                    <input class="form-control" id="date-3" type="date" id="start" name="date" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <label>Start Time:</label>
                    <div class='input-group date datetimepicker2' onclick="validateAppointmentTimeLevel3('start')">
                      <input type='text' class="form-control" id="start-3" name="start" required />
                      <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <label>End Time:</label>
                    <div class='input-group date datetimepicker3' onclick="validateAppointmentTimeLevel3('end')">
                      <input type='text' class="form-control" id="end-3" name="end" required/>
                      <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                </div>
                  
                <div class="row">
                  <div class="col-md-10">
                    <label>Input Message and Link for the conference:</label><br>
                    <textarea class="form-control" id="message-3" name="message" rows="5" cols="40" required></textarea>
                  </div>
                </div>
                <br>
      
                <button id="submitStudentAppealEval-3" class="btn btn-primary" name="confirm" type="submit" value="Button">Confirm</button>
              <!-- </form> -->
              <br>
              <br>
              <div class="alert alert-success" style="display: none" id="successNotification-3">
                  Appointment was successfully submitted. Wait for further updates.
              </div>
              <div class="alert alert-danger" style="display: none" id="failedNotification-3">
                  <span id="failedText-3"></span>
              </div>
              <div class="alert alert-danger" style="display: none" id="failedNotificationTime-3">
                  <span id="failedTextTime-3"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <label>Preview</label>
                <br>
                <object id="objectViewDocumentPDF-3" type="application/pdf" width="330" height="480">
                  <embed id="embedViewDocumentPDF-3" type="application/pdf" width="330" height="480">
                </object>
              </div>
            </div>
          </div>
        </div>
        
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>

  </div>
</div>