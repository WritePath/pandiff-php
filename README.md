# Pandiff PHP

A native PHP library for generating word-level diffs of plain text, inspired by the JavaScript `pandiff` tool. This library focuses on providing a reusable, AST-like comparison of text streams (tokenized by words) without external binary dependencies like Pandoc.

## Features

- **Word-level Diffing**: Accurately highlights additions and deletions at the word level, detecting changes within sentences rather than just line-by-line.
- **Native PHP**: Built on top of `sebastian/diff`, requiring no non-PHP binaries or external command-line tools.
- **Customizable Output**: Returns a string with `{--deleted--}` and `{++added++}` markers, which can be easily parsed or replaced with HTML tags or other formats.
- **Puncutation Aware**: Tokenizer respects punctuation and whitespace, ensuring clean diffs.

## Installation

Install via Composer:

```bash
composer require writepath/pandiff-php
```

## Usage

### Basic Usage

Use the `DiffEngine` to compare two strings.

```php
use Pandiff\DiffEngine;

$engine = new DiffEngine();

$old = "The quick brown fox.";
$new = "The fast brown fox.";

$result = $engine->diff($old, $new);

echo $result;
// Output: The {--quick--}{++fast++} brown fox.
```

### Processing Output (HTML)

The default output uses a custom format `{--...--}` for deletions and `{++...++}` for additions. You can easily process this into HTML using regular expressions.

```php
use Pandiff\DiffEngine;

$engine = new DiffEngine();

$old = "This is a simple test.";
$new = "This is a complex test.";

$diff = $engine->diff($old, $new);

// Convert to HTML
$html = preg_replace(
    ['/\{\+\+(.*?)\+\+\}/', '/\{\-\-(.*?)\-\-\}/'],
    ['<ins>$1</ins>', '<del>$1</del>'],
    $diff
);

echo $html;
// Output: This is a <del>simple</del><ins>complex</ins> test.
```

### How it Works

1.  **Tokenization**: The input text is split into a stream of tokens (words, whitespace, punctuation) using a Unicode-aware regex.
2.  **LCS Calculation**: The library uses a Longest Common Subsequence algorithm (via `sebastian/diff`) to find the differences between the token streams.
3.  **Reconstruction**: The result is reconstructed into a string with markup indicating the changes.

## Testing

Run the test suite with PHPUnit:

```bash
vendor/bin/phpunit
```

## License

MIT