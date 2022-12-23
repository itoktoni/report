<option value=>- Silahkan pilih -</option>
@foreach ($linen as $item)
    <option value="{{ $item->field_name }}">{{ $item->field_name }}</option>
@endforeach