
<div class="row mb-2">
    <div class="col-md-2 text-end">
        <label for="input_{{ $field_unique_id }}" class="form-label">
            {{ $field['required'] ? '*' : ''  }}
            {{ $field_data['label'] }} :</label>
    </div>
    <div class="col-md-6">
        <input type="text"
            class="form-control text-end amount-input"
            id="input_{{ $field_unique_id }}"
           name="{{ $field['input_name'] }}" 
             data-required="{{ $field['required'] ?? 0 }}"
            placeholder="0.00">
    </div>
    <span id="error_{{ $field_unique_id }}"></span>
</div>
