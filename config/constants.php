<?php


return [
    "currencies" => [
        "EUR",
        "USD",
        "GBP"
    ],
    "exchange_rates" => [
        "EUR" => [
            "USD" => 0.83,
            "GBP" => 1.14
        ],
        "USD" => [
            "EUR" => 1.20,
            "GBP" => 1.37
        ],
        "GBP" => [
            "EUR" => 0.88,
            "USD" => 0.73
        ]
    ],
    "document_types" => [
        1 => "Invoice",
        2 => "Credit",
        3 => "Debit"
    ],
    "credit_type" => 2
];
