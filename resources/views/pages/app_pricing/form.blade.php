<x-layout>
    <x-card>
        <x-form :model="$model">
            <x-action form="form" />

            @bind($model)

                <x-form-select col="6" hx-get="{{ moduleRoute('xgetLinenByRs') }}" hx-target="#linen" name="pricing_rs" :options="$rs ?? []" />
                <x-form-select col="6" id="linen" name="pricing_nama" :options="$linen" />
                <x-form-input col="6" name="pricing_harga" />
                <x-form-input col="6" name="pricing_berat" />

			@endbind

        </x-form>
    </x-card>
    <x-script-form />
</x-layout>
