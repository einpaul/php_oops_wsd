<!DOCTYPE html>
<html lang="en">
<head>
    <title>CSV to Table Conversion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<center>
    <h1> Creating a HTML table from a CSV file </h1>
</center>

<?php
/** Created by Phpstorm */

main::start("example.csv");

class main {
    static public function start($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
        $showtable = showtable::display($table);
    }
}

class html {
    public static function generateTable($records) {
        $count = 0;

        foreach ($records as $record) {

           if ($count == 0) {
               $array = $record->returnArray();
               $fields = array_keys($array);
               $values = array_values($array);
               print_r($fields);
               print_r($values);

           } else {

               $array = $record->returnArray();
               $values = array_values($array);
               print_r($values);

           }

           $count++;
        }
    }
}

class showtable
{
    public static function display($tablestruct)
    {
        if($tablestruct != null){
            echo $tablestruct;
        }
        else{
            echo "No records yet. Check input CSV file";
        }
    }
}

class csv {
    static public function getRecords($filename) {
        $file = fopen($filename,"r");
        $fieldNames = array();

        $count = 0;

        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0){
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;

        }

        fclose($file);
        return $records;
    }
}

class record {

    public function __construct(Array $fieldNames = null, $values = null )

    {
        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this -> createProperty($property, $value);
        }

    }

    public function returnArray() {
        $array = (array) $this;
        return $array;
    }

    public function createProperty($name = 'first', $value = 'ein') {
        $this->{$name} = $value;
    }
}

class recordFactory {
    public static function create(Array $fieldNames = null, Array $values = null) {

        $record = new record($fieldNames, $values);

        return $record;
    }
}