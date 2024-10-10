<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\UserType;

class UserTypeController extends Controller
{
    public function index()
    {
        $types = UserType::all();
        return response()->json($types, 200);
    }
}
