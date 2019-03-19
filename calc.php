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
     * Присвоение переменным значений из массива $_REQUEST
     */
    $type = $_REQUEST["type"];
    $total = $_REQUEST["total"];
    $init = $_REQUEST["init"];
    $term = $_REQUEST["term"];

    /**
     * Проверка типов данных для тарифа, присвоение значения переменной tariff, запросы в базу по tariff
     */
    if (!empty($_REQUEST["tariff"]) && is_array($_REQUEST["tariff"])) {
        /**
         * Если тариф 1
         */
        if (count($_REQUEST["tariff"]) < 2) {
            /**
             * Проверка типов данных для тарифа и присвоение значения переменной
             */
            if (!is_null($_REQUEST["tariff"][0]) && is_numeric($_REQUEST["tariff"][0])) {
                $tariff = $_REQUEST["tariff"];

                /**
                 * SQL запрос в базу названия тарифа
                 */
                $tarQuery = "SELECT tariff FROM tariffs WHERE id_tariff = " . $tariff[0];
                $tarRes = mysqli_query($dbh, $tarQuery);
                $tarName = mysqli_fetch_row($tarRes);

                /**
                 * SQL запрос в базу % ставки по кредиту
                 */
                $percQuery = "SELECT percentage FROM tariff_types WHERE id_type = " . $type . " AND id_tariff = " . $tariff[0];
                $percRes = mysqli_query($dbh, $percQuery);
                $percentage = mysqli_fetch_row($percRes);
            }
        } else {
            /**
             * Если тарифов 2
             *
             * Проверка типов данных для тарифа и присвоение значения переменной
             */
            if (!is_null($_REQUEST["tariff"][0]) && is_numeric($_REQUEST["tariff"][1]) &&
                !is_null($_REQUEST["tariff"][0]) && is_numeric($_REQUEST["tariff"][1])) {
                $tariff = $_REQUEST["tariff"];

                /**
                 * SQL запрос в базу названия тарифа
                 */
                $tarQuery = "SELECT GROUP_CONCAT(tariff SEPARATOR ',') FROM tariffs WHERE id_tariff = " . $tariff[0] . " OR id_tariff = " . $tariff[1];
                $tarRes = mysqli_query($dbh, $tarQuery);
                $tarName = mysqli_fetch_row($tarRes);

                /**
                 * SQL запрос в базу % ставки по кредиту
                 */
                $percQuery =
                    "SELECT percentage FROM tariff_types_double WHERE id_type = " . $type .
                    " AND id_tariff_one IN(" . implode(',',$tariff) . ")" .
                    " AND id_tariff_two IN(" . implode(',',$tariff) . ")";
                $percRes = mysqli_query($dbh, $percQuery);
                $percentage = mysqli_fetch_row($percRes);
            }
        }

    } else {
        /**
         * Если тарифов нет
         */
        $tariff = 0;
        $tarName = ['Отсутствует'];

        /**
         * SQL запрос в базу % ставки по кредиту
         */
        $percQuery = "SELECT percentage FROM tariff_types WHERE id_type = " . $type . " AND id_tariff = " . $tariff;
        $percRes = mysqli_query($dbh, $percQuery);
        $percentage = mysqli_fetch_row($percRes);
    }

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
    $creditK = ($percMonth * (pow((1 + $percMonth), $term))) / ((pow((1 + $percMonth), $term)) - 1);

    /**
     * Рассчёт размера ежемесячного платежа
     */
    $payMonth = round($creditK * $creditTotal, 2);

    /**
     * Рассчёт суммы кредита с процентами
     */
    $restPay = $term * $payMonth;

    /**
     * Вёрстка результирующей таблицы с занесением переменных с расчётами
     */
    $resultTable = '
        <h2>Результат</h2>
        <table id="resultTable">
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
                    <td>' . $payMonth . '</td>
                </tr>
            </tbody>
        </table>';

    /**
     * Вёрстка таблицы плана выплат с занесением переменных с расчётами
     */
    $planTable =
        '<h2>План выплат ипотеки</h2>
        <table id="planTable">
            <thead>
                <tr>
                    <th>Месяц</th>
                    <th>Остаток по кредиту c % (руб.)</th>
                    <th>Проценты (руб.)</th>
                    <th>Погашение долга (руб.)</th>
                    <th>Ежемесячный платеж (руб.)</th>
                </tr>
            </thead>

            <tbody>';

    for ($i = 1; $i <= $term; $i++) {
        $planTable .=
            '<tr>
                <td>' . $i . '</td>
                <td>' . $restPay . '</td>
                <td>' . round(($percentage[0] / 100) * $payMonth, 2) . '</td>
                <td>' . round($payMonth - ($percentage[0] / 100 * $payMonth), 2) . '</td>
                <td>' . $payMonth . '</td>
            </tr>';

        $restPay = round($restPay - $payMonth, 2);
    }

    $planTable .= '</tbody>
    </table>';

    /**
     * Занесение таблиц в ответный массив с указанием статуса ок
     */
    $arResult['status'] = 'ok';
    $arResult['resultTable'] = $resultTable;
    $arResult['planTable'] = $planTable;

} else {
    $arResult['status'] = "error";
    $arResult['msg'] = "Данные не прошли проверку";
}

/**
 * Вывод результирующего массива для ajax
 */
echo json_encode($arResult);