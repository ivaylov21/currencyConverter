<?php

namespace App\Models;


class Document
{
    public $customer;

    public $vat_number;

    public $document_number;

    public $type;

    public $parent_document;

    public $currency;

    public $total;

    public function __construct(array $fields)
    {
        $this->customer = $fields["customer"];
        $this->vat_number = $fields["vat_number"];
        $this->document_number = $fields["document_number"];
        $this->type = $fields["type"];
        $this->parent_document = $fields["parent_document"];
        $this->currency = $fields["currency"];
        $this->total = $fields["total"];
    }

}
