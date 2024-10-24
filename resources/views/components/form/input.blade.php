@props(['type' => 'text', 'name', 'value' => '', 'label' => false])

@if ($label)
    <label for="">{{ $label }}</label>
@endif
<input type="{{ $type }}" name="{{ $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has('name')]) }} value="{{ old($name, $value) }}">
{{-- @if ($errors->has('name')) --}}
@error($name)
    {{-- <div class="text-danger">{{ $errors->first('name') }}</div> --}}
    <div class="text-danger">{{ $message }}</div>
@enderror


{{-- <input type="text" name="name" @class(['form-control', 'is-invalid' => $errors->has('name')]) value="{{ old('name', $value) }}"> --}}
{{-- @if ($errors->has('name')) --}}
{{-- @error('name') --}}
{{-- <div class="text-danger">{{ $errors->first('name') }}</div> --}}
{{-- <div class="text-danger">{{ $message }}</div>
@enderror --}}
