<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Темы и подтемы</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            flex-direction: column;
        }

        .information,
        th,
        td {
            border: 4px solid;
            border-collapse: collapse;
            padding: 10px;
            vertical-align: top;
        }

        .theme,
        .subtheme {
            padding: 6px;
            cursor: pointer;
        }

        .theme:hover,
        .subtheme:hover {
            background-color: gray;
            color: white;
        }

        .selected {
            background-color: yellow;
        }

        .content {
            min-height: 100px;
            padding: 15px;
            background-color: white;
            border-radius: 5px;
        }

        .hide {
            visibility: hidden;
        }

        input,
        select,
        button {
            border: solid 2px;
        }

        button {
            background-color: lightgrey;
            cursor: pointer;
        }

        p {
            font-size: 11px;
        }
    </style>
</head>

<body>
    <table class="information" align="center">
        <tr>
            <th>
                Меню
            </th>
            <th>
                Список
            </th>
            <th>
                Содержимое
            </th>
        </tr>
        <tr>
            <td>
                <div class="theme">Сделки</div>
                <div class="theme">Контакты</div>
            </td>

            <td class="list hide">
                <script>
                    let them = document.querySelectorAll('.theme');
                    them.forEach(t => {
                        t.addEventListener('click', function() {
                            switch (this.textContent) {

                                case "Сделки":
                                    <?php

                                    $jsonData = file_get_contents('data.json');

                                    $dataArray = json_decode($jsonData, true);
                                    foreach ($dataArray["deals"] as $row) {
                                        echo "</script><div class='subtheme' id='" . $row["id"] . "'>" . $row["dealname"] . "</div><script>";
                                    }
                                    ?>break;
                                case "Контакты":
                                    <?php

                                    $jsonData = file_get_contents('data.json');

                                    $dataArray = json_decode($jsonData, true);
                                    foreach ($dataArray["contacts"] as $row) {
                                        echo "</script><div class='subtheme' id='" . $row["id"] . "'>" . $row["name"] . " " . $row["surname"] . "</div><script>";
                                    }
                                    ?>break;
                            }
                        });
                    });
                </script>
            </td>
            <td class="content" rowspan="2">
                Некий текст
            </td>
        </tr>
        <tr>
            <td>
                <form action="deal_request.php" method="post">
                    <p>Наименование (обязательно):</p><br>
                    <input name="deal" id="deal" type="text"><br>
                    <p>Сумма:</p><br>
                    <input name="amount" id="amount" type="number"><br>
                    <p>Контакты:</p><br>
                    <select multiple name="contactsarr[]" id="contacts"><br>
                        <?php
                        $jsonData = file_get_contents('data.json');

                        $dataArray = json_decode($jsonData, true);
                        foreach ($dataArray["contacts"] as $row) {
                            echo "<option value='" . $row["id"] . "'>" . $row["id"] . " " . $row["name"] . " " . $row["surname"] . "</option>";
                        }
                        ?>
                    </select><br>
                    <button type="submit">Добавить сделку</button>
                </form>
            </td>

            <td>
                <form action="contact_request.php" method="post">
                    <p>Имя (обязательно):</p><br>
                    <input name="name" id="name" type="text"><br>
                    <p>Фамилия:</p><br>
                    <input name="surname" id="surname" type="text"><br>
                    <p>Сделки:</p><br>
                    <select multiple name="dealsarr[]" id="deals">
                        <?php
                        $jsonData = file_get_contents('data.json');

                        $dataArray = json_decode($jsonData, true);
                        foreach ($dataArray["deals"] as $row) {
                            echo "<option value='" . $row["id"] . "'>" . $row["id"] . " " . $row["dealname"] . "</option>";
                        }
                        ?>
                    </select><br>
                    <button type="submit">Добавить контакт</button>
                </form>
            </td>
        </tr>
    </table>

    <script>
        var jsArray = <?php echo $jsonData; ?>;
        document.addEventListener('DOMContentLoaded', function() {
            let themes = document.querySelectorAll('.theme');
            let subthemes = document.querySelectorAll('.subtheme');
            let content = document.querySelector('.content');

            themes.forEach(theme => {
                theme.addEventListener('click', function() {
                    document.querySelector('.list').classList.remove("hide");
                    themes.forEach(i => i.classList.remove('selected'));
                    subthemes.forEach(i => i.classList.remove('selected'));

                    this.classList.add('selected');
                    subthemes.forEach(i => i.textContent = "");

                    switch (this.textContent) {

                        case "Сделки":
                            subthemes.forEach((i, c) => {
                                if (i.id == jsArray["deals"][c]["id"]) {
                                    i.innerHTML = jsArray["deals"][c]["dealname"];
                                }
                            });
                            break;

                        case "Контакты":
                            subthemes.forEach((i, c) => {
                                if (i.id == jsArray["contacts"][c]["id"]) {
                                    i.innerHTML = jsArray["contacts"][c]["name"] + " " + jsArray["contacts"][c]["surname"];
                                }
                            });
                            break;

                        default:
                            break;
                    }


                    switch (document.getElementsByClassName("theme selected")[0].innerHTML) {

                        case "Сделки":
                            for (let i = 0; i <= jsArray["deals"].length; i++) {
                                if (jsArray["deals"][i]["id"] == this.id) {
                                    content.innerHTML = `ID сделки - ${jsArray["deals"][i]["id"]}<br>Наименование - ${jsArray["deals"][i]["dealname"]}<br>Сумма - ${jsArray["deals"][i]["amount"]}<br>ID контактов - ${jsArray["deals"][i]["contactslist"]}`;
                                    subthemes[0].classList.add('selected');
                                }
                            }
                            break;

                        case "Контакты":
                            for (let i = 0; i <= jsArray["contacts"].length; i++) {
                                if (jsArray["contacts"][i]["id"] == this.id) {
                                    content.innerHTML = `ID контакта - ${jsArray["contacts"][i]["id"]}<br>Имя - ${jsArray["contacts"][i]["name"]}<br>Фамилия - ${jsArray["contacts"][i]["surname"]}<br>ID сделок - ${jsArray["contacts"][i]["dealslist"]}`;
                                    subthemes[0].classList.add('selected');
                                }
                            }
                            break;

                        default:
                            break;
                    }



                });
            });

            subthemes.forEach(subtheme => {
                subtheme.addEventListener('click', function() {

                    subthemes.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');


                    switch (document.getElementsByClassName("theme selected")[0].innerHTML) {

                        case "Сделки":
                            for (let i = 0; i <= jsArray["deals"].length; i++) {
                                if (jsArray["deals"][i]["id"] == this.id) {
                                    content.innerHTML = `ID сделки - ${jsArray["deals"][i]["id"]}<br>Наименование - ${jsArray["deals"][i]["dealname"]}<br>Сумма - ${jsArray["deals"][i]["amount"]}<br>ID контактов - ${jsArray["deals"][i]["contactslist"]}`;
                                }
                            }
                            break;

                        case "Контакты":
                            for (let i = 0; i <= jsArray["contacts"].length; i++) {
                                if (jsArray["contacts"][i]["id"] == this.id) {
                                    content.innerHTML = `ID контакта - ${jsArray["contacts"][i]["id"]}<br>Имя - ${jsArray["contacts"][i]["name"]}<br>Фамилия - ${jsArray["contacts"][i]["surname"]}<br>ID сделок - ${jsArray["contacts"][i]["dealslist"]}`;
                                }
                            }
                            break;

                        default:
                            break;
                    }
                });
            });
        });
    </script>
</body>

</html>