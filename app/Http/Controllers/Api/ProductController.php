<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function query(Request $request){
        $retorno = ['error' => ''];

        $Product = Product::query();

        $query = $request->input('query');
        $type = $request->input('type');

        if (in_array($type, ['name','author_name','created_at'])) {
            $Product = $Product->where("$type","LIKE","%$query%");
        }

        if ($request->page) {
            $retorno['products'] = $Product->orderBy('name')->paginate(10);
        }else{
            $retorno['products']['data'] = $Product->orderBy('name')->get();
        }

        return response()->json($retorno);
    }
}
