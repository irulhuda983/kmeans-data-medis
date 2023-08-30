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

    public function show(User $user)
    {
        return new UserResource( $user );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'admin'
        ]);

        return response()->json([
            'data' => $user
        ], 200);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'password' => 'nullable',
        ]);

        $updatedData = [
            'nama' => $request->nama,
            'username' => $request->username,
            'role' => 'admin'
        ];

        if($request->password) {
            $updatedData['password'] = bcrypt($request->password);
        }

        $user->update($updatedData);

        return response()->json([
            'data' => $user
        ], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'data' => $user
        ], 200);
    }
}
