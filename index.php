<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Система онлайн тестирования</title>
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="js/main.js"></script>

<div>
    <form>
        <label>Нижняя граница сложности:</label><br><input type="text" name="complexity-lower-limit" class=".complexity-lower-limit"><br>
        <label>Верхняя граница сложности:</label><br><input type="text" name="complexity-upper-limit" class=".complexity-upper-limit"><br>
        <label>Уровень интеллекта:</label><br><input type="text" name="intelligence-level" class="intelligence-level"><br><br>
        <input type="button" class="js-simulate-test" value="Запуск">
    </form>
</div>
<br><br>
<div class="js-table">
</div>
<br>
<span class="js-successful"></span><br><br>
<a href="total_results.php" target="_blank">Результаты тестирования</a>
</body>

</html>