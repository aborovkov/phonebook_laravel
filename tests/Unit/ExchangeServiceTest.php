<?php

namespace Tests\Unit;

use App\Jobs\ImportCsvJob;
use App\Services\ExchangeServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExchangeServiceTest extends TestCase
{
    private $filename;

    protected function tearDown(): void
    {
        unlink(storage_path('app/'.$this->filename));

        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testImportFileCreatesNewOne()
    {
        $service = resolve(ExchangeServiceInterface::class);

        $uploaded = UploadedFile::fake()->create('import.csv', 1000);
        $this->filename = $service->import($uploaded);

        $this->assertFileExists(storage_path('app/'.$this->filename));


    }

    public function testFileImportCreatesJob()
    {
        $service = resolve(ExchangeServiceInterface::class);

        $this->expectsJobs(ImportCsvJob::class);

        $uploaded = UploadedFile::fake()->create('import.csv', 1000);
        $this->filename = $service->import($uploaded);
    }



    public function testSync()
    {
        //todo: think about approach
        copy(__DIR__.'/../stubs/import.stub', storage_path('app/import.csv'));

        $service = resolve(ExchangeServiceInterface::class);
        $service->sync('import.csv');

        $this->filename = 'import.csv';

    }

}