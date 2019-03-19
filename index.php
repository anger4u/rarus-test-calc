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
                <input type="radio" class="new-flat" id="11" name="type" value="Новостройка" checked>
                <span>Новостройка</span>
            </label>

            <label>
                <input type="radio" class="ready-flat" id="22" name="type" value="Готовая квартира">
                <span>Готовая квартира</span>
            </label>
        </div>

        <div class="calc__row tariff-list">
            <label class="card-label">
                <input type="checkbox" class="card" name="card" id="1" value="Есть зарплатная карта">
                <span>Есть зарплатная карта</span>
            </label>

            <label class="min-doc-label hidden">
                <input type="checkbox" class="min-doc" name="min_doc" id="4" value="Минимум документов" disabled>
                <span>Минимум документов</span>
            </label>

            <label class="low-cat-label">
                <input type="checkbox" class="low-cat" name="low_cat" id="2" value="Льготная категория">
                <span>Льготная категория</span>
            </label>

            <label class="fam-gov-label">
                <input type="checkbox" class="fam-gov" name="fam_gov" id="3" value="Семейная ипотека с государственной поддержкой">
                <span>Семейная ипотека с государственной поддержкой</span>
            </label>
        </div>

        <div class="input-list">
            <h2>СТОИМОСТЬ ОБЪЕКТА КРЕДИТОВАНИЯ</h2>
            <div class="calc__row total-sum">
                <input type="number" min="850000" max="25000000" placeholder="Введите стоимость объекта" name="total_sum"   required>
                <span>руб.</span>
            </div>

            <h2>ПЕРВОНАЧАЛЬНЫЙ ВЗНОС</h2>
            <div class="calc__row init-sum">
                <input type="number" min="127500" max="765000" placeholder="Введите перв-ый взнос" name="init_sum" required>
                <span>руб.</span>
            </div>

            <h2>СРОК КРЕДИТОВАНИЯ</h2>
            <div class="calc__row term-credit">
                <input type="number" min="36" max="300" placeholder="Введите кол-во месяцев" name="term_credit" value="" required>
                <span>мес.</span>
            </div>
        </div>

        <div class="calc__row">
            <button type="submit">Рассчитать кредит</button>
        </div>
    </form>

    <div class="res-table"></div>

    <div class="plan-table"></div>

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





