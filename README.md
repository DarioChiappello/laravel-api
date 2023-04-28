# Laravel API

### Darío Chiappello

### API example base

Controllers are using Services the inherit functions from a BaseService to work with the data from a model

```php
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

```

Other Services inherit the functions form the BaseService. For example in ProductService and ProductController:

```php
<?php

namespace App\Services;

use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductService extends BaseService
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

}

```

```php

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ApiResponser;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    use ApiResponser;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->all();
        return $this->successResponse($products);
    }

    public function store(ProductRequest $request)
    {
        $validateRequest = $this->productService->validateRequest($request);

        $product = $this->productService->create($request->all());

        return $this->successResponse($product);
    }

    public function show($product)
    {
        $product = $this->productService->find($product);

        return $this->successResponse($product);
    }

    public function update(ProductRequest $request, $product)
    {
        $validateRequest = $this->productService->validateRequest($request);
        $product = $this->productService->update($product, $request->all());
        return $this->successResponse($product);
    }

    public function destroy($product)
    {
        $product = $this->productService->delete($product);

        return $this->successResponse($product); 
    }

}


```

The controllers are using specific requests that depends on a BaseRequest

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    protected function failedValidation($validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, $this->response($validator));
    }

    protected function response($validator)
    {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors(),
        ], 422);
    }
}

class ProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer',
            'rate' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'description.required' => 'A description is required',
            'price.required' => 'A price is required',
            'price.decimal' => 'A price should be a float',
            'stock.required' => 'A stock is required',
            'stock.integer' => 'A stock should be an integer',
            'rate.required' => 'A rate is required',
            'rate.decimal' => 'A rate hould be a float',
        ];
    }
}

```

The API are using a Trait for return a JSON response

```php
<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Build success response.
     * @param string|array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Build error response.
     * @param string|array $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

}
```