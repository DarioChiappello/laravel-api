<?php

namespace App\Services;

use App\Models\Client;
use App\Http\Requests\ClientRequest;

class ClientService extends BaseService
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

}
