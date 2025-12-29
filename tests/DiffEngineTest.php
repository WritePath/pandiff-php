<?php

namespace Pandiff\Tests;

use Pandiff\DiffEngine;
use PHPUnit\Framework\TestCase;

class DiffEngineTest extends TestCase
{
    public function testDiffSimpleReplacement()
    {
        $engine = new DiffEngine();
        $old = 'The quick brown fox.';
        $new = 'The fast brown fox.';

        // old: The,  , quick,  , brown,  , fox, .
        // new: The,  , fast,  , brown,  , fox, .
        // diff: The {--quick--}{++fast++} brown fox.

        $diff = $engine->diff($old, $new);

        $this->assertStringContainsString('{--quick--}', $diff);
        $this->assertStringContainsString('{++fast++}', $diff);
        $this->assertStringContainsString('The ', $diff);
        $this->assertStringContainsString(' brown fox.', $diff);

        // Exact match
        $this->assertEquals('The {--quick--}{++fast++} brown fox.', $diff);
    }

    public function testDiffAddition()
    {
        $engine = new DiffEngine();
        $old = 'one two';
        $new = 'one two three';

        $diff = $engine->diff($old, $new);
        $this->assertEquals('one two{++ ++}{++three++}', $diff);
    }

    public function testDiffDeletion()
    {
        $engine = new DiffEngine();
        $old = 'one two three';
        $new = 'one three';

        // one,  , two,  , three
        // one,  , three
        // Diff: one{-- --}{--two--} three ?
        // Or: one {--two --}three ?
        // Depends on tokenization.
        // Tokenizer: "one", " ", "two", " ", "three"
        // new: "one", " ", "three"
        // "two" and " " matches? No " " matches " ".
        // "two" removed.
        // " " removed?
        // Let's trace:
        // old: one(0), " "(1), two(2), " "(3), three(4)
        // new: one(0), " "(1), three(2)
        // Match: one, " ", three.
        // Removed: two, " ".
        // So: one {--two--}{-- --}three

        $diff = $engine->diff($old, $new);
        $this->assertEquals('one {--two--}{-- --}three', $diff);
    }
}
