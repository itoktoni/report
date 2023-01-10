<x-layout>
    <x-card>
        <x-form :model="$model">
            <x-action form="form" />

            @bind($model)

                <x-form-input col="6" name="linen_nama" />
                <x-form-input col="6" name="linen_berat" />

			@endbind

        </x-form>
    </x-card>
    <x-script-form />
</x-layout>
