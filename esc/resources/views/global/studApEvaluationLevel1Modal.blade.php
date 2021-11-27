<div class="modal fade" id="studApEvaluationLevel1Modal" role="dialog" style="width: 100%">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Evaluation Level 1 of Student Appeal on Course Grade</h3>
      </div>
      <div class="modal-body">
        
        <div class="container">
          <div class="row">
            <div class="col-md-5">
              <div class="row">
                <label>Transaction Number:</label>
                <span id="transaction_number"></span>
              </div>
              <div class="row">
                <label>Student ID:</label>
                <span id="student_id"></span>
              </div>
              <div class="row">
                <label>Student Name:</label>
                <span id="student_name"></span>
              </div>       
              <br>

              <div class="row">
                <label>Submitted Attachments:</label><br>
                <span style="display:none" id="attached1"><br></span>
                <span style="display:none" id="attached2"><br></span>
                <span style="display:none" id="attached3"></span>
              </div>    
              <br>
              
              <!-- <form id="student-appeal-eval" action="{{ URL::to('director/postMeeting') }}" method="post" enctype="multipart/form-data">
                @csrf -->
                <input class="form-control" id="level" type="hidden" name="level" value="1">
                <input class="form-control" id="appeal_id" type="hidden" name="appeal_id">
                <div class="row">
                  <div class="col-md-10">
                    <label>Date:</label>
                    <input class="form-control" id="date" type="date" name="date" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <label>Start Time:</label>
                    <div class='input-group date datetimepicker2' onclick="validateAppointmentTimeLevel1('start')">
                      <input type='text' class="form-control" id="start" name="start" required />
                      <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <label>End Time:</label>
                    <div class='input-group date datetimepicker3' onclick="validateAppointmentTimeLevel1('end')">
                      <input type='text' class="form-control" id="end" name="end" required/>
                      <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                </div>
                  
                <div class="row">
                  <div class="col-md-10">
                    <label>Input Message and Link for the conference:</label><br>
                    <textarea class="form-control" id="message" name="message" rows="5" cols="40" required></textarea>
                  </div>
                </div>
                <br>
      
                <button id="submitStudentAppealEval" class="btn btn-primary" name="confirm" type="submit" value="Button">Confirm</button>
              <!-- </form> -->
              <br>
              <br>
              <div class="alert alert-success" style="display: none" id="successNotification">
                  Appointment was successfully submitted. Wait for further updates.
              </div>
              <div class="alert alert-danger" style="display: none" id="failedNotification">
                  <span id="failedText"></span>
              </div>
              <div class="alert alert-danger" style="display: none" id="failedNotificationTime">
                  <span id="failedTextTime"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <label>Preview</label>
                <br>
                <object id="objectViewDocumentPDF" type="application/pdf" width="330" height="480">
                  <embed id="embedViewDocumentPDF" type="application/pdf" width="330" height="480">
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