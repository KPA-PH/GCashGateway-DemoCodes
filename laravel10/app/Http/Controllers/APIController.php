<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\gcashdemo;
use App\Models\invoicedemo;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //

    public function get_invoice()
    {
        try {

            $invoices = invoicedemo::get();
            if (COUNT($invoices) == 0) {
                return  ["status" => 404, "message" => "No data"];
            }

            return ["status" => 200, "message" => "Success", "data" => $invoices];

        } catch (Exception $ex) {
            return  ["status" => 500, "message" => $ex];
        }
    }

    public function create_invoice(Request $request)
    {
        try {

            $s = new invoicedemo();
            $s->user_id = $request->user_id;
            $s->reference = $request->reference;
            $s->amount = $request->amount;
            return $s->save() ? ["status" => 200, "message" => "Success"] : ["status" => 501, "message" => "Failed"];
        } catch (Exception $ex) {
            return  ["status" => 500, "message" => $ex];
        }
    }

    public function webhook(Request $request) {

        try {

            // check reference number
            $invoice = invoicedemo::where("reference", $request->reference);
            $invoice_select = $invoice->first();
            if($invoice_select == null) {
                return  ["status" => 404, "message" => "Invoice reference number did not found"];
            }

            // get gcash received if any
            $gcash_trans = gcashdemo::where("reference", $request->reference)->sum("gcash_amount");

            // get amount expectation
            $expectedAmount = (float)$invoice_select->amount;
            $receivedAmount = (float)$request->amount + $gcash_trans;
            $balanceAmount = $expectedAmount - $receivedAmount;

            $statuses = ["status" => 0, "message" => "Incomplete"];

            if($receivedAmount >= $expectedAmount) {
                if($expectedAmount == $receivedAmount) {
                    $statuses = ["status" => 1, "message" => "Complete"];
                }
                else {
                    $statuses = ["status" => 1, "message" => "Over Paid"];
                }
                $invoice->update(["status" => 1]);
            }

            // save gcash received
            $s = new gcashdemo();
            $s->reference = $request->reference;
            $s->gcash_reference = $request->gcash_reference;
            $s->gcash_name = $request->gcash_name;
            $s->gcash_number = $request->gcash_number;
            $s->gcash_amount = (float)$request->amount;
            $s->expected_amount = $expectedAmount;
            $s->balance_amount = $balanceAmount;
            $s->total_amount_received = $receivedAmount;
            $s->status_message = $statuses["message"];
            $s->status = $statuses["status"];

            return $s->save() ? ["status" => 200, "message" => "Success"] : ["status" => 501, "message" => "Failed"];

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
