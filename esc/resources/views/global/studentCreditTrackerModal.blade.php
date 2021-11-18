<div class="modal fade" id="studentCreditTrackerModal" role="dialog" style="width: 100%">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Appointment Details</h4>
      </div>
      <div class="modal-body"><div class="row">
          <div class="col-md-6">
              <label>Student ID:</label>
              <span id="current_student_id"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Student Name:</label>
              <span id="student_name"></span>
            </div>
            <div class="col-md-6">
              <label>New Program<br>to Enroll:</label>
              <span id="new_program"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Institute/College<br>coming from:</label>
              <span id="institute"></span>
            </div>
            <div class="col-md-6">
              <label>Original Program:</label>
              <span id="original_program"></span>
            </div>
          </div>
          <div class="row form-group" style="margin-bottom: 1%">
            <div class="col-md-12">
              <label>Remarks</label>
              <textarea class="form-control" readonly id="remarksDetail" style="resize: none; height: 150px;" cols="10">
              </textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h4>Status Tracker</h4>
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
                  <label>Step 2:</label> <br>Evaluated by Department Chair
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
                  <label>Step 3:</label> <br>Evaluated by Dean
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
                  <label>Step 4:</label> <br>Evaluated by Registrar
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
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-5" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;"  id="fifthStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 5:</label> <br>Transaction Done
                </div>
              </div>
            </div>
            <div class="col-md-4" style="">
              <span id="fifthStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="fifthStepText"></span>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
