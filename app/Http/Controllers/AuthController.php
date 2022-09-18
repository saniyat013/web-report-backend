<?php

namespace App\Http\Controllers;

use DB;
use App\Models\District;
use App\Models\Division;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'mobile' => 'required|string',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'unit' => 'required|integer',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'division' => $fields['division'],
            'district' => $fields['district'],
            'unit' => $fields['unit'],
            'email' => $fields['email'],
            'mobile' => $fields['mobile'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('webReportToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }

        $token = $user->createToken('webReportToken')->plainTextToken;

        $response = [
            'user' => $user,
            'userData' => [
                'division' => Division::where('id', $user->division)->value('name'),
                'district' => District::where('id', $user->district)->value('name'),
                'unit' => Unit::where('id', $user->unit)->value('name'),
            ],
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully'
        ];
    }

    public function search(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->get()->first();

        $response = [
            'user' => $user
        ];

        return response($response, 200);
    }

    public function getUnverifiedUsers()
    {
        $user = User::where('verified', false)
            ->select('id as ID', 'name as Name', 'email as Email', 'mobile as Mobile', 'division as Division', 'district as District', 'unit as Unit')
            ->get();

        foreach ($user as $singleUser) {
            $singleUser->Division = Division::where('id', $singleUser->Division)->value('name');
            $singleUser->District = District::where('id', $singleUser->District)->value('name');
            $singleUser->Unit = Unit::where('id', $singleUser->Unit)->value('name');
        }

        $response = [
            'user' => $user,
        ];

        return response($response, 200);
    }

    public function verifyUser(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|integer'
        ]);

        $user = User::find($fields['id']);

        if ($user != null) {
            $user->update([
                'verified' => true,
            ]);
        } else {
            return [
                'message' => 'User not found'
            ];
        }

        return true;
    }
}
