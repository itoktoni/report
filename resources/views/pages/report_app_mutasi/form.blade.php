<x-layout>
    <x-card>
        <x-form :model="$model" :spa="false" target="_blank"  method="GET" action="{{ moduleRoute('getPrint') }}" :upload="true">
            <x-action form="print" />

            @bind($model)
                <input type="hidden" name="report_name" value="Lap Mutasi">
                <x-form-input col="3" type="date" value="{{ date('Y-m-d') }}" label="Tanggal Awal" name="start_date" />
                <x-form-input col="3" type="date" value="{{ date('Y-m-d') }}" label="Tanggal Akhir" name="end_date" />
                <x-form-select col="6" name="nama_rs" :options="$rs" />
            @endbind

        </x-form>
    </x-card>
</x-layout>
