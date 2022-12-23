<x-layout>
    <x-card>
        <x-form :model="$model" :upload="true">
            <x-action form="form" />

            @bind($model)
                <x-form-upload col="6" name="file_bersih" />
                <x-form-upload col="6" name="file_kotor" />
            @endbind

        </x-form>
    </x-card>
</x-layout>
