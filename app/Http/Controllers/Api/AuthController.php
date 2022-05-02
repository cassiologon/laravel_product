<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Auth;


class AuthController extends Controller
{
    public function create(Request $request)
    {
        $retorno = ['error' => ''];


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'creation_access_key' => 'required|string',
        ]);


        if ($validator->fails()) {
            abort(response()->json(['error' => $validator->errors()], 400));
        }

        // abort(response()->json(['error' => "Você deve informar um nome!"], 400));

        if (env('creation_access_key') == $request->creation_access_key) {
                if (User::where('email',$request->email)->count() === 0) {
                  try {
                    $user = new User();
                    $user->name = $request->name;
                    // password_hash(md5($request->password), PASSWORD_DEFAULT)
                    $user->password = bcrypt($request->password); ;
                    $user->email = $request->email ;
                    $user->save();

                    $retorno['token'] =  $user->createToken('email')->plainTextToken;

                  } catch (\Exception $th) {
                    abort(response()->json(['error' => $th->getMessage()], 500));
                  }

                }else {
                    if ($request->recriar_token) {
                        $user = User::where('email',$request->email)->first();
                        PersonalAccessToken::where('tokenable_id',$request->email)->delete();
                        $retorno['token'] =  $user->createToken('email')->plainTextToken;
                    }else {
                        abort(response()->json(['error' => "User already registered!"], 202));
                    }
                }

        }else {
            abort(response()->json(['error' => "Invalid creation key"], 401));
        }
        return $retorno;

    }

    public function unauthorized()
    {
        return response()->json(['error' => "Unauthorized"], 401);
    }
}
