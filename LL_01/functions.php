<?php
// функции

// сумма + валюта
function formatSumma(float $summa): string
{
    // округл до 2 знаков
    return round($summa, 2) . " " . VALYUTA;
}

// общая сумма
function obshchayaSumma(array $rashody): float
{
    // сначала 0
    $total = 0;

    // перебор
    foreach ($rashody as $rashod) {
        // прибавляем
        $total += $rashod["summa"];
    }

    return $total;
}

// на 1 человека (участников > 0 проверяю в index)
function summaNaCheloveka(float $total, int $uchastniki): float
{
    // делим
    return $total / $uchastniki;
}

// статус бюджета
function statusByudzheta(float $byudzhet, float $total): string
{
    // хватает
    if ($total < $byudzhet) {
        return "Бюджета достаточно. Осталось: " . formatSumma($byudzhet - $total);
    // ровно
    } elseif ($total == $byudzhet) {
        return "Бюджет использован полностью";
    // не хватает
    } else {
        return "Бюджет превышен на " . formatSumma($total - $byudzhet);
    }
}

// самый большой расход, если пусто то null
function samyyBolshoyRashod(array $rashody): ?array
{
    $max = null;

    // ищем макс
    foreach ($rashody as $rashod) {
        // первый или больше
        if ($max === null || $rashod["summa"] > $max["summa"]) {
            $max = $rashod;
        }
    }

    return $max;
}

// расходы от порога
function krupnyeRashody(array $rashody, float $porog): array
{
    // сюда складываем
    $result = [];

    foreach ($rashody as $rashod) {
        // >= порога
        if ($rashod["summa"] >= $porog) {
            // добавить
            $result[] = $rashod;
        }
    }

    return $result;
}
