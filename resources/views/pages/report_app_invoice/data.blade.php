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
				<th style="width:250px" width="20">Nama Linen</th>
				@foreach($date as $key_name)
				<th class="text-center">{{ Str::afterLast($key_name, '-') }}</th>
				@endforeach
				<th style="text-align: right">Qty</th>
				<th style="text-align: right">Berat (Kg)</th>
				<th style="text-align: right">Total (Kg)</th>
				<th style="text-align: right">Harga</th>
				<th style="width:100px;text-align:right" class="text-center">Total Invoice</th>
			</tr>
		</thead>
		<tbody>
			@php
			$total_berat = 0;
			@endphp

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
				$berat = $summary->field_berat ?? 0;
				$total_berat = $total_berat + $berat;
				$harga = $summary->field_harga ?? 0;
				$total_harga = $table->sum(ViewInvoice::field_invoice()) ?? 0;
				@endphp
				<td style="text-align:right">{{ $table->sum(ViewInvoice::field_qty()) }}</td>
				<td style="text-align:right">{{ $berat }}</td>
				<td style="text-align:right">{{ $table->sum(ViewInvoice::field_total_berat()) }}</td>
				<td style="text-align:right">{{ number_format($harga) }}</td>
				<td style="text-align:right">{{ number_format($total_harga) }}</td>

			</tr>
		@empty
		@endforelse
		<tr>
			<td colspan="2">Grand Total</td>
			@foreach($date as $key_name)
			@php
				$total_qty = $data->where(ViewInvoice::field_tanggal(), $key_name)->sum(ViewInvoice::field_qty());
			@endphp
			<td>{{ $total_qty }}</td>
			@endforeach

			@php
				$total_invoice = $data->sum(ViewInvoice::field_invoice());
			@endphp
			<td style="text-align: right">{{ $data->sum(ViewInvoice::field_qty()) }}</td>
			<td style="text-align: right">{{ number_format($total_berat) }}</td>
			<td style="text-align: right">{{ $data->sum(ViewInvoice::field_total_berat()) }}</td>
			<td style="text-align: right">{{ number_format($summary->field_harga) ?? 0 }}</td>
			<td style="text-align: right">{{ number_format($total_invoice) }}</td>

		</tr>

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