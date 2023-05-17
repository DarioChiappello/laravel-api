<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Services\ClientService;
use App\Traits\ApiResponser;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    use ApiResponser;

    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->all();
        return $this->successResponse($clients);
    }

    public function store(ClientRequest $request)
    {
        try
        {
            $validateRequest = $this->clientService->validateRequest($request);
            $client = $this->clientService->create($request->all());
            return $this->successResponse($client);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function show($client)
    {
        $client = $this->clientService->find($client);

        return $this->successResponse($client);
    }

    public function update(ClientRequest $request, $client)
    {
        try
        {
            $validateRequest = $this->clientService->validateRequest($request);
            $client = $this->clientService->update($client, $request->all());
            return $this->successResponse($client);
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex);
        }
    }

    public function destroy($client)
    {
        try
        {
            $client = $this->clientService->delete($client);
            return $this->successResponse($client); 
        }
        catch(\Exception $ex)
        {
            return $this->errorResponse($ex, 404);
        }
    }
}
