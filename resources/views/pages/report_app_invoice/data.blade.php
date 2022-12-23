<table border="0" class="header">
	<tr>
		<td></td>
		<td colspan="10">
			<h3>
				<b>LAPORAN INVOICE</b>
			</h3>
		</td>
		<td rowspan="3">
			<img width="200" style="position: absolute;left:40%;top:20px" src="{{ env('APP_LOGO') ? url('storage/'.env('APP_LOGO')) : url('assets/media/image/logo.png') }}" alt="logo">
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
				Periode : {{ $date->first() }} - {{ $date->last() }}
			</h3>
		</td>
	</tr>
</table>

<div class="table-responsive" id="table_data">
	<table id="export" border="1" style="border-collapse: collapse !important; border-spacing: 0 !important;"
		class="table table-bordered table-striped table-responsive-stack">
		<thead>
			<tr>
				<th width="1">No. </th>
				<th style="width:200px" width="20">Nama Linen</th>
				@foreach($date as $key_name)
				<th class="text-center">{{ Str::afterLast($key_name, '-') }}</th>
				@endforeach
				<th class="text-center">Qty</th>
				<th class="text-center">Berat (Kg)</th>
				<th class="text-center">Total (Kg)</th>
				<th class="text-center">Harga</th>
				<th style="width:100px;text-right" class="text-center">Total Invoice</th>
			</tr>
		</thead>
		<tbody>
			@forelse($linen as $name => $table)

			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $name }}</td>

				@foreach($date as $key_name)

				@php
				$qty = $table->where(ViewInvoice::field_tanggal(), $key_name)->sum(ViewInvoice::field_qty());
				@endphp
				<td class="text-right">{{ showValue($qty) }}</td>
				@endforeach

				@php
				$summary = $table->first();
				@endphp
				<td>{{ $table->sum(ViewInvoice::field_qty()) }}</td>
				<td>{{ $summary->field_berat }}</td>
				<td>{{ $table->sum(ViewInvoice::field_total_berat()) }}</td>
				<td>{{ $summary->field_harga }}</td>
				<td>{{ $table->sum(ViewInvoice::field_invoice()) }}</td>

			</tr>
		@empty
		@endforelse
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