<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Helper\ImportCsvIO;
use Symfony\Component\Console\Exception\RuntimeException;

class ImportTempratureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv
                            {file : the source of the file}
                            {rows : the expected rows to import}
                            {status=200 : The expected status code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing daily temperature records from a CSV';

   

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            
            $source = $this->argument('file');
            $file =$this->validateFile($source);

            $noRows= (int) $this->argument('rows');
            
            $response= ImportCsvIO::importCsv($file,$noRows);

            
        } catch (\Exception $e) {
            $this->error("Importer failed for  $source with an exception");
            $this->error($e->getMessage());
            return 2;
        }
    
        if ($response["status"] != 200) {
            $this->error("Importer failed for $source, ".$response["message"]);
             return 1;
        }else{
            $this->info("$noRows Records were imported!");
        }

        return 0;
    
    }

    protected function validateFile($file)
    {
       
        throw_unless(
            File::exists($file),
            RuntimeException::class,
            "file does not exist [{$file}]"
        );

        return  $file;
    }
}

   

   
