<div class="modal fade" id="studApEvaluationModal" role="dialog" style="width: 100%">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Evaluation of Student Appeal on Course Grade</h3>
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
                <input class="form-control" id="appeal_id" type="hidden" name="appeal_id">
                <div class="row">
                  <div class="col-md-10">
                    <label>Date:</label>
                    <input class="form-control" id="eval-course-grade-form-time2" type="date" id="start" name="date" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <label>Start Time:</label>
                    <input type="time" class="form-control" id="start" name="start" min="07:00" max="19:00" step="600" required>
                  </div>
                  <div class="col-md-5">
                    <label>End Time:</label>
                    <input type="time" class="form-control" id="end" name="end" min="08:00" max="19:00" step="600" required>
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
              </form>
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