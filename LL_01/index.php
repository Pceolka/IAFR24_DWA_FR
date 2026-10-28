<?php
// Главная страница. Здесь подключаем файлы, считаем итоги и выводим HTML.

// Подключаем файл с данными (__DIR__ - это папка, где лежит этот файл)
require __DIR__ . "/data.php";
// Подключаем файл с функциями (require_once - чтобы не подключить дважды)
require_once __DIR__ . "/functions.php";

// Короткая функция для безопасного вывода текста в HTML.
// htmlspecialchars заменяет символы < > " ' & на безопасные,
// чтобы текст из данных не сломал страницу.
function e(string $text): string
{
    // Возвращаем экранированный текст
    return htmlspecialchars($text, ENT_QUOTES, "UTF-8");
}

// С какой суммы расход считается крупным
$porog = 1000;

// Считаем общую сумму всех расходов
$total = obshchayaSumma($rashody);
// count() возвращает количество элементов в массиве
$kolichestvo = count($rashody);
// Находим самый большой расход
$maxRashod = samyyBolshoyRashod($rashody);
// Отбираем расходы от 1000 и больше
$krupnye = krupnyeRashody($rashody, $porog);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бюджет поездки</title>
    <!-- Простые стили, чтобы таблица выглядела аккуратно -->
    <style>
        /* Шрифт и ширина страницы */
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 0 15px;
            color: #222;
        }
        /* Таблица без двойных рамок, на всю ширину */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        /* Рамки и отступы у ячеек */
        th, td {
            border: 1px solid #999;
            padding: 6px 10px;
            text-align: left;
        }
        /* Серый фон у заголовков таблицы */
        th {
            background: #e8e8e8;
        }
        /* Суммы прижимаем вправо */
        .summa {
            text-align: right;
        }
        /* Зелёный цвет, когда всё хорошо */
        .ok {
            color: green;
        }
        /* Красный цвет для ошибок */
        .error {
            color: #c00;
        }
    </style>
</head>
<body>
    <!-- Шапка: название поездки и общая информация -->
    <h1><?= e($napravlenie) ?></h1>
    <p>Автор: <?= e($avtor) ?></p>
    <p>Группа: <?= e($gruppa) ?></p>
    <!-- PHP_VERSION - встроенная константа с версией PHP -->
    <p>Версия PHP: <?= PHP_VERSION ?></p>
    <p>Количество участников: <?= $uchastniki ?></p>
    <p>Бюджет: <?= formatSumma($byudzhet) ?></p>

    <h2>Расходы</h2>
    <!-- Если расходов нет, то таблицу не рисуем -->
    <?php if ($kolichestvo === 0): ?>
        <p>Расходов нет.</p>
    <?php else: ?>
        <table>
            <!-- Строка с заголовками столбцов -->
            <tr>
                <th>№</th>
                <th>Название расхода</th>
                <th>Категория</th>
                <th>Сумма</th>
            </tr>
            <!-- Счётчик для номера строки, начинаем с 1 -->
            <?php $nomer = 1; ?>
            <!-- Для каждого расхода выводим одну строку таблицы -->
            <?php foreach ($rashody as $rashod): ?>
                <tr>
                    <td><?= $nomer ?></td>
                    <td><?= e($rashod["nazvanie"]) ?></td>
                    <td><?= e($rashod["kategoriya"]) ?></td>
                    <td class="summa"><?= formatSumma($rashod["summa"]) ?></td>
                </tr>
                <!-- Увеличиваем номер для следующей строки -->
                <?php $nomer++; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <p>Количество расходов: <?= $kolichestvo ?></p>

    <h2>Итоги</h2>
    <p>Общая стоимость: <?= formatSumma($total) ?></p>

    <!-- Проверяем участников, чтобы не было деления на ноль -->
    <?php if ($uchastniki <= 0): ?>
        <p class="error">Некорректное количество участников</p>
    <?php else: ?>
        <p>Стоимость на человека: <?= formatSumma(summaNaCheloveka($total, $uchastniki)) ?></p>
    <?php endif; ?>

    <!-- Если бюджет превышен - красный цвет, иначе зелёный -->
    <p class="<?= $total > $byudzhet ? "error" : "ok" ?>"><?= statusByudzheta($byudzhet, $total) ?></p>

    <!-- null значит, что массив расходов пустой -->
    <?php if ($maxRashod !== null): ?>
        <p>Самый большой расход: <?= e($maxRashod["nazvanie"]) ?> — <?= formatSumma($maxRashod["summa"]) ?></p>
    <?php else: ?>
        <p>Самый большой расход: расходов нет</p>
    <?php endif; ?>

    <h2>Расходы от <?= formatSumma($porog) ?></h2>
    <!-- Если крупных расходов нет, то пишем об этом -->
    <?php if (count($krupnye) === 0): ?>
        <p>Расходов от <?= formatSumma($porog) ?> нет.</p>
    <?php else: ?>
        <!-- Иначе выводим их списком -->
        <ul>
            <?php foreach ($krupnye as $rashod): ?>
                <li><?= e($rashod["nazvanie"]) ?> — <?= formatSumma($rashod["summa"]) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
