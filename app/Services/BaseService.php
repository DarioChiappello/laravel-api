<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $model = $this->model->find($id);
        $data = (array) $data;

        $model->fill($data);
        
        $model->save();
        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        $model->delete();
        return $model;
    }

    public function validateRequest($request)
    {        
        if($request->validate($request->rules()))
        {
            return true;
        }
        
        return false;      
    }

    public function insert($data)
    {
        return $this->model->insert($data);
    }

    public function upsert($data, $args, $fields)
    {
        return $this->model->upsert($data, $args, $fields);
    }
}
