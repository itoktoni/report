<x-layout>
    <x-card>
        <x-form :model="$model" :upload="true">
            <x-action form="empty">
                <x-button onclick="return confirm('Apakah anda yakin ingin mengupload ?')" type="submit" color="primary" label="Upload"/>
            </x-action>

            @bind($model)
                <x-form-input col="4" type="date" value="{{ date('Y-m-d') }}" label="Tanggal" name="tanggal" />
                <x-form-upload col="4" name="file_bersih" />
                <x-form-upload col="4" name="file_kotor" />
            @endbind

        </x-form>
    </x-card>
</x-layout>
