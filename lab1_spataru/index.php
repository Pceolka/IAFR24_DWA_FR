<?php
// подключаем данные
require __DIR__ . "/data.php";
// и функции
require_once __DIR__ . "/functions.php";

// экранирование
function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, "UTF-8");
}

// порог крупных
$porog = 1000;

// итого
$total = obshchayaSumma($rashody);
// кол-во
$kolichestvo = count($rashody);
// макс
$maxRashod = samyyBolshoyRashod($rashody);
// крупные
$krupnye = krupnyeRashody($rashody, $porog);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бюджет поездки</title>
    <!-- стили -->
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 0 15px;
            color: #222;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 10px;
            text-align: left;
        }
        th {
            background: #e8e8e8;
        }
        /* суммы вправо */
        .summa {
            text-align: right;
        }
        .ok {
            color: green;
        }
        .error {
            color: #c00;
        }
    </style>
</head>
<body>
    <!-- шапка -->
    <h1><?= e($napravlenie) ?></h1>
    <p>Автор: <?= e($avtor) ?></p>
    <p>Группа: <?= e($gruppa) ?></p>
    <p>Версия PHP: <?= PHP_VERSION ?></p>
    <p>Количество участников: <?= $uchastniki ?></p>
    <p>Бюджет: <?= formatSumma($byudzhet) ?></p>

    <h2>Расходы</h2>
    <!-- если пусто -->
    <?php if ($kolichestvo === 0): ?>
        <p>Расходов нет.</p>
    <?php else: ?>
        <!-- таблица -->
        <table>
            <tr>
                <th>№</th>
                <th>Название расхода</th>
                <th>Категория</th>
                <th>Сумма</th>
            </tr>
            <!-- номер строки -->
            <?php $nomer = 1; ?>
            <?php foreach ($rashody as $rashod): ?>
                <tr>
                    <td><?= $nomer ?></td>
                    <td><?= e($rashod["nazvanie"]) ?></td>
                    <td><?= e($rashod["kategoriya"]) ?></td>
                    <td class="summa"><?= formatSumma($rashod["summa"]) ?></td>
                </tr>
                <?php $nomer++; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <p>Количество расходов: <?= $kolichestvo ?></p>

    <!-- итоги -->
    <h2>Итоги</h2>
    <p>Общая стоимость: <?= formatSumma($total) ?></p>

    <!-- чтоб не делить на 0 -->
    <?php if ($uchastniki <= 0): ?>
        <p class="error">Некорректное количество участников</p>
    <?php else: ?>
        <p>Стоимость на человека: <?= formatSumma(summaNaCheloveka($total, $uchastniki)) ?></p>
    <?php endif; ?>

    <!-- красный если превышен -->
    <p class="<?= $total > $byudzhet ? "error" : "ok" ?>"><?= statusByudzheta($byudzhet, $total) ?></p>

    <!-- макс расход -->
    <?php if ($maxRashod !== null): ?>
        <p>Самый большой расход: <?= e($maxRashod["nazvanie"]) ?> — <?= formatSumma($maxRashod["summa"]) ?></p>
    <?php else: ?>
        <p>Самый большой расход: расходов нет</p>
    <?php endif; ?>

    <!-- крупные -->
    <h2>Расходы от <?= formatSumma($porog) ?></h2>
    <?php if (count($krupnye) === 0): ?>
        <p>Расходов от <?= formatSumma($porog) ?> нет.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($krupnye as $rashod): ?>
                <li><?= e($rashod["nazvanie"]) ?> — <?= formatSumma($rashod["summa"]) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
