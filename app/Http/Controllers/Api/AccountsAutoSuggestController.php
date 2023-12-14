<?php

namespace App\Http\Controllers\Api;

use App\Accounts\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsAutoSuggestController extends Controller
{
    public function accountName(Request $request)
    {
        $search = $request->search;
        if ($search == '')
        {
            $items = Account::limit(5)->get();
        }
        else
        {
            $items = Account::with('balanceIncome:id,line_text')->where('account_name', 'like', '%' . $search . '%')->limit(10)->get();
        }
        $response = [];
        foreach ($items as $item)
        {
            $response[] = ['label' => $item->account_name, 'value' => $item->id, 'balance_income_line_name'=>$item->balanceIncome->line_text, 'balance_income_line_id'=>$item->balance_and_income_line_id];
        }
        return response()->json($response);
    }



}
