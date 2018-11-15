<?php

require_once('default.php');

$tests = getTotalResults();

function getTotalResults()
{
    global $conn;
    return $conn->query('select * from tests')->fetchAll();
}

?>

<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Результаты тестирований</title>
</head>

<body>

<table border="1">
    <caption>Статистика</caption>
    <tr>
        <th>№</th>
        <th>Интеллект</th>
        <th>Диапазон сложности вопросов</th>
        <th>Результат</th>
    </tr>
    <?php foreach ($tests as $test) { ?>
        <tr>
            <td><?= $test['test_id'] ?></td>
            <td><?= $test['intelligence_level'] ?></td>
            <td><?= $test['complexity_range'] ?></td>
            <td><?= $test['successful_answers'] ?></td>
        </tr>
    <?php } ?>
</table>
</body>

</html>
