<?php

/**
 * Подключение к MySql и базе данных
 */
$host = 'localhost';
$database = 'RARUS_CALC';
$user = 'root';
$pswd = '';

$dbh = mysqli_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL. ");
mysqli_select_db($dbh, $database) or die("Не могу подключиться к базе. ");

/**
 * Проверка типов данных для гражданских
 *
 * Проверка типов входных данных для всех типов ипотек, кроме военной. При выполнении условия проверяется
 * наличие тарифа и присваевается значение переменной в зависимости от результата.
 *
 */
if ((!is_null($_REQUEST["type"]) && is_numeric($_REQUEST["type"])) &&
    (!is_null($_REQUEST["total"]) && is_numeric($_REQUEST["total"])) &&
    (!is_null($_REQUEST["init"]) && is_numeric($_REQUEST["init"])) &&
    (!is_null($_REQUEST["term"]) && is_numeric($_REQUEST["term"]))) {

    /**
     * Проверка типов данных для тарифа и присвоение значения переменной
     */
    if (!empty($_REQUEST["tariff"])) {
        if (!is_null($_REQUEST["tariff"]) && is_numeric($_REQUEST["tariff"])) {
            $tariff = $_REQUEST["tariff"];

            // TARIFF NAME SQL QUERY
            $tarQuery = "SELECT tariff FROM tariffs WHERE id_tariff = " . $tariff;
            $tarRes = mysqli_query($dbh, $tarQuery);
            $tarName = mysqli_fetch_row($tarRes);
        }
    } else {
        $tariff = 0;
    }

    /**
     * Присвоение переменным значений из массива $_REQUEST
     */
    $type = $_REQUEST["type"];
    $total = $_REQUEST["total"];
    $init = $_REQUEST["init"];
    $term = $_REQUEST["term"];

    /**
     * Логирование входных данных
     */
    $log = date('Y-m-d H:i:s') . ' ' . print_r($_REQUEST, true);
    file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

    /**
     * SQL запрос в базу названия типа ипотеки
     */
    $tNameQuery = "SELECT type FROM types WHERE id_type = " . $type;
    $tNameRes = mysqli_query($dbh, $tNameQuery);
    $typeName = mysqli_fetch_row($tNameRes);

    /**
     * SQL запрос в базу % ставки по кредиту
     */
    $percQuery = "SELECT percentage FROM tariff_types WHERE id_type = " . $type . " AND id_tariff = " . $tariff;
    $percRes = mysqli_query($dbh, $percQuery);
    $percentage = mysqli_fetch_row($percRes);

    /**
     * Рассчёт ежемесячной % ставки
     */
    $percMonth = $percentage[0] / 12 / 100;

    /**
     * Рассчёт суммы кредита
     */
    $creditTotal = $total - $init;

    /**
     * Рассчёт коэффициента ипотеки по формуле из ТЗ
     */
    $creditK = ( $percMonth * (pow((1 + $percMonth), $term)) ) / ( (pow((1 + $percMonth), $term)) -1 );

    /**
     * Рассчёт размера ежемесячного платежа
     */
    $result = round($creditK * $creditTotal, 2);

    /**
     * Вёрстка результирующей таблицы с занесением переменных с расчётами
     */
    $html = '
        <h2>Результат</h2>
        <table id="result">
            <thead>
                <tr>
                    <th>Тип ипотеки</th>
                    <th>Тариф по ипотеке</th>
                    <th>Стоимость объекта предитования</th>
                    <th>Первоначальный взнос</th>
                    <th>Срок кредитования (мес.)</th>
                    <th>Сумма кредита</th>
                    <th>% ставка по кредиту</th>
                    <th>Ежемесячный платёж</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>' . $typeName[0] . '</td>
                    <td>' . $tarName[0] . '</td>
                    <td>' . $total . '</td>
                    <td>' . $init . '</td>
                    <td>' . $term . '</td>
                    <td>' . $creditTotal . '</td>
                    <td>' . $percentage[0] . '</td>
                    <td>' . $result . '</td>
                </tr>
            </tbody>
        </table>';

    /**
     * Занесение результирующей таблицы в ответный массив с указанием статуса ок
     */
    $arResult['status'] = 'ok';
    $arResult['html'] = $html;

/**
 * Проверка типов данных для военных
 *
 * Если предыдущее условие не выполнилось, значит ипотека военная.
 * Проверка типов входных данных для военной ипотеки. При выполнении условия производится рассчёт
 * максимальной суммы ипотеки и срок её выплаты.
 *
 */
} elseif ((!is_null($_REQUEST["type"]) && is_numeric($_REQUEST["type"])) &&
           !is_null($_REQUEST["age"]) && is_numeric($_REQUEST["age"])) {

    /**
     * Логирование входных данных
     */
    $log = date('Y-m-d H:i:s') . ' ' . print_r($_REQUEST, true);
    file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

    /**
     * SQL запрос в базу названия типа ипотеки
     */
    $tNameQuery = "SELECT type FROM types WHERE id_type = " . $_REQUEST["type"];
    $tNameRes = mysqli_query($dbh, $tNameQuery);
    $typeName = mysqli_fetch_row($tNameRes);

    /**
     * Присвоений значения возраста из запроса и проведение рассчётов
     */
    $age = $_REQUEST["age"];

    if ($age < 25) {
        $term = 20;
        $sum = 2510192;
    } else {
        $term = 44 - $age;
        $ageCoef = $age - 24 + 3;
        $sum = round(2510192 - (2510192 * ($ageCoef * 3.5 / 100)), 2);
    }

    /**
     * Вёрстка результирующей таблицы с занесением переменных с расчётами
     */
    $html = '
        <h2>Результат</h2>
        <table id="result">
            <thead>
                <tr>
                    <th>Тип ипотеки</th>
                    <th>Возраст</th>
                    <th>Срок кредитования (лет)</th>
                    <th>Сумма кредита</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>' . $typeName[0] . '</td>
                    <td>' . $_REQUEST["age"] . '</td>
                    <td>' . $term . '</td>
                    <td>' . $sum . '</td>
                </tr>
            </tbody>
            
        </table>';

    /**
     * Занесение результирующей таблицы в ответный массив с указанием статуса ок
     */
    $arResult['status'] = 'ok';
    $arResult['html'] = $html;

/**
 * Занесение статуса ошибки и текст сообщения об ошибке в результирующий массив,
 * eсли ни одно из условий не выполнилось.
 */
} else {
    $arResult['status'] = "error";
    $arResult['msg'] = "Данные не прошли проверку";
}

/**
 * Вывод результирующего массива для ajax
 */
echo json_encode($arResult);