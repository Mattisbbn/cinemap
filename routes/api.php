<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Film;

Route::middleware('auth:api')->group(function () {
    Route::get('/films/{film}/locations', function (Request $request, Film $film) {
        $user = $request->user();

        if (!$user->subscribed('default')) {
            return response()->json(['message' => 'Abonnement requis'], 403);
        }

        if (!$film->locations()->exists()) {
            return response()->json(['message' => 'Aucune location trouvée pour ce film'], 404);
        }

        return response()->json($film->locations);
    });
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!$token = Auth::guard('api')->attempt($credentials)) {
        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    return response()->json(['token' => $token]);
});
