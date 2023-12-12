<?php

    decodePesel(fread(fopen("text.txt", "r"), 8192));

    function decodePesel($pesel){
        if(!is_numeric($pesel)) errorHandler(1);
        if(strlen($pesel) < 11) errorHandler(2);

        $peselSplitted = str_split(strval($pesel));

        $preyr = $peselSplitted[2] >= 2 ? 20 : 19;

        $dane = array(
            intval($preyr.$peselSplitted[0].$peselSplitted[1]),
            $preyr > 19 ? (intval($peselSplitted[2] . $peselSplitted[3]) - 20) : intval($peselSplitted[2] . $peselSplitted[3]),
            intval($peselSplitted[4] . $peselSplitted[5]),
            $peselSplitted[count($peselSplitted) - 2] % 2 == 0 ? "Kobieta" : "Mężczyzna"
        );

        print_r($dane);
    }

    function decodeYear($pesel){

        return 0;
    }

    function errorHandler($errorCode){
        switch($errorCode){
            case 1:
                echo "podaj same liczby";
                break;
            case 2:
                echo "pesel musi składać się z 11 liczb";
                break;
        }
        return;
    }
?>