<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Services\ModelService;

class ModelController extends Controller
{
    use ApiResponser;

    protected $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function index(Request $request, $model)
    {
        $data = $this->modelService->all($model);

        return $this->successResponse($data);
    }

    public function show(Request $request, $model, $id)
    {
        $data = $this->modelService->find($model, $id);

        return $this->successResponse($data);
    }
}
