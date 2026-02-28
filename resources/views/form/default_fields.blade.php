<div class="row mb-3 align-items-center">

    {{-- Label --}}
    {!! $label !!}

    {{-- Input / View Column --}}
    <div class="col-md-6">

        @if(!$isView)

            <input type="text"
                   class="form-control text-end amount-input"
                   id="input_{{ $field_unique_id }}"
                   name="{{ $field['input_name'] }}"
                   value="{{ $value ?? '' }}"
                   data-required="{{ $field['required'] ?? 0 }}"
                   placeholder="#">

        @else

            {{-- VIEW MODE --}}
            <div class="show-record fw-semibold">
                 {{$record[$field['input_name']] ?? '' }}
            </div>

            {{-- EDIT MODE (Hidden Initially) --}}
            <div class="edit-record d-none">
                <input type="text"
                       class="form-control text-end amount-input"
                       id="input_{{ $field_unique_id }}"
                       name="{{ $field['input_name'] }}"
                       value="{{ $record[$field['input_name']] ?? '' }}"
                       data-required="{{ $field['required'] ?? 0 }}"
                       placeholder="">
            </div>

        @endif

        {{-- Error Message --}}
        <small id="error_{{ $field_unique_id }}" 
               class="text-danger d-block mt-1"></small>

    </div>
</div>