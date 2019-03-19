'use strict';

$(document).ready(function () {

    var totSumMin = 850000,
        initMin = 0.15,
        initMax = 0.9,
        totSumInp = $("input[name='total_sum']"),
        iniSumInp = $("input[name='init_sum']");

    // Присвоение обработчика для радио при загрузке страницы
    $('.new-flat, .ready-flat').bind('change', onChangeRadio);

    onNewFlatChange();

    // Обработчик для радио
    function onChangeRadio() {
        var id = $(this).attr('id');

        initMin = 0.15;
        $(".tariff-list input, .input-list input").prop('disabled', false);

        if (id === '11') {
            totSumMin = 850000;
            onNewFlatChange();

            $(".min-doc").prop('disabled', true);
        } else if (id === '22') {
            totSumMin = 700000;
            onReadyFlatChange();

            $(".fam-gov").prop('disabled', true);
        }

        // Рассчёт значения общей стоимости при смене радио
        totSumInp.val(totSumMin);

        // Рассчёт мин. значения, макс. значения, и значения первоначального взноса при смене радио
        iniSumInp.attr({
            min: Math.floor(totSumInp.val() * initMin),
            max: Math.floor(totSumInp.val() * initMax),
        }).val(Math.floor(totSumInp.val() * initMin));

        // Рассчёт мин. значения общей стоимости при смене радио
        totSumInp.attr('min', totSumMin);

        // Переключение ненужных чекбоксов в скрытый режим
        $(".min-doc-label, .fam-gov-label").toggleClass('hidden');
    }

    // Обработчик для ипотеки Новостройка, срабатывает при выборе
    function onNewFlatChange() {
        // Сброс чекбоксов
        resetCheckboxes();

        if ($(".card").is(':checked')) {
            initMin = 0.1;
        }

        // Рассчёт значения общей стоимости
        totSumInp.val(totSumMin);

        // // Рассчёт мин. значения и значения первоначального
        iniSumInp.attr({
            min: Math.floor(totSumInp.val() * initMin),
        }).val(Math.floor(totSumInp.val() * initMin));

        // Присвается onchange
        $('.card, .low-cat, .fam-gov').bind('change', onNewFlatCheckboxesChange);
    }

    // Обработчик события для чекбоксов при выборе ипотеки Новостройка
    function onNewFlatCheckboxesChange() {
        var id = $(this).attr('id');

        // Взаимоисключение чекбоксов
        if (id === '1' || id === '2') {
            $('.fam-gov').prop('checked', false);
        } else if (id === '3') {
            $(".card, .low-cat").prop('checked', false);
        }

        // Рассчёт коэффициентов мин. первоначального взноса ипотеки Новостройка
        if ($(".card").is(':checked') || $(".low-cat").is(':checked')) {
            initMin = 0.1;
        } else if ($(".fam-gov").is(':checked')) {
            initMin = 0.2;
        } else {
            initMin = 0.15;
        }

        // Рассчёт мин. значения и значения первоначального взноса ипотеки Новостройка
        iniSumInp.attr({
            min: Math.floor(totSumInp.val() * initMin),
        }).val(Math.floor(totSumInp.val() * initMin));
    }

    // Обработчик для ипотеки Готовая квартира, срабатывает при выборе
    function onReadyFlatChange() {
        // Сброс чекбоксов
        resetCheckboxes();

        if ($(".card").is(':checked')) {
            initMin = 0.1;
        }

        // Рассчёт значения общей стоимости
        totSumInp.val(totSumMin);

        // // Рассчёт мин. значения и значения первоначального
        iniSumInp.attr({
            min: Math.floor(totSumInp.val() * initMin),
        }).val(Math.floor(totSumInp.val() * initMin));

        // Присвается onchange
        $('.card, .low-cat, .min-doc').bind('change', onReadyFlatCheckboxesChange);
    }

    // Обработчик события для чекбоксов при выборе ипотеки Готовая квартира
    function onReadyFlatCheckboxesChange() {
        var id = $(this).attr('id');

        // Взаимоисключение чекбоксов
        if (id === '1' || id === '2') {
            if (id === '1') {
                if ($(".min-doc").is(':checked')) {
                    $(".min-doc, .low-cat").prop('checked', false);
                }
            }
        } else if (id === '4') {
            if ($(".card").is(':checked')) {
                $(".card, .low-cat").prop('checked', false);
            }
        }

        // Присвоение минимальной общей суммы для Общей стоимости ипотеки Готовая квартира
        totSumMin = 700000;

        // Рассчёт коэффициентов мин. первоначального взноса ипотеки Готовая квартира
        if ($(".min-doc").is(':checked')) {
            totSumMin = 600000;

            if ($(".low-cat").is(':checked')) {
                initMin = 0.4;
            } else {
                initMin = 0.35;
            }
        } else if ($(".card").is(':checked')) {
            initMin = 0.1;
        } else if ($(".low-cat").is(':checked')) {
            if ($(".min-doc").is(':checked')) {
                initMin = 0.4;
            } else {
                initMin = 0.1;
            }
        } else {
            initMin = 0.15;
        }

        // Рассчёт мин. значения и значения общей стоимости ипотеки Готовая квартира
        totSumInp.attr('min', totSumMin).val(totSumMin);

        // Рассчёт мин. значения и значения первоначального взноса ипотеки Готовая квартира
        iniSumInp.attr({
            min: Math.floor(totSumInp.val() * initMin),
        }).val(Math.floor(totSumInp.val() * initMin));
    }

    // Сброс всех чекбоксов и снятие обработчика change
    function resetCheckboxes() {
        $('.card, .low-cat, .fam-gov, .min-doc').prop('checked', false).unbind('change');
        $('.card').prop('checked', true);
    }

    // Рассчёт минимального и максимального значения поля инпут для первоначального взноса,
    // в зависимости от общей стоимости недвижимости, рассчёт мин. значения первоначального взноса
    $("input[name='total_sum']").on('input', function () {

        $("input[name='init_sum']").attr('min', Math.floor($("input[name='total_sum']").val() * initMin));
        $("input[name='init_sum']").attr('max', Math.floor($("input[name='total_sum']").val() * initMax));
        $("input[name='init_sum']").val(+$(this).val() * initMin);
    });

    // Подключение ajax запроса для отправки данных в обработчик
    $('.calc').on('submit', function (e) {
        e.preventDefault();

        // присвоение данных, которые будут отправлены
        var radio = $(".calc .type-list input[type='radio']:checked").attr('id');
        var total = $("input[name='total_sum']").val();
        var init = $("input[name='init_sum']").val();
        var term = $("input[name='term_credit']").val();
        var check = [];

        $(".calc .tariff-list input[type='checkbox']:checked").each(function (i, elem) {
            check.push(+$(elem).attr('id'));
        });

        // запрос в обработчик
        $.getJSON('calc.php', {
            type  : radio,
            tariff: check,
            total : total,
            init  : init,
            term  : term,
        }, function (data) {

            console.log(data);

            // получение ответа с условием и вывод результата
            if (data.status === 'ok') {
                console.log(data);
                $('.res-table').html(data.resultTable);
                $('.plan-table').html(data.planTable);
            } else {
                $('.res-table').html(data.msg);
            }

            // Вызов плагита DataTable
            $('#resultTable, #planTable').DataTable({
                dom      : 'Bfrtip',
                paging   : false,
                ordering : false,
                info     : false,
                searching: false,
                buttons  : [
                    'excelHtml5',
                    'pdfHtml5',
                ],
            });
        });
    });
});
