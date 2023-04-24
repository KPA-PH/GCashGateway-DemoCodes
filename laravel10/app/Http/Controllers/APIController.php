<?php

namespace App\Http\Controllers;

use App\Models\gcashdemo;
use Exception;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //

    public function webhook(Request $request) {

        try {

            $s = new gcashdemo();
            $s->reference = $request->reference;
            $s->gcash_reference = $request->gcash_reference;
            $s->gcash_name = $request->gcash_name;
            $s->gcash_number = $request->gcash_number;
            $s->amount = $request->amount;
            $s->status = (int)$request->status;

            return $s->save() ? ["status" => 200, "message" => "Success"] : ["status" => 500, "message" => "Failed"];

        }
        catch(Exception $ex) {
            return  ["status" => 500, "message" => $ex];
        }
    }

    public function transaction(Request $request)
    {
        try {

            $s = gcashdemo::get();

            $totalTrans = COUNT($s);

            if($totalTrans > 0) {
                return ["status" => 200, "message" => "{$totalTrans} transactions", "data" => $s];
            }

            return ["status" => 404, "message" => "No data"];

        } catch (Exception $ex) {
            return  ["status" => 500, "message" => $ex];
        }
    }
}
