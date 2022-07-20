<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param AuthRequest $request
     * @param AuthService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request,AuthService $service){
        return response()->json($service->login($request));
    }
}
