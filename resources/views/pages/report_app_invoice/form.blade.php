<x-layout>
    <x-card>
        <x-form :model="$model" :spa="false" target="_blank"  method="GET" action="{{ moduleRoute('getPrint') }}" :upload="true">
            <x-action form="print" />
                <input type="hidden" name="report_name" value="Laporan Invoice {{ request()->get('nama_rs') }}">
                <x-form-input col="3" type="date" label="Tanggal Awal" name="start_date" />
                <x-form-input col="3" type="date" label="Tanggal Akhir" name="end_date" />
                <x-form-select col="6" name="view_nama_rs" :options="$rs" />
            @endbind

        </x-form>
    </x-card>
</x-layout>
