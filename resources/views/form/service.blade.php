<div class="row mb-2">
    <div class="col-md-2 text-end">
        <label for="select_{{ $field_unique_id }}" class="form-label">
        {{ $field['required'] ? '*' : ''  }}      
        {{ $field_data['label'] }} :</label>
    </div>
    <div class="col-md-6">
        <select class="form-control select-category" id="select_{{ $field_unique_id }}" name="{{ $field['input_name'] }}"  data-required="{{ $field['required'] }}"  {{ $field['required'] ? 'required' : ''  }} >
            <option value="">Select a service</option>
        </select>
    </div>
    <span id="error_{{ $field_unique_id }}"></span>
</div>