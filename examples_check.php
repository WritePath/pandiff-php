<?php

require __DIR__ . '/vendor/autoload.php';

use Pandiff\DiffEngine;

// Example 1: Basic Usage
echo "--- Example 1: Basic Usage ---\n";
$engine = new DiffEngine();
$old = "The quick brown fox.";
$new = "The fast brown fox.";
$result = $engine->diff($old, $new);
echo "Output: " . $result . "\n\n";

// Example 2: HTML Output
echo "--- Example 2: HTML Output ---\n";
$old = "This is a simple test.";
$new = "This is a complex test.";

$diff = $engine->diff($old, $new);

// Simple regex replacement to generate HTML
$html = preg_replace(
    ['/\{\+\+(.*?)\+\+\}/', '/\{\-\-(.*?)\-\-\}/'],
    ['<ins>$1</ins>', '<del>$1</del>'],
    $diff
);

echo "HTML: " . $html . "\n";
