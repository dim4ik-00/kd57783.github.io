<?php

require 'autoload.php';

use App\Serializer;
use App\Encoder\CsvEncoder;
use App\Encoder\SsvEncoder;
use App\Encoder\TsvEncoder;
use App\Encoder\JsonEncoder;
use App\Encoder\YamlEncoder;

$serializer = new Serializer([
    new CsvEncoder(),
    new SsvEncoder(),
    new TsvEncoder(),
    new JsonEncoder(),
    new YamlEncoder(),
]);

$formats = [
    'csv',
    'json',
    'yaml',
    'tsv',
    'ssv'
];
$input = $_POST['input'] ?? $_COOKIE['input'] ?? '';

$inputFormat = $_POST['input_format']
    ?? $_COOKIE['input_format']
    ?? 'csv';

$outputFormat = $_POST['output_format']
    ?? $_COOKIE['output_format']
    ?? 'json';

$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    setcookie('input', $input, time() + 3600);

    setcookie('input_format', $inputFormat, time() + 3600);

    setcookie('output_format', $outputFormat, time() + 3600);

    $output = $serializer->convert(
        $input,
        $inputFormat,
        $outputFormat
    );
}

require 'templates/layout.php';