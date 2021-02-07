<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class ImportTest extends TestCase
{
    private $file;

    public function createRandomFile()
    {
        if (!$this->file) {
            $this->file = UploadedFile::fake()->create('documents.csv');
        }
        return $this->file;
    }

    public function test_csv_file_require()
    {
        $response = $this->post('/import', ['csv_file' => $this->createRandomFile()]);
        $response->assertStatus(200);
    }

    public function test_chosen_output_currency()
    {
        $response = $this->post('/import', ['csv_file' => $this->createRandomFile(), 'currency' => '1']);
        $response->assertViewHasAll(['validationErr']);
        $response->assertViewIs('index');
    }

    public function test_returned_data()
    {
        $response = $this->post('/import', ['csv_file' => $this->createRandomFile(), 'currency' => 'USD']);
        $response->assertViewHasAll(['calculations', 'currency']);
        $response->assertViewIs('import_success');
    }

}
