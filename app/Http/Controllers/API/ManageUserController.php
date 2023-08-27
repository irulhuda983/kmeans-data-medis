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
        $search = $request->search ?? null;
        list($order, $dir) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;


        $query = User::search($search)->where('role', 'admin')->orderBy($order, $dir);
        return UserResource::collection( $query->paginate($limit) );
    }
}
