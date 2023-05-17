<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;

class ModelService
{
    public function all($model)
    {
        $model = 'App\\Models\\' . ucfirst($model);
        $data = $model::all();
        return $data;
    }

    public function find($model, $id)
    {
        $model = 'App\\Models\\' . ucfirst($model);
        $data = $model::findOrFail($id);
        return $data;
    }
}
