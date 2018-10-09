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
    <h1> Dynamically Creating a Table from CSV File</h1>
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

    public static function generateTable($records)

    {
        $tablestruct = tablemethods::addDiv();
        $tablestruct .= tablemethods::addTable();
        $count = 1;
        $tablestruct .= tablemethods::addTableHeaders();
        $tablestruct .= tablemethods::addrow();

        foreach ($records[0] as $fields => $values) {
            $tablestruct .= tablemethods::addTableHeaderTag($fields);
        }

        $tablestruct .= tablemethods::endrow();
        $tablestruct .= tablemethods::endTableHeaders();
        $tablestruct .= tablemethods::addTableBody();

        foreach ($records as $arrays) {
            if ($count > 0) {
                $tablestruct .= tablemethods::addrow();
                foreach ($arrays as $fields => $values) {
                    $tablestruct .= tablemethods::addcolumn($values);
                }

                $tablestruct .= tablemethods::endrow();
            }

            $count++;
        }
        $tablestruct .= tablemethods::endTableBody();
        $tablestruct .= tablemethods::endTable();
        $tablestruct .= tablemethods::endDiv();
        return $tablestruct;
    }
}

class tablemethods {

    public static function addDiv($attribute = "<div class=\"container\">"){
        return $attribute;
    }
    public static function endDiv($attribute = "</div>"){
        return $attribute;
    }
    public static function addTable($attribute = "<table class=\"table table-striped\">"){
        return $attribute;
    }
    public static function endTable($attribute = "</table>"){
        return $attribute;
    }
    public static function addTableHeaders($attribute = "<thead>"){
        return $attribute;
    }
    public static function endTableHeaders($attribute = "</thead>"){
        return $attribute;
    }
    public static function addTableBody($attribute = "<tbody>"){
        return $attribute;
    }
    public static function endTableBody($attribute = "</tbody>"){
        return $attribute;
    }
    public static function addTableHeaderTag($fields){
        $attribute = "<th>" .$fields ."</th>";
        return $attribute;
    }
    public static function addrow($attribute = "<tr>"){
        return $attribute;
    }
    public static function endrow($attribute = "</tr>"){
        return $attribute;
    }
    public static function addcolumn($values){
        $attribute = "<td>" . $values . "</td>";
        return $attribute;
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
