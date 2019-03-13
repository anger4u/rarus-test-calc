<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Кредитный калькулятор</title>

    <!-- custom css -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- DataTables css-->
    <link rel="stylesheet" href="css/libs/DataTable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/libs/DataTable/buttons.dataTables.min.css">

</head>
<body>
<div class="container">
    <form action="calc.php" method="POST" id="calc-form" class="calc" name="calc_form">
        <div class="calc__row type-list">
            <label>
                <input type="radio" class="new-flat" id="1" name="type" value="Новостройка" checked>
                <span>Новостройка</span>
            </label>

            <label>
                <input type="radio" class="ready-flat" id="2" name="type" value="Готовая квартира">
                <span>Готовая квартира</span>
            </label>

            <label>
                <input type="radio" class="war-flat" id="3" name="type" value="Военный (участник НИС)">
                <span>Военный (участник НИС)</span>
            </label>
        </div>

        <div class="calc__row tariff-list">
            <label class="card">
                <input type="checkbox" name="discount" id="1" value="Есть зарплатная карта">
                <span>Есть зарплатная карта</span>
            </label>

            <label class="min-doc hidden">
                <input type="checkbox" name="discount" id="4" value="Минимум документов" disabled>
                <span>Минимум документов</span>
            </label>

            <label class="low-cat">
                <input type="checkbox" name="discount" id="2" value="Льготная категория">
                <span>Льготная категория</span>
            </label>

            <label class="fam-gov">
                <input type="checkbox" name="discount" id="3" value="Семейная ипотека с государственной поддержкой">
                <span>Семейная ипотека с государственной поддержкой</span>
            </label>
        </div>

        <div class="input-list">
            <div class="calc__row total-sum">
                <input type="number" min="850000" max="25000000" placeholder="Стоимость объекта кредитования" name="total_sum" value="" required>
                <span>руб.</span>
            </div>

            <div class="calc__row init-sum">
                <input type="number" min="85000" max="22500000" placeholder="Первоначальный взнос" name="init_sum" value="" required>
                <span>руб.</span>
            </div>

            <div class="calc__row term-credit">
                <input type="number" min="36" max="300" placeholder="Срок кредитования" name="term_credit" value="" required>
                <span>мес.</span>
            </div>
        </div>

        <div class="calc__row military hidden">
            <input type="number" min="20" max="41" placeholder="Ваш возраст" name="military_age" value="" disabled>
        </div>

        <div class="calc__row">
            <button type="submit">Рассчитать кредит</button>
        </div>
    </form>

    <div class="res-table"></div>

</div>

<!-- jQuery lib -->
<script src="js/libs/jquery.js"></script>

<!--DataTables libs-->
<script src="js/libs/DataTable/jquery.dataTables.min.js"></script>
<script src="js/libs/DataTable/dataTables.buttons.min.js"></script>
<script src="js/libs/DataTable/jszip.min.js"></script>
<script src="js/libs/DataTable/pdfmake.min.js"></script>
<script src="js/libs/DataTable/vfs_fonts.js"></script>
<script src="js/libs/DataTable/buttons.html5.min.js"></script>
<script src="js/libs/DataTable/buttons.print.min.js"></script>

<!-- custom scripts -->
<script src="js/scripts.js"></script>

</body>
</html>





