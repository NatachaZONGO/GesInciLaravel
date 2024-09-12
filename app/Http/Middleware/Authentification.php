<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class Authentification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Recuperation du token de l'wentete de la requete
        $authorisationHeader = $request->header('Authorization');
        //Supprimer le prefix Bearer
        if ($authorisationHeader && str_starts_with($authorisationHeader, 'Bearer ')) {
            $pat = PersonalAccessToken::findToken(substr($authorisationHeader, 7));
            if($pat == null){
                return response()->json(["error" => "Non autorise"], 401);
            }
            $userId = $pat->tokenable_id;
            try{
                Auth::setUser(User::findOrFail($userId));
            }catch(e){
                dd("Cas2");
                return response()->json(["error" => "Non autorise"], 401);
            }
        }else{
            dd("Cas3");
            return response()->json(["error" => "Non autorise"], 401);
        }
        return $next($request);
    }
}
