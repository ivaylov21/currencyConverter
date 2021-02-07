<?php

namespace App\Models;


use Illuminate\Support\Facades\Config;

class CurrencyCalculator
{
    public static function calculateDocuments(array $documents, $currency)
    {
        $totalAmounts = [];
        $exchangeRates = Config::get("constants.exchange_rates." . $currency);
        foreach ($documents as $customer=>$cDocuments) {
            if (!array_key_exists($customer, $totalAmounts)) {
                $totalAmounts[$customer] = 0;
            }
            foreach ($cDocuments as $document) {
                if ($document->currency == $currency) {
                    $amount = $document->total;
                } else {
                    $amount = round($exchangeRates[$document->currency] * $document->total, 2);
                }

                if ($document->type != Config::get("constants.credit_type")) {
                    $totalAmounts[$customer] += $amount;
                } else {
                    $totalAmounts[$customer] -= $amount;
                }
            }
        }
        return $totalAmounts;
    }
}
