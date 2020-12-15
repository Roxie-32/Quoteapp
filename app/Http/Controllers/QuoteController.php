<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotes;
use Tymon\JWTAuth\Facades\JWTAuth;

class QuoteController extends Controller
{
    public function postQuote(Request $request){
        if(!$user = JWTAuth::parseToken()->authenticate() ){
            return response()->json(['message' =>'User not found'], 404);
            
        }
        $quote= new Quotes();
        $quote->content=$request->input('content');
        $quote->save();
        return response()->json(['quote' => $quote],201);

    }
    public function getQuotes(){
      $quotes = Quotes::all();
      $response = [
          'quotes' => $quotes
      ];
        return response()->json($response,200);

    }
    public function putQuote(Request $request, $id){
        $quote= Quotes::find($id);
        if(!$quote) {
            return response()->json(['message'=>'Document not found'],404);
        }
        $quote->content = $request->input('content');
        $quote->save();
        return response()->json(['quote'=> $quote], 200);
    }
    public function deleteQuote($id){
        $quote= Quotes::find($id);
        $quote->delete();
        return response()->json(['quote'=>'Quote deleted'], 200);

    }
}
