<x-layout>
    <x-card>
        <x-form :model="$model">
            <x-action form="form" />

            @bind($model)

                <x-form-input col="4" name="linen_nama" />
                <x-form-select col="6" class="search" name="linen_nama_rs" :options="$rs" />
                <x-form-input col="2" name="linen_berat" />

			@endbind

        </x-form>
    </x-card>
    <x-script-form />
</x-layout>
