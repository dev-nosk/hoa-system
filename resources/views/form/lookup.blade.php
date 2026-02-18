
<div class="row mb-2">
    <div class="col-md-2 text-end">
        <label for="input_{{ $field_unique_id }}" class="form-label">

        {{ $field['required'] ? '*' : ''  }}  
             {{ $field_data['label'] }} :
        
        </label>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <input type="text"
                id="lookup_display_{{ $field_unique_id }}"
                class="form-control "
                placeholder="select-user" disabled>
            <button class="btn btn-primary" type="button" id="lookup-btn" data-targetid="{{ $field_unique_id }}"><i class="fa fa-user"></i></button>
        </div>
        <input type="hidden" class="form-control"  data-required="{{ $field['required'] ?? 0 }}" id="input_{{ $field_unique_id }}" name="{{ $field['input_name'] }}" " value=""  {{ $field['required'] ? 'required' : ''  }}  readonly>
    </div> 
    <span id="error_{{ $field_unique_id }}"></span>
</div>

<div class="modal fade" id="lookupModal" tabindex="-1" aria-labelledby="lookupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lookupModalLabel">Select User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="userTable" class="table table-striped table-bordered table-hover" style="width:100%;cursor:pointer">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
           
            </tr>
          </thead>
          <tbody>
            <!-- Filled via DataTables AJAX -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
