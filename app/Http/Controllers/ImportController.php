<?php

namespace App\Http\Controllers;


use App\Http\Requests\CsvUploadFormRequest;
use App\Models\CurrencyCalculator;
use App\Models\Document;
use Illuminate\Support\Facades\Config;

class ImportController extends Controller
{
    private $rowMap = [
        "customer" => 0,
        "vat_number" => 1,
        "document_number" => 2,
        "type" => 3,
        "parent_document" => 4,
        "currency" => 5,
        "total" => 6
    ];

    public function import(CsvUploadFormRequest $request)
    {
        $filter = trim($request->input('filter'));
        $currency = $request->input('currency');
        $currencyOptions = Config::get("constants.currencies");

        if (!$currency || !in_array($currency, $currencyOptions)) {
            return view('index', ['validationErr' => 'Selected output currency is not supported!']);
        }

        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            if ($request->has('header')){
                array_shift($data);
            }

            $documents = [];
            foreach ($data as $row) {
                $fields = [];
                foreach ($this->rowMap as $key => $value) {
                    if (!isset($row[$value])) {
                        return view('index', ['validationErr' => 'Column ' . $key. ' is missing in the file!']);
                    } else if ($key != "parent_document" && !$row[$value]) {
                        return view('index', ['validationErr' => 'Some of the required columns do not have any values!']);
                    }
                    $fields[$key] = trim($row[$value]);
                }
                $document = new Document($fields);
                if (!$filter || $document->vat_number == $filter) {
                    if (!array_key_exists($document->customer, $documents)) {
                        $documents[$document->customer] = [];
                    }
                    if ($document->parent_document && !array_key_exists($document->parent_document, $documents[$document->customer])) {
                        return view('index', ['validationErr' => 'Parent document does not exist!']);
                    }
                    if (!in_array($document->currency, $currencyOptions)) {
                        return view('index', ['validationErr' => 'Currency ' . $document->currency . ' is not supported']);
                    }
                    if (!in_array($document->type, array_keys(Config::get("constants.document_types")))) {
                        return view('index', ['validationErr' => 'Invalid type ' . $document->type . ' is selected']);
                    }
                    if (!is_numeric($document->total)) {
                        return view('index', ['validationErr' => 'Invalid value ' . $document->total . ' for total amount!']);
                    }
                    $documents[$document->customer][$document->document_number] = $document;
                }
            }
            return view('import_success', ['calculations' => CurrencyCalculator::calculateDocuments($documents, $currency), "currency" => $currency]);
        }
        return view('index', ['validationErr' => 'Please upload correct csv file!']);
    }
}
