$(document).ready(function () {
    $('.js-simulate-test').click(function () {
        $.ajax({
            url: 'simulate.php',
            type: "post",
            data: $('form').serialize(),
            dataType: 'json',
            success: function (data) {
                var $table = $('.js-table'),
                    $successful = $('.js-successful');
                $table.empty();
                $successful.empty();
                if (data.errors) {
                    alert(data.errors);
                    return;
                }
                var record = "<table border='1'><caption>Результаты тестирования</caption>" +
                    "<tr><th>№</th><th>" +
                    "ID вопроса</th><th>Сколько раз встречался</th><th>" +
                    "Сложность вопроса</th><th>Ответ правильный?</th></tr>";
                $.each(data.statistic, function(index, value) {
                    record += "<tr><td>" + (index + 1) + "</td><td>" +
                        value.question_id + "</td><td>" +
                        value.amount_of_usage + "</td><td>" +
                        value.complexity_level + "</td><td>" +
                        value.is_correct + "</td><tr>";
                });
                record += "</table";
                $table.append(record);
                $successful.append('Тестируемый ответил правильно на ' + data.successful + ' вопросов из 40.');
            }
        });
    });
});
