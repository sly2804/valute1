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
    
    public function create(Request $request, $id)
    {
        $this->valid($request);
        $newData = $this->makeNewData(
            $id,
            $request->input('name'),
            $request->input('alphabetic_code'),
            $request->input('digit_code'),
            $request->input('rate'),
            $request->input('english_name')
        );
        $valute = $this->createNewValute($newData);
        return response()->json(['status' => 'Valute created', 'id' => $valute->id])->setStatusCode(201);
    }
    
    private function valid(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'english_name' => 'required|max:100',
            'alphabetic_code' => "required|max:3",
            'digit_code' => "required|integer",
            'rate' => "required|numeric"
        ]);
        return 1;
    }
    
    private function makeNewData($id, $name, $alphabeticCode, $digitCode, $rate, $englishName)
    {
        $newData = [
            'id' => $id,
            'name' => $name,
            'english_name' => $englishName,
            'alphabetic_code' => $alphabeticCode,
            'digit_code' => $digitCode,
            'rate' => $rate
        ];
        return $newData;
    }
    
    public function update()
    {
        $date = Date("d/m/Y");
        $urlDaily = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date";
        $daily = simplexml_load_file($urlDaily);
        $urlValFull = "http://www.cbr.ru/scripts/XML_valFull.asp";
        $valFull = simplexml_load_file($urlValFull);
        $englishName = array();
        foreach ($valFull->Item as $i) {
            $ii = (string)$i["ID"];
            $englishName[$ii] = $i->EngName;
        }
        foreach ($daily->Valute as $v) {
            $id = (string)$v["ID"];
            $objValute = Valute::find($id);
            if ($objValute == NULL) {
                $newData = $this->makeNewData(
                    $id,
                    $v->Name,
                    $v->CharCode,
                    $v->NumCode,
                    $this->rateCalculate($v->Value, $v->Nominal),
                    $englishName[$id]
                );
                $this->createNewValute($newData);
            } else {
                $rate = $this->rateCalculate($v->Value, $v->Nominal);
                $objValute->name = $v->Name;
                $objValute->digit_code = $v->NumCode;
                $objValute->alphabetic_code = $v->CharCode;
                $objValute->rate = $rate;
                $objValute->english_name = $englishName[$id];
                $this->trySave($objValute);
            }
        }
        return response()->json(['status' => 'Valute updated'])->setStatusCode(201);
    }
    
    private function rateCalculate($v1, $v2)
    {
        $v1 = str_replace(",", ".", $v1);
        $v = (double)$v1 / $v2;
        Return $v;
    }
    
    private function createNewValute($newData)
    {
        $valute = new Valute($newData);
        $valute = $this->trySave($valute);
        return $valute;
    }
    
    private function trySave($valute)
    {
        try {
            $valute->save();
        } catch (Exeption $e) {
            return response()->json(['status' => 'Valute not created', 'error' => $e])->setStatusCode(500);
        }
        return $valute;
    }
    
}

;
