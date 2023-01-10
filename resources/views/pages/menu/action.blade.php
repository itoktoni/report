<option value=>- Silahkan pilih -</option>
@foreach ($action as $key => $item)
    <option value="{{ $key }}">{{ $item }}</option>
@endforeach