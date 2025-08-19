<?php


if ($_POST["name"]) {
    if (isset($_POST["dealsarr"])) {

        $json = json_decode(file_get_contents('data.json'), true);

        $maxId = [];

        for ($i = 0; $i < count($json['contacts']); $i++) {
            array_push($maxId, $json['contacts'][$i]["id"]);
        }
        $maxId = max($maxId) + 1;
        $json['contacts'][] = [
            'id' => $maxId,
            'name' => $_POST["name"],
            'surname' => $_POST["surname"],
            'dealslist' => $_POST["dealsarr"],
        ];

        for ($o = 0; $o < count($_POST['dealsarr']); $o++) {

            for ($k = 0; $k < count($json['deals']); $k++) {
                if ($_POST['dealsarr'][$o] == $json['deals'][$k]["id"]) {
                    array_push($json['deals'][$k]["contactslist"], $maxId);
                }
            }
        }

        file_put_contents('data.json', json_encode($json));
    } else {
        $maxId = [];

        for ($i = 0; $i < count($json['contacts']); $i++) {
            array_push($maxId, $json['contacts'][$i]["id"]);
        }

        $maxId = max($maxId) + 1;
        $json = json_decode(file_get_contents('data.json'), true);
        $json['contacts'][] = [
            'id' => $maxId,
            'name' => $_POST["name"],
            'surname' => $_POST["surname"],
            'dealslist' => [],
        ];
        file_put_contents('data.json', json_encode($json));
    }
} else echo "Имя не введено!";
