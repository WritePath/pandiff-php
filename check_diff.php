<?php
require __DIR__ . '/vendor/autoload.php';

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\DiffOnlyOutputBuilder;

echo "Checking Differ methods...\n";
$differ = new Differ(new DiffOnlyOutputBuilder(''));
if (method_exists($differ, 'diffToArray')) {
    echo "diffToArray exists.\n";
    $res = $differ->diffToArray(['a', 'b'], ['a', 'c']);
    print_r($res);
} else {
    echo "diffToArray DOES NOT exist.\n";
}
