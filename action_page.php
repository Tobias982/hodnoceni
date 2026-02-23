<?php
// Jednoduché uložení recenze do JSON souboru a redirect zpět na index.php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /index.php");
    exit;
}

$name = trim($_POST["name"] ?? "");
$comment = trim($_POST["comment"] ?? "");

// základní validace
if ($name === "" || $comment === "") {
    header("Location: /index.php");
    exit;
}

// Ochrana proti extrémně dlouhým vstupům
$name = mb_substr($name, 0, 60);
$comment = mb_substr($comment, 0, 500);

$reviewsFile = __DIR__ . "/reviews.json";
$reviews = [];

// načti existující
if (file_exists($reviewsFile)) {
    $json = file_get_contents($reviewsFile);
    $reviews = json_decode($json, true);
    if (!is_array($reviews)) $reviews = [];
}

// přidej novou
$reviews[] = [
    "name" => $name,
    "comment" => $comment,
    "date" => date("d.m.Y H:i")
];

// ulož
file_put_contents(
    $reviewsFile,
    json_encode($reviews, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

// redirect zpět
header("Location: /index.php");
exit;