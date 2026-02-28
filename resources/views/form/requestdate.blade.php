<div class="row mb-3 align-items-center">

    {{-- Label --}}
    {!! $label !!}

    {{-- Input / View Column --}}
    <div class="col-md-6">

        @if(!$isView)
        <input type="text" class="form-control" value="{{ date('M d, Y') }}" disabled>
        <input type="hidden" class="form-control" data-required="{{ $field['required'] ?? 0 }}" id="input_{{ $field_unique_id }}" name="{{ $field['input_name'] }}" value="{{ date('Y-m-d') }}" readonly>
        @else

        {{-- VIEW MODE --}}
        <div class="show-record fw-semibold">
            ₱ {{ number_format($record[$field['input_name']] ?? 0, 2) }}
        </div>

        {{-- EDIT MODE (Hidden Initially) --}}
        <div class="edit-record d-none">

            <input type="text" class="form-control" value="{{  $record[$field['input_name']] }}" disabled>
            <input type="hidden" class="form-control" data-required="{{ $field['required'] ?? 0 }}" id="input_{{ $field_unique_id }}" name="{{ $field['input_name'] }}" value="{{  $record[$field['input_name']] }}" readonly>
        </div>
        @endif

        {{-- Error Message --}}
        <small id="error_{{ $field_unique_id }}"
            class="text-danger d-block mt-1"></small>

    </div>
</div>
