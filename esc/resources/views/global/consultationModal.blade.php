<div class="modal fade" id="requestModal" role="dialog" style="width: 100%">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Appointment Details</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label for="pwd">Student Name:</label>
              <span id="student_name"></span>
            </div>
            <div class="col-md-6">
              <label for="pwd">Email</label>
              <span id="student_email"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="pwd">Date:</label>
              <span id="appointment_date"></span>
            </div>
            <div class="col-md-6">
              <label for="pwd">Time</label>
              <span id="appointment_time"></span>
            </div>
          </div>
          @if($user_type == 1||$user_type == 2)
            @if($status > 0)
              <div class="row form-group" style="margin-bottom: 1%">
                <div class="col-md-4">
                  <label>Online Meeting Link</label>
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    <input type="text" class="form-control" id="meetingLink" name="meetingLink">
                </div>
                <div class="col-md-2">
                  <label style="color: white">Test</label><br>
                  <button class="btn btn-primary saveLink">Save Link</button>
                </div>
                <div class="col-md-6 remarksDiv">
                  <label>Remarks</label><br>
                  <span id="remarksSpan"></span>
                </div>
              </div>
            @endif
          @else
          <div class="row form-group" style="margin-bottom: 1%">
            <div class="col-md-6">
              <label>Online Meeting Link</label>
              <input type="text" class="form-control" id="meetingLink" name="meetingLink" readonly>
            </div>
            <div class="col-md-6">
              <label>Remarks</label>
              <textarea class="form-control" readonly id="remarksDetail" style="resize: none">
              </textarea>
            </div>
          </div>
          @endif
          <div class="row">
            <div class="col-md-12">
              <h4>Status Tracker</h4>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-5" style="">
            </div>
            <div class="col-md-4" style="">
              <label>Date</label>
            </div>
            <div class="col-md-3" style="">
              <label>Status</label>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-5" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;" id="firstStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 1:</label> <br>Submitted the Form
                </div>
              </div>
            </div>
            <div class="col-md-4" style="">
              <span id="firstStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="firstStepText"></span>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-5" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;" id="secondStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 2:</label> <br>Evaluated by the Professor
                </div>
              </div>
            </div>
            <div class="col-md-4" style="">
              <span id="secondStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="secondStepText"></span>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-5" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;" id="thirdStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 3:</label> <br>Online Conference
                </div>
              </div>
            </div>
            <div class="col-md-4" style="">
              <span id="thirdStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="thirdStepText"></span>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-5" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;"  id="fourthStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 4:</label> <br>Appointment Done
                </div>
              </div>
            </div>
            <div class="col-md-4" style="">
              <span id="fourthStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="fourthStepText"></span>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="remarksModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject Appointment</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="usr">Reason:</label>
          <textarea class="form-control" id="reasonDetails" style="resize: none"></textarea>
          <input type="hidden" id="remarks_appointment_id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitRemarks">Submit</button>
      </div>
    </div>

  </div>
</div>
