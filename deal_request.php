<?php


if ($_POST["deal"]) {
    if (isset($_POST["contactsarr"])) {

        $json = json_decode(file_get_contents('data.json'), true);

        $maxId = [];

        for ($i = 0; $i < count($json['deals']); $i++) {
            array_push($maxId, $json['deals'][$i]["id"]);
        }
        $maxId = max($maxId) + 1;
        $json['deals'][] = [
            'id' => $maxId,
            'dealname' => $_POST["deal"],
            'amount' => $_POST["amount"],
            'contactslist' => $_POST["contactsarr"],
        ];

        for ($o = 0; $o < count($_POST['contactsarr']); $o++) {

            for ($k = 0; $k < count($json['contacts']); $k++) {
                if ($_POST['contactsarr'][$o] == $json['contacts'][$k]["id"]) {
                    array_push($json['contacts'][$k]["dealslist"], $maxId);
                }
            }
        }

        file_put_contents('data.json', json_encode($json));
    } else {
        $maxId = [];

        for ($i = 0; $i < count($json['deals']); $i++) {
            array_push($maxId, $json['deals'][$i]["id"]);
        }

        $maxId = max($maxId) + 1;
        $json = json_decode(file_get_contents('data.json'), true);
        $json['deals'][] = [
            'id' => $maxId,
            'dealname' => $_POST["deal"],
            'amount' => $_POST["amount"],
            'contactslist' => [],
        ];
        file_put_contents('data.json', json_encode($json));
    }
} else echo "Наименование не введено!";
