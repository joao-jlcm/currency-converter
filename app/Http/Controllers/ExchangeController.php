<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExchangeController extends Controller
{
	public function add(Request $request)
    {
    	list($fromCurrency, $toCurrency) = explode('-', $request->input('currency'));
		$exchange = new Exchange();
		$exchange->amount = $request->input('amount');
		$exchange->from_currency_id = Currency::where('code', $fromCurrency)->firstOrFail()->id;
		$exchange->to_currency_id = Currency::where('code', $toCurrency)->firstOrFail()->id;
		$exchange->user_id = auth()->user()->id;
		$exchange->rate = Http::get('https://api.exchangeratesapi.io/latest', [
			'base' => $fromCurrency,
			'symbols' => $toCurrency,
		])->json()['rates'][$toCurrency];
		$exchange->save();
	    return redirect()->route('exchanges')->withInput();
    }

    public function index()
    {
		$currencies = Currency::all();
		$exchanges = Exchange::orderBy('created_at', 'desc')->paginate(10);
	    return view('exchanges', compact('currencies', 'exchanges'));
    }
}
