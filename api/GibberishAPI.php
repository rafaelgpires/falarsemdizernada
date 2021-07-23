<?php

# Dependencies
require_once('Gibberish.php');

# Input
$time = $_GET['time'] ?? 5;
$start = $_GET['start'] ?? 'Caros colegas, ';

# Validate/defaults
// Validate $time
if (empty($time) || !filter_var($time, FILTER_VALIDATE_INT) || $time < 5) {
    $time = 5;
} elseif ($time > 600000) {
    $time = 600000;
}

// Validate $start
$regex = '/^[\(\)\.\-\?!:,a-zA-Z0-9 ]{2,500}$/';
if (!preg_match($regex, $start)) {
    $start = 'Caros colegas, ';
}

# Execute
$gibberish = new Gibberish();
echo json_encode($gibberish->buildSentences($time, $start));
