<div id="event-detail">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="ti-eye"></i> Holiday Details</h4>
    </div>
    <div class="modal-body">
        <div class="form-body">
            <div class="row">
                <div class="col-xs-6 col-md-3 ">
                    <div class="form-group">
                        <label>Date</label>
                        <p>{{ $holiday->date->format("d-m-Y") }}</p>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label>Occasion</label>
                        <p>
                            {{ ucfirst($holiday->occassion) }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    </div>

</div>