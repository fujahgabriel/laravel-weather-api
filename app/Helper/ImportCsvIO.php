<?php

namespace App\Helper;

use App\Temperature;

class ImportCsvIO
{
    /**
     * format data in csv to array for storage 
     */
    public static function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = [];
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else

                    $data[] = array_filter(array_combine($header, $row));
            }
            fclose($handle);
        }

        return $data;
    }
    /**
     * import csv and store to database
     */
    public static function importCsv($filePath, $noRows)
    {

        $tempArr = ImportCsvIO::csvToArray($filePath);
        if ($noRows > count($tempArr)) {
            $message = ["status" => "301", "message" => 'The no of rows('.$noRows.') requested exceeds the records to be imported. Try a smaller figure!'];
        } else {
            for ($i = 0; $i < $noRows; $i++) {
                Temperature::create($tempArr[$i]);
            }
            $message = ["status" => "200", "message" => 'Ok'];
        }

        return $message;
    }
}
