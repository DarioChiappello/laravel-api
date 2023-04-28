<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserService;
use App\Traits\ApiResponser;

class UserController extends Controller
{
    use ApiResponser;
    
    public function index()
    {
        $userService = new UserService(new User);
        $users = $userService->all();
        return $this->successResponse($users);
    }
}
