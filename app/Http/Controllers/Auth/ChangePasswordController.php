<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function changePasswordAuth(ChangePasswordRequest $request)
    {
        if (Hash::check($request->password, $request->user()->password)) {
            if ($request->new_password != $request->confirm_new_password) {
                return response(["errors" => ["confirm_new_password" => ["Las contraseñas no coinciden"]]], 422);
            } else {
                $user = User::find($request->user()->id);

                $user->password = Hash::make($request->new_password);

                $user->save();

                return response(null, 200);
            }
        } else {
            return response(["errors" => ["password" => ["La contraseña actual es inconrrecta"]]], 422);
        }
    }
}
