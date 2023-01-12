<?php

namespace App\Http\Requests;

use App\Dao\Models\AppBersih;
use App\Dao\Models\AppKotor;
use App\Dao\Models\AppUpload;
use App\Dao\Traits\ValidationTrait;
use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Plugins\Query;
use Spatie\SimpleExcel\SimpleExcelReader;

class AppUploadRequest extends FormRequest
{
    use ValidationTrait;

    public $header = [];
    public $kotor = [];
    public $bersih = [];
    public $location = [];
    public $rs;
    public $tanggal_kotor;
    public $tanggal_bersih;

    public function validation(): array
    {
        return [
            'file_bersih' => 'required|mimes:xlsx',
            'file_kotor' => 'required|mimes:xlsx',
            'tanggal' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $auto_number = Query::autoNumber((new AppBersih())->getTable(), AppBersih::field_upload(), 'U' . date('Ymd'));
            // $this->fastExcel($auto_number);
            $this->importBersih($auto_number);
            $this->importKotor($auto_number);
            return $this->merge([
                'bersih' => $this->bersih,
                'kotor' => $this->kotor,
                AppUpload::field_tanggal() => $this->tanggal_bersih,
                AppUpload::field_name() => $auto_number,
                AppUpload::field_rs() => $this->rs,
            ]);
        }
    }

    private function toDate($date)
    {
        if ($date instanceof DateTimeImmutable) {
            return date_format($date, "Y-m-d");
        } else if (is_string($date)) {

            $date = explode('/', $date);
            $tanggal = $date[0];
            $bulan = $this->toMonth($date[1]);
            $tahun = $date[2];
            return $tahun . '-' . $bulan . '-' . $tanggal;
        } else {
            return date('Y-m-d');
        }
    }

    private function toMonth($month)
    {
        $number = null;
        switch ($month) {
            case 'Jan':
                $number = 1;
                break;
            case 'Feb':
                $number = 2;
                break;
            case 'Mar':
                $number = 3;
                break;
            case 'Apr':
                $number = 4;
                break;
            case 'Mei':
                $number = 5;
                break;
            case 'Jun':
                $number = 6;
                break;
            case 'Jul':
                $number = 7;
                break;
            case 'Aug':
                $number = 8;
                break;
            case 'Sep':
                $number = 9;
                break;
            case 'Oct':
                $number = 10;
                break;
            case 'Nov':
                $number = 11;
                break;
            case 'Des':
                $number = 12;
                break;
            default:
                $number = null;
        }

        return $number;
    }

    private function fastExcel($auto_number)
    {
        $collection = fastexcel()->withoutHeaders()->import(request()->file('file_bersih'));
        for ($i = 1; $i < $collection->count(); $i++) {
            if ($collection[$i][5] instanceof DateTimeImmutable) {
                $no_transaksi = $collection[$i][1];
                $nama_rs = $collection[$i][2];
                $nama_lokasi = $collection[$i][3];
                $total_pcs = $collection[$i][4];
                $tanggal = $collection[$i][5];

                $this->header = [
                    AppBersih::field_transaksi() => $no_transaksi,
                    AppBersih::field_rs() => $nama_rs,
                    AppBersih::field_lokasi() => $nama_lokasi,
                    AppBersih::field_tanggal() => date_format($tanggal, "Y-m-d H:i:s"),
                ];

                continue;
            } else if ($collection[$i][1] == 'Grup Produk') {
                continue;
            } else {
                $this->bersih[] = array_merge($this->header, [
                    AppBersih::field_jenis_linen() => $collection[$i][1],
                    AppBersih::field_kode_linen() => $collection[$i][4],
                    AppBersih::field_name() => $collection[$i][5],
                    AppBersih::field_rfid() => $collection[$i][6],
                    AppBersih::field_upload() => $auto_number,
                ]);
            }
        }
    }

    private function importBersih($auto_number)
    {
        $file = $this->file_bersih;

        SimpleExcelReader::create($file, $file->getClientOriginalExtension())
            ->noHeaderRow()
            ->skip(1)
            ->getRows()
            ->each(function ($row, $iteration) use ($auto_number) {
                $no_transaksi = $row[1];
                $nama_rs = $row[2];
                $nama_lokasi = $row[3];
                $total_pcs = $row[4];
                $tanggal = $row[5];
                $rfid = $row[6];

                if ($tanggal instanceof DateTimeImmutable) {

                    $this->header = [
                        AppBersih::field_transaksi() => $no_transaksi,
                        AppBersih::field_rs() => $nama_rs,
                        AppBersih::field_lokasi() => $nama_lokasi,
                        // AppBersih::field_tanggal() => date_format($tanggal, "Y-m-d H:i:s"),
                        AppBersih::field_tanggal() => $this->tanggal,
                    ];

                    return;
                } else if ($no_transaksi == 'Grup Produk') {
                    return;
                } else {
                    $this->bersih[] = array_merge($this->header, [
                        AppBersih::field_jenis_linen() => $nama_lokasi,
                        AppBersih::field_kode_linen() => $total_pcs,
                        AppBersih::field_name() => $tanggal,
                        AppBersih::field_rfid() => $rfid,
                        AppBersih::field_upload() => $auto_number,
                    ]);
                }
            });
    }

    private function importKotor($auto_number)
    {
        $file = $this->file_kotor;
        $collection = SimpleExcelReader::create($file, $file->getClientOriginalExtension())
            ->noHeaderRow()
            ->skip(1)
            ->getRows();

        // dd($collection->skip(1)->take(10)->all());
        $collection->each(function ($row, $iteration) use ($auto_number) {
            $linen = $row[0];

            if ($iteration == 0) {
                $this->rs = $linen;
            }

            if ($linen == 'Tanggal Linen Bersih') {
                for ($z = 1; $z < count($row); $z++) {
                    if ($row[$z] != '' and $row[$z] != ':') {
                        $this->tanggal_bersih = $this->toDate($row[$z]);
                        break;
                    }
                }

            }

            if ($linen == 'Tanggal Linen Kotor') {

                for ($z = 1; $z < count($row); $z++) {
                    if ($row[$z] != '' and $row[$z] != ':') {
                        $this->tanggal_kotor = $this->toDate($row[$z]);
                        break;
                    }
                }

            }

            if ($linen == 'Linen') {
                for ($x = 0; $x < count($row); $x++) {
                    if ($row[$x] == "") {
                        $this->location[] = "Kosong";
                    } else if ($row[$x] == 'Linen') {

                    } else if (str_contains($row[$x], 'Total Kotor')) {
                        break;
                        // $this->location[] = 'Total Kotor';
                    } else if (str_contains($row[$x], 'Total Bersih')) {
                        // $this->location[] = 'Total Bersih';
                        // break;
                    } else {
                        $this->location[] = $row[$x];
                    }
                }
            }
            if ($linen == 'Total Serah Terima') {
                return;
            } else {
                if (!empty($this->location)) {
                    for ($y = 1; $y < count($row) - 3; $y++) {
                        if (is_int($row[$y])) {
                            $this->kotor[] = [
                                AppKotor::field_name() => $linen,
                                AppKotor::field_rs() => $this->rs,
                                AppKotor::field_lokasi() => $this->location[$y - 1],
                                AppKotor::field_stock() => $row[$y],
                                AppKotor::field_tanggal_kotor() => $this->tanggal,
                                AppKotor::field_tanggal_bersih() => $this->tanggal,
                                AppKotor::field_upload() => $auto_number,
                            ];
                        }
                    }
                }
            }
        });
    }
}
