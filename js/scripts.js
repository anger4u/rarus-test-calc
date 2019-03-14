'use strict';

$(document).ready(function () {

    // События для радиокнопки со значением Новостройка
    $('.new-flat').on('change', function() {

        // Обнуление выбранных чекбоксов по клику
        $('.tariff-list input').prop("checked", false);

        // Расписание поведений и значений инпутов для фильтрации данных, которые уйдут в запросе
        if($(this).is(':checked')) {
            $('.min-doc').addClass('hidden');
            $('.fam-gov,.tariff-list,.input-list').removeClass('hidden');
            $(".tariff-list input, .input-list input").prop('disabled', false);
            $("input[name='min_doc']").prop('disabled', true);
        }
    });

    // События для радиокнопки со значением Готовая квартира
    $('.ready-flat').on('change', function() {

        // Обнуление выбранных чекбоксов по клику
        $('.tariff-list input').prop("checked", false);

        // Расписание поведений и значений инпутов для фильтрации данных, которые уйдут в запросе
        if($(this).is(':checked')) {
            $('.min-doc,.tariff-list,.input-list').removeClass('hidden');
            $('.fam-gov').addClass('hidden');
            $(".tariff-list input, .input-list input").prop('disabled', false);
            $("input[name='fam_gov']").prop('disabled', true);
        }
    });

    // Корректировка работы чекбоксов, чтобы выбирался лишь один из списка
    $('form > .tariff-list input').on('change', function() {
        var checkbox = $(this);
        var name = checkbox.prop('name');
        if (checkbox.is(':checked')) {
            $(':checkbox[name="' + name + '"]').not($(this)).prop('checked', false);
        }
    });

    // Рассчёт минимального и максимального значения поля инпут для первоначального взноса,
    // в зависимости от общей стоимости недвижимости
    $("input[name='total_sum']").on('input', function() {

        var min = 0.15;
        var max = 0.9;

        $("input[name='init_sum']").attr('min', Math.floor($("input[name='total_sum']").val() * min));
        $("input[name='init_sum']").attr('max', Math.floor($("input[name='total_sum']").val() * max));

        console.log($("input[name='init_sum']").attr('min'));
        console.log($("input[name='init_sum']").attr('max'));
    });

    // Подключение ajax запроса для отправки данных в обработчик
    $('.calc').on('submit', function(e) {
        e.preventDefault();

        // присвоение данных, которые будут отправлены
        var radio =  $(".calc .type-list input[type='radio']:checked").attr('id');
        var check = $(".calc .tariff-list input[type='checkbox']:checked").attr('id');
        var total = $("input[name='total_sum']").val();
        var init = $("input[name='init_sum']").val();
        var term = $("input[name='term_credit']").val();

         // запрос в обработчик
         $.getJSON('calc.php', {type: radio, tariff: check, total: total, init: init, term: term}, function(data){

             // получение ответа с условием и вывод результата
             if (data.status === 'ok') {
                 console.log(data);
                 $('.res-table').html(data.resultTable);
                 $('.plan-table').html(data.planTable);
             } else {
                 $('.res-table').html(data.msg);
             }

             // Вызов плагита DataTable
             $('#resultTable, #planTable').DataTable( {
                 dom: 'Bfrtip',
                 paging: false,
                 ordering:  false,
                 info: false,
                 searching: false,
                 buttons: [
                     'excelHtml5',
                     'pdfHtml5',
                 ]
             });
         });

    });
});