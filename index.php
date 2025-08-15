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
    </style>
</head>

<body>
    <table class="information" align="center">
        <tr>
            <th>
                Тема
            </th>
            <th>
                Подтема
            </th>
            <th>
                Содержание
            </th>
        </tr>
        <tr>
            <td>
                <div class="theme">Тема 1</div>
                <div class="theme">Тема 2</div>
            </td>
            <td>
                <div class="subtheme"></div>
                <div class="subtheme"></div>
                <div class="subtheme"></div>
            </td>
            <td class="content">
                Некий текст
            </td>
        </tr>
    </table>

    <script>
        themes_list = {
            "Тема 1": ["Подтема 1.1", "Подтема 1.2", "Подтема 1.3"],
            "Тема 2": ["Подтема 2.1", "Подтема 2.2", "Подтема 2.3"]
        }

        document.addEventListener('DOMContentLoaded', function() {

            let themes = document.querySelectorAll('.theme');
            let subthemes = document.querySelectorAll('.subtheme');
            let content = document.querySelector('.content');

            themes.forEach(theme => {
                theme.addEventListener('click', function() {

                    themes.forEach(i => i.classList.remove('selected'));
                    subthemes.forEach(i => i.classList.remove('selected'));

                    this.classList.add('selected');
                    subthemes.forEach(i => i.textContent = "");

                    const show_list = document.querySelectorAll(`.subtheme`);
                    switch (this.textContent) {

                        case Object.keys(themes_list)[0]:
                            show_list.forEach((i, c) => i.textContent = themes_list[Object.keys(themes_list)[0]][c]);
                            break;

                        case Object.keys(themes_list)[1]:
                            show_list.forEach((i, c) => i.textContent = themes_list[Object.keys(themes_list)[1]][c]);
                            break;

                        default:
                            break;
                    }
                    show_list[0].classList.add('selected');
                    content.textContent = `Некий текст, привязанный к ${show_list[0].textContent}`;


                });
            });

            subthemes.forEach(subtheme => {
                subtheme.addEventListener('click', function() {

                    subthemes.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    content.textContent = `Некий текст, привязанный к ${this.textContent}`;

                });
            });
        });
    </script>
</body>

</html>