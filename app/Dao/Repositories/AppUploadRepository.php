<?php

namespace App\Dao\Repositories;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\AppBersih;
use App\Dao\Models\AppKotor;
use App\Dao\Models\AppUpload;
use App\Dao\Models\Bersih;
use App\Dao\Models\Kotor;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Plugins\Notes;

class AppUploadRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new AppUpload() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model->select($this->model->getSelectedField())
            ->leftJoinRelationship('has_user')
            ->active()->sortable()->filter();

        $query = env('PAGINATION_SIMPLE') ? $query->simplePaginate(env('PAGINATION_NUMBER')) : $query->paginate(env('PAGINATION_NUMBER'));

        return $query;
    }

    public function deleteRepository($request)
    {
        // DB::beginTransaction();
        // try {
        //     if(is_array($request)){
        //         $code = $this->model->whereIn($this->model->field_primary(), $request)->pluck($this->model->field_name())->unique()->toArray();
        //         $this->deleteLinen(array_values($code));
        //         $this->model->destroy(array_values($request));
        //     }
        //     else{
        //         $code = $this->model->Where($this->model->field_primary(), $request)->pluck($this->model->field_name())->toArray();
        //         $this->deleteLinen(array_values($code));
        //         $this->model->destroy($request);
        //     }
        //     DB::commit();
        //     return Notes::delete($request);
        // } catch (QueryException $ex) {
        //     DB::rollBack();
        //     return Notes::error($ex->getMessage());
        // }
    }

    private function deleteLinen($data){
        // AppBersih::where(AppBersih::field_upload(), $data)->delete();
        // AppKotor::where(AppKotor::field_upload(), $data)->delete();
    }

}
