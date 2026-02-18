
@if($isView == 0)
<div class="row mb-2">
    <div class="col-md-2 text-end">
        <label for="input_{{ $field_unique_id }}" class="form-label">
        {{ $field['required'] ? '*' : ''  }}      
        {{ $field_data['label'] }} :</label>
       
    </div>
    <div class="col-md-6">
      <input type="text" class="form-control" value="{{ date('M d, Y') }}" disabled>

        <input type="hidden" 
        class="form-control" 
        data-required="{{ $field['required'] ?? 0 }}"
        id="input_{{ $field_unique_id }}" 
        name="{{ $field['input_name'] }}" 
        value="{{ date('Y-m-d') }}" readonly>
    </div>
    <span id="error_{{ $field_unique_id }}"></span>
</div>  
@else
<div class="row mb-2">
    <div class="col-md-2 text-end">
        <label for="input_{{ $field_unique_id }}" class="form-label">
        {{ $field['required'] ? '*' : ''  }}      
        {{ $field_data['label'] }} :</label>
       
    </div>
      <div class="col-md-6">
         {{ $value ?? 0}}
      </div>
  
</div>
@endif