<?php
/** Created by Phpstorm */

main::start();

class main {
    static public function start() {
        $file = fopen("example.csv","r");
        print_r(fgetcsv($file));
        fclose($file);
    }
}