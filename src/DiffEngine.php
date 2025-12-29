<?php

namespace Pandiff;

use SebastianBergmann\Diff\Differ;

class DiffEngine
{
    private Tokenizer $tokenizer;
    private Differ $differ;

    public function __construct(?Tokenizer $tokenizer = null)
    {
        $this->tokenizer = $tokenizer ?? new Tokenizer();
        $this->differ = new Differ(new \SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder([
            'fromFile' => 'Original',
            'toFile' => 'New',
        ]));
    }

    public function diff(string $old, string $new): string
    {
        $oldTokens = $this->tokenizer->tokenize($old);
        $newTokens = $this->tokenizer->tokenize($new);

        // diffToArray returns an array of arrays representing the diff.
        // Each sub-array is [string $token, int $type]
        // 0 = Unchanged, 1 = Added, 2 = Removed
        $diffs = $this->differ->diffToArray($oldTokens, $newTokens);

        $output = '';

        foreach ($diffs as $diff) {
            $content = $diff[0];
            $type = $diff[1];

            switch ($type) {
                case 1: // Added
                    $output .= '{++' . $content . '++}';
                    break;
                case 2: // Removed
                    $output .= '{--' . $content . '--}';
                    break;
                case 0: // Unchanged
                    $output .= $content;
                    break;
            }
        }

        return $output;
    }
}
