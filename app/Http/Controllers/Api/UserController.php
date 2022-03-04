<?php


namespace App\Http\Controllers\Api;

use App\Exceptions\ApiModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')->get();

        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'users' => $users,
                ]
            ]
        ]);
    }

    public function show($id)
    {
        if (!$user = User::find($id)) {
            throw new ApiModelNotFoundException("Ushbu ID ga ega User tizimda mavjud emas.");
        }
        
        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'user' => $user,
                ]
            ]
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request->all());

        return response()->json([
            'result' => [
                'success' => true,
                'message' => 'User is successfuly created',
                'data' => [
                    'user' => $user,
                ]
            ]
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'name'    => $request['name'],
            'email'   => $request['email'],
            'role'    => $request['role'],
        ]);

        return response()->json([
            'result' => [
                'success' => true,
                'message' => 'User is successfuly update',
                'data' => [
                    'user' => $user,
                ]
            ]
        ]);
    }

    public function destroy($id)
    {
        if (!$user = User::find($id)) {
            throw new ApiModelNotFoundException("Ushbu ID ga ega User tizimda mavjud emas.");
        }

        try {
            $user->delete();
        } catch (\Exception $e) {

        }

        return response()->json([
            'result' => [
                'success' => true,
                'data' => [
                    'user' => $user,
                ]
            ]
        ]);
    }
}
