<img width="200" style="position: absolute;left:1%;top:20px"
    src="{{ env('APP_LOGO') ? url('storage/'.env('APP_LOGO')) : url('assets/media/image/logo.png') }}"
    alt="logo">

<table border="0" class="header" style="margin-left: 20%">
    <tr>
        <td></td>
        <td colspan="10">
            <h3>
                LAPORAN SERAH TERIMA LINEN BERSIH
            </h3>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="10">
            <h3>
                RUMAH SAKIT : {{ $model->field_rs ?? '' }}
            </h3>
        </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="10">
            <h3>
                Tanggal : {{ date('d F Y') }}
            </h3>
        </td>
    </tr>
</table>

<div class="table-responsive" id="table_data">
    <table border="1" style="border-collapse: collapse;"
        class="table table-bordered table-striped table-responsive-stack">
        <thead>
            <tr>
                <th style="width: 10px" width="1">No. </th>
                <th style="width: 200px" width="20">Nama Linen</th>
                @foreach($location as $loc_name => $loc)
                    <th>{{ Str::replace(' ','_', $loc_name) }}</th>
                @endforeach
                <th>Total Bersih</th>
                <th>Total Kotor</th>
                <th>-</th>
                <th>+</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_kurang = $sum_lebih = 0;
            @endphp
            @forelse($linen as $name => $table)
                @php
                    $total_bersih = $table->count();
                    // $total_kotor = $kotor->where('kotor_nama_linen', $name)->sum('kotor_stock') ?? 0;
                    // $total_kotor = $linen_kotor[$name]->sum('kotor_stock') ?? 0;
                    $total_kotor = isset($linen_kotor[$name]) ? $linen_kotor[$name]->sum('kotor_stock') : 0;
                    $selisih = $total_bersih - $total_kotor;
                    $selisih_kurang = $selisih < 0 ? $selisih : 0; $selisih_lebih=$selisih> 0 ? $selisih : 0;
                        $sum_kurang = $sum_kurang + $selisih_kurang;
                        $sum_lebih = $sum_lebih + $selisih_lebih;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $name }}</td>
                    @foreach($location as $loc_name => $loc)
                        <td>
                            @php
                                $total_lokasi = $table->where('bersih_lokasi', $loc_name)->count();
                            @endphp
                            {{ $total_lokasi > 0 ? $total_lokasi : '' }}
                        </td>
                    @endforeach
                    <td>{{ $total_bersih }}</td>
                    <td>
                        {{ $total_kotor }}
                    </td>
                    <td>{{ $selisih < 0 ? $selisih : '' }}</td>
                    <td>{{ $selisih > 0 ? $selisih : '' }}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
        <tr>
            <td colspan="2">Total</td>
            @foreach($location as $loc_name => $loc)
                <td>
                    {{ $loc->count() }}
                </td>
            @endforeach
            <td>
                {{ $bersih->count('bersih_no_rfid') }}
            </td>
            <td>
                {{ $kotor->sum('kotor_stock') }}
            </td>
            <td>
                {{ $sum_kurang }}
            </td>
            <td>
                {{ $sum_lebih }}
            </td>
        </tr>
    </table>
</div>
