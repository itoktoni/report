<img width="200" style="position: absolute;left:1%;top:20px"
    src="{{ env('APP_LOGO') ? url('storage/'.env('APP_LOGO')) : url('assets/media/image/logo.png') }}"
    alt="logo">

<table border="0" class="header" style="margin-left: 20%">
	<tr>
		<td colspan="2"></td>
		<td colspan="10">
			<h3>
				<b>LAPORAN MUTASI KOTOR BERSIH</b>
			</h3>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td colspan="10">
			<h3>
				RUMAH SAKIT : {{ $model->field_rs ?? '' }}
			</h3>
		</td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td colspan="10">
			<h3>
				Tanggal : {{ $date->first() }} - {{ $date->last() }}
			</h3>
		</td>
	</tr>
</table>

<div class="table-responsive" id="table_data">
	<table border="1" style="border-collapse: collapse !important; border-spacing: 0 !important;"
		class="table table-bordered table-striped table-responsive-stack">
		<thead>
			<tr>
				<th rowspan="3" style="width:10px" width="1">No. </th>
				<th rowspan="3" style="width:200px" width="20">Nama Linen</th>
				@foreach($date as $key_name)
				<th class="text-center" colspan="4">TGL</th>
				@endforeach
				<th class="text-center" colspan="4">TOTAL KESELURUHAN</th>
			</tr>
			<tr>
				@foreach($date as $key_name)
				<th class="text-center" colspan="2">{{ Str::afterLast($key_name, '-') }}</th>
				<th class="text-center" colspan="2">SELISIH</th>
				@endforeach
				<th class="text-center" colspan="2">{{ Str::afterLast($date->first(), '-') }} - {{ Str::afterLast($date->last(), '-') }}</th>
				<th class="text-center" colspan="2">SELISIH</th>
			</tr>
			<tr>
				@foreach($date as $key_name)
				<th class="text-center">KOTOR</th>
				<th class="text-center">BERSIH</th>
				<th class="text-center">-</th>
				<th class="text-center">+</th>
				@endforeach
				<th class="text-center">KOTOR</th>
				<th class="text-center">BERSIH</th>
				<th class="text-center">-</th>
				<th class="text-center">+</th>
			</tr>
		</thead>
		<tbody>
			@php
			$total_kotor = $total_bersih = $total_kurang = $total_lebih = $grand_total_kotor = $grand_total_bersih = $grand_total_kurang = $grand_total_lebih = 0;
			@endphp
			@forelse($linen as $name => $table)
			@php
				$sum_kurang = $sum_lebih = 0;
			@endphp
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $name }}</td>

				@foreach($date as $key_name)

				@php
				$stock_bersih = $table->where(ViewMutasi::field_tanggal(), $key_name)->sum(ViewMutasi::field_stock_bersih());
				$stock_kotor = $table->where(ViewMutasi::field_tanggal(), $key_name)->sum(ViewMutasi::field_stock_kotor());
				$selisih = $table->where(ViewMutasi::field_tanggal(), $key_name)->sum(ViewMutasi::field_selisih());

				$selisih_kurang = $selisih < 0 ? $selisih : 0;
				$selisih_lebih = $selisih > 0 ? $selisih : 0;

				$sum_kurang = $sum_kurang + $selisih_kurang;
				$sum_lebih = $sum_lebih + $selisih_lebih;

				$total_kotor = $total_kotor + $stock_kotor;
				$total_bersih = $total_bersih + $stock_bersih;
				$total_kurang = $total_kurang + $selisih_kurang;
				$total_lebih = $total_lebih + $selisih_lebih;

				$grand_total_kotor = $grand_total_kotor + $stock_kotor;
				$grand_total_bersih = $grand_total_bersih + $stock_bersih;
				$grand_total_kurang = $grand_total_kurang + $selisih_kurang;
				$grand_total_lebih = $grand_total_lebih + $selisih_lebih;

				@endphp
					<td class="text-right">{{ showValue($stock_kotor) }}</td>
					<td class="text-right">{{ showValue($stock_bersih) }}</td>
					<td class="text-right">{{ $selisih < 0 ? $selisih : '' }}</td>
					<td class="text-right">{{ $selisih > 0 ? $selisih : '' }}</td>
				@endforeach

				<td class="text-right">{{ $table->sum(ViewMutasi::field_stock_kotor()) }}</td>
				<td class="text-right">{{ $table->sum(ViewMutasi::field_stock_bersih()) }}</td>
				<td class="text-right">{{ $sum_kurang }}</td>
				<td class="text-right">{{ $sum_lebih }}</td>
			</tr>
		@empty
		@endforelse
			<td class="text-left" colspan="2">Grand Total</td>
			<td class="text-right">{{ $total_kotor }}</td>
			<td class="text-right">{{ $total_bersih }}</td>
			<td class="text-right">{{ $total_kurang }}</td>
			<td class="text-right">{{ $total_lebih }}</td>
			<td class="text-right">{{ $grand_total_kotor }}</td>
			<td class="text-right">{{ $grand_total_bersih }}</td>
			<td class="text-right">{{ $grand_total_kurang }}</td>
			<td class="text-right">{{ $grand_total_lebih }}</td>
		</tbody>
	</table>
</div>

<table class="footer">
	<tr>
		<td colspan="2" class="print-date">Purwakarta, {{ date('d F Y') }}</td>
	</tr>
	<tr>
		<td colspan="2" class="print-person">{{ auth()->user()->name ?? '' }}</td>
	</tr>
</table>