<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    public function update(UpdateUserPasswordRequest $request) 
    {
        $userId = $request->id;
        $user = User::find($userId);
        $this->authorize('update', ['App\Models\User', $userId]);
        
        $inputPassword = $request->current_password;
        if (Hash::check($inputPassword, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            return response()->json(['message' => 'Mot de passe modifié']);
        } else {
            return response()->json(['message' => '[UPDATE_PASSWORD_FAILED] Error no matching passwords', 'errors' => ['current_password' => ['Current password doest not match']]], 422);
        }
        

    }
        
}
    

