<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResource;

class ManageUserController extends Controller
{
    
    public function index(Request $request)
    {
        $query = User::paginate($request->limit ?? 10);

        return UserResource::collection($query);
    }
}
