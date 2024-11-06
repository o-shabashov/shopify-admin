<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function showSettings(string $shopId, string $shopDomain): JsonResponse
    {
        $user = User::where(['shop_id' => $shopId, 'name' => $shopDomain])->firstOrFail();

        return response()->json([
            'settings' => $user->cassieUser->settings->toArray(), // TODO return only the safe public settings, ie search-only-api-key
            'current_engine' => $user->cassieUser->current_engine->name,
        ]);

    }
}
