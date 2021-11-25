<div class="modal fade" id="studApEvaluationLevel2Modal" role="dialog" style="width: 100%">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Evaluation Level 2 of Student Appeal on Course Grade</h3>
      </div>
      <div class="modal-body">
        
        <div class="container">
          <div class="row">
            <div class="col-md-5">
              <div class="row">
                <label>Transaction Number:</label>
                <span id="transaction_number-2"></span>
              </div>
              <div class="row">
                <label>Student ID:</label>
                <span id="student_id-2"></span>
              </div>
              <div class="row">
                <label>Student Name:</label>
                <span id="student_name-2"></span>
              </div>       
              <br>

              <div class="row">
                <label>Submitted Attachments:</label><br>
                <span style="display:none" id="attached1-2"><br></span>
                <span style="display:none" id="attached2-2"><br></span>
                <span style="display:none" id="attached3-2"></span>
              </div>    
              <br>

              @if(session()->has('message'))
                <div class="alert-danger" style="color:#FF0000;">
                   session()->get('message') }}
                </div>
              @endif
              @if(session()->has('emessage'))
                <div class="alert-danger" style="color:#00FF00;">
                   session()->get('emessage') }}
                </div>
              @endif
              <br>
              
              <form id="student-appeal-eval" action="{{ URL::to('director/postMeeting') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input class="form-control" id="level" type="hidden" name="level" value="2">
                <input class="form-control" id="appeal_id-2" type="hidden" name="appeal_id">
                <div class="row">
                  <div class="col-md-10">
                    <label>Email of Professor:</label>
                    <input class="form-control" id="prof_email-2" type="email" name="prof_email" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-10">
                    <label>Date:</label>
                    <input class="form-control" id="eval-course-grade-form-time2-2" type="date" name="date" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <label>Start Time:</label>
                    <input type="time" class="form-control" id="start-2" name="start" min="07:00" max="19:00" step="600" required>
                  </div>
                  <div class="col-md-5">
                    <label>End Time:</label>
                    <input type="time" class="form-control" id="end-2" name="end" min="08:00" max="19:00" step="600" required>
                  </div>
                </div>
                  
                <div class="row">
                  <div class="col-md-10">
                    <label>Input Message and Link for the conference:</label><br>
                    <textarea class="form-control" id="message-2" name="message" rows="5" cols="40" required></textarea>
                  </div>
                </div>
                <br>
      
                <button id="submitStudentAppealEval" class="btn btn-primary" name="confirm" type="submit" value="Button">Confirm</button>
              </form>
            </div>
            <div class="col-md-6">
              <div class="row">
                <label>Preview</label>
                <br>
                <object id="objectViewDocumentPDF-2" type="application/pdf" width="330" height="480">
                  <embed id="embedViewDocumentPDF-2" type="application/pdf" width="330" height="480">
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