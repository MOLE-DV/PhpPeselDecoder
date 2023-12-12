<?php

    decodePesel(fread(fopen("text.txt", "r"), 8192));

    function decodePesel($pesel){
        if(!is_numeric($pesel)) errorHandler(1); // ciąg znaków nie składa się z liczb
        if(strlen($pesel) != 11) errorHandler(2); // czy długość ciągu jest wystarczająca (>11)

        $peselSplitted = str_split(strval($pesel));

        $preyr = $peselSplitted[2] >= 2 ? 20 : 19;

        $dane = array(
            intval($preyr.$peselSplitted[0].$peselSplitted[1]), // Rok
            $preyr > 19 ? (intval($peselSplitted[2] . $peselSplitted[3]) - 20) : intval($peselSplitted[2] . $peselSplitted[3]), //miesiąc
            intval($peselSplitted[4] . $peselSplitted[5]), //dzień
            $peselSplitted[count($peselSplitted) - 2] % 2 == 0 ? "Kobieta" : "Mężczyzna" //płeć
        );

        echo "$dane[3] urodzo".($dane[3] == "Mężczyzna" ? "ny" : "na")." w "
        .(getNameOfDay(strtotime("$dane[0]-$dane[1]-$dane[2]")))." "
        ."$dane[2]go ".getNameOfMonth(strtotime("$dane[0]-$dane[1]-$dane[2]"))." "
        ."$dane[0] roku."." "
        ."Do urodzin pozostało: "
        . getDiffToBirthday("$dane[0]-$dane[1]-$dane[2]") ." dni"
        .", czyli ". getDiffToBirthday("$dane[0]-$dane[1]-$dane[2]") * 24 ." godzin"
        .", czyli ". getDiffToBirthday("$dane[0]-$dane[1]-$dane[2]") * 24 * 60 ." minut"
        .", czyli ". getDiffToBirthday("$dane[0]-$dane[1]-$dane[2]") * 24 * 60 * 60 ." sekund";
    }

    function getDiffToBirthday($birthDate){
        $todaysDate = new DateTime();

        $nextBirthDay = new DateTime($birthDate);
        $nextBirthDay->setDate($todaysDate->format("Y"), $nextBirthDay->format("m"), $nextBirthDay->format("d"));

        if($todaysDate->format('Y-m-d') > $nextBirthDay->format('Y-m-d')){
            $nextBirthDay->modify("+1 year");
        }

        $interval = $todaysDate->diff($nextBirthDay);

        return ($interval->days) + 1;
    }

    function getNameOfDay($date){
        $tranNames = array(
            "monday" => "poniedziałek",
            "tuesday" => "wtorek",
            "wednesday" => "środe",
            "thursday" => "czwartek",
            "friday" => "piątek",
            "saturday" => "sobote",
            "sunday" => "niedziele"
        );

        return $tranNames[strtolower(date("l", $date))];
    }

    function getNameOfMonth($date){
        $monthDictionary = array(
            "january" => "stycznia",
            "february" => "lutego",
            "march" => "marca",
            "april" => "kwietnia",
            "may" => "maja",
            "june" => "czerwca",
            "july" => "lipca",
            "august" => "sierpnia",
            "september" => "września",
            "october" => "października",
            "november" => "listopada",
            "december" => "grudnia"
        );

        return $monthDictionary[strtolower(date("F", $date))];
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