<x-layout>
    <x-card>

        <x-form method="GET" action="{{ moduleRoute('getPrint') }}">

            <x-action>
                <x-button type="submit" label="Sort" name="sort" />
            </x-action>

            <div class="container">
                <div class="table-responsive" id="table_data">
                    @include('pages.bersih.data')
                </div>
            </div>
        </x-form>
    </x-card>
</x-layout>
