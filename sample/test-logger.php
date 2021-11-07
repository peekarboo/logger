<?php
require_once __DIR__ . '/../vendor/autoload.php';

$test = new \Ampersandhq\ChallengeLogger\SharonLogger("logfile.log");
$test->alert("testing whatever is up");
