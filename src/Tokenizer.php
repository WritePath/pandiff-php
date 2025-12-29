<?php

namespace Pandiff;

class Tokenizer
{
    public function tokenize(string $text): array
    {
        // Split text into words and non-words (whitespace, punctuation).
        // Captures:
        // 1. Sequences of word characters (letters, numbers, underscores)
        // 2. Whitespace
        // 3. Other characters (punctuation)
        
        // This regex splits by word boundaries but keeps delimiters.
        // We want to group continuous words? No, word-level.
        
        // Let's use a regex that matches "tokens".
        // \w+ matching words.
        // \s+ matching whitespace.
        // Everything else single char? Or grouped punctuation?
        
        // Simple approach: split by word boundary.
        return preg_split('/(\w+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    }
}
