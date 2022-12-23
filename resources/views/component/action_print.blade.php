@if(request()->get('action') == 'excel')
@php
header('Content-Type: application/force-download');
header('Content-disposition: attachment; filename=excel.xls');
// Fix for crappy IE bug in download.
header("Pragma: ");
header("Cache-Control: ");
@endphp
@else
<div class="header-action">
    <nav>
        <a onclick="window.print()" href="{{ route(SharedData::get('route').'.getPrint') }}">Print PDF</a>
        <a href="{{ url()->full().'&action=excel' }}">Excel</a>
        <a href="{{ route(SharedData::get('route').'.getCreate') }}">Back</a>
    </nav>
</div>
@endif
