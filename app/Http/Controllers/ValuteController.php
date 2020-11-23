<?php

namespace App\Http\Controllers;

use App\Models\Valute;
use Illuminate\Http\Request;

class ValuteController extends Controller
{
    public function __construct()
    {
        //
    }
    
    public function readAll()
    {
        $valutes = valute::all();
        return response($valutes)->setStatusCode(200);;
    }
    
    public function read($id)
    {
        $valute = Valute::find($id);
        if ($valute == NULL) {
            return response()->json(['status' => 'not found'])->setStatusCode(404);
        }
        return response()->json($valute)->setStatusCode(200);
    }
    
    public function create(Request $request)
    {
        $this->valid($request);
        $newData = $this->makeNewData($request);
        $valute = new Valute($newData);
        try {
            $valute->save();
        } catch (Exeption $e) {
            return response()->json(['status' => 'Valute not created', 'error' => $e])->setStatusCode(500);
        }
        return response()->json(['status' => 'Valute created', 'id' => $valute->id])->setStatusCode(201);
    }
    
    private function valid(Request $request)
    {
        $this->validate($request, [
            'sec_id' => 'required|max:10',
            'name' => 'required|max:100',
            'english_name' => 'required|max:100',
            'alphabetic_code' => "required|max:3",
            'digit_code' => "required|integer",
            'rate' => "required|numeric"
        ]);
        return 1;
    }
    
    private function makeNewData(Request $request)
    {
        $newData = [
            'sec_id' => $request->input('sec_id'),
            'name' => $request->input('name'),
            'english_name' => $request->input('english_name'),
            'alphabetic_code' => $request->input('alphabetic_code'),
            'digit_code' => $request->input('digit_code'),
            'rate' => $request->input('rate')
        ];
        return $newData;
    }
    
}

;
