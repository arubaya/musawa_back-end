<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentityController extends Controller
{
    public function getAllUsers()
    {
         $data = DB::table('identities')
            ->select(
                'identities.user_id',
                'users.name',
                'users.email',
                'identities.gender',
                'identities.phone_number',
                'identities.address', 
                )
            ->join('users', 'user_id', 'users.id')
            ->where('users.role', 'user')
            ->get();
        return response()->json($data);
    }

    public function getUserByID($id)
    {
         $data = DB::table('identities')
            ->select(
                'identities.user_id',
                'users.name',
                'users.email',
                'identities.gender',
                'identities.birthday',
                'identities.phone_number',
                'identities.address', 
                )
            ->join('users', 'user_id', 'users.id')
            ->where('identities.user_id', $id)
            ->get();
        return response()->json($data);
    }

    public function getUserData($id)
    {
         $data = DB::table('users')
            ->select('name','email')
            ->where('id', $id)
            ->get();
        return response()->json($data);
    }

    public function create(Request $request)
    {
        try {
            $identity = Identity::create([
                'user_id' => $request['userId'],
                'gender' => $request['gender'],
                'birthday' => $request['birthDate'],
                'phone_number' => $request['phoneNumber'],
                'address' => $request['address'],
            ]);
            return response()->json([
                "message" => "create identity success",
                "data" => $identity
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "create identity data failed"
            ]);
        }
    }

    public function updateIdentity(Request $request, $id)
    {
        Identity::where('user_id', $id)
                ->update([
                    'gender' => $request['gender'],
                    'birthday' => $request['birthDate'],
                    'phone_number' => $request['phoneNumber'],
                    'address' => $request['address'],
                    ]);
        return response()->json([
                        "message" => "successfully update"
                        ], 200);
    }

    public function updateUser(Request $request, $id)
    {
        User::where('id', $id)
                ->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    ]);
        return response()->json([
                        "message" => "successfully update"
                        ], 200);
    }

}
