<div class="modal fade" id="studApDetailsModal" role="dialog" style="width: 100%">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Student Appeal on Course Grade Tracker</h3>
      </div>
      <div class="modal-body">

        <div class="container">
          <div class="row">
            <label>Transaction Number:</label>
            <span id="transaction_no"></span>
          </div>
          <div class="row">
            <label>Specific Concern/s:</label>
            <span id="specific_concern"></span>
          </div>
          <div class="row">
            <label>Remarks:</label>
            <span id="remarks"></span>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <h4>Status Tracker</h4>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-4" style="">
            </div>
            <div class="col-md-3" style="">
              <label>Date</label>
            </div>
            <div class="col-md-3" style="">
              <label>Status</label>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-4" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;" id="firstStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 1:</label> <br>Submitted the Form
                </div>
              </div>
            </div>
            <div class="col-md-3" style="">
              <span id="firstStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="firstStepText"></span>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-4" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;" id="secondStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 2:</label> <br>Evaluated by the Director
                </div>
              </div>
            </div>
            <div class="col-md-3" style="">
              <span id="secondStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="secondStepText"></span>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-4" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;" id="thirdStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 3:</label> <br>Online Conference
                </div>
              </div>
            </div>
            <div class="col-md-3" style="">
              <span id="thirdStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="thirdStepText"></span>
            </div>
          </div>
          <div class="row" style="margin-bottom: 1%">
            <div class="col-md-4" style="">
              <div class="row">
                <div class="col-md-1">
                  <div style="width: 25px; height: 25px; background-color: gray; border-radius: 50%;"  id="fourthStep"></div>
                </div>
                <div class="col-md-11">
                  <label>Step 4:</label> <br>Transaction Done
                </div>
              </div>
            </div>
            <div class="col-md-3" style="">
              <span id="fourthStepDate"></span>
            </div>
            <div class="col-md-3" style="">
              <span id="fourthStepText"></span>
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

<div id="remarksModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject Appointment</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="usr">Reason:</label>
          <textarea class="form-control" id="reasonDetails" style="resize: none"></textarea>
          <input type="hidden" id="remarks_appeal_slug">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitRemarks">Submit</button>
      </div>
    </div>

  </div>
</div>
