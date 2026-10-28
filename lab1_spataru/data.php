<?php
// данные

// автр
$avtor = "Spataru Evghenii";
// группа
$gruppa = "IAFR2403";

// куда едем
$napravlenie = "Поездка в Сороки";
// сколько чел
$uchastniki = 5;
// бюджет
$byudzhet = 7000;

// валюта
const VALYUTA = "MDL";

// расходы (название, категория, сумма)
$rashody = [
    // транспорт
    [
        "nazvanie" => "Аренда микроавтобуса",
        "kategoriya" => "Транспорт",
        "summa" => 1800
    ],
    // жильё
    [
        "nazvanie" => "Гостевой дом",
        "kategoriya" => "Жильё",
        "summa" => 2500
    ],
    // еда
    [
        "nazvanie" => "Продукты",
        "kategoriya" => "Питание",
        "summa" => 1100
    ],
    // кафе
    [
        "nazvanie" => "Обед в кафе",
        "kategoriya" => "Питание",
        "summa" => 900
    ],
    // крепость
    [
        "nazvanie" => "Вход в Сорокскую крепость",
        "kategoriya" => "Развлечения",
        "summa" => 250
    ],
    // прочее
    [
        "nazvanie" => "Прочие расходы",
        "kategoriya" => "Прочее",
        "summa" => 300
    ]
];

// тесты, раскоментить нужный
// $byudzhet = 6850; // ровно
// $byudzhet = 6000; // превышен
// $uchastniki = 0; // 0 чел
// $rashody[0]["summa"] = 400; $rashody[1]["summa"] = 400; $rashody[2]["summa"] = 400; // нет от 1000
// $rashody = []; // пусто
