<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Bersih;
use App\Dao\Models\Kotor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Plugins\Alert;
use Plugins\Notes;

class CreateAppUploadService extends CreateService
{
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        DB::beginTransaction();
        try {
            $check = $repository->saveRepository($data->all());

            foreach(array_chunk($data->bersih, 500) as $insert_bersih){
                Bersih::insert($insert_bersih);
            }

            foreach(array_chunk($data->kotor, 500) as $insert_kotor){
                Kotor::insert($insert_kotor);
            }

            DB::commit();
            if($check){
                $check = Notes::create($check);
            }

            Alert::create();

        } catch (\Throwable$th) {
            DB::rollBack();
            Log::error($th);
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }
}