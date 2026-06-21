# Contributing

Thank you for considering contributing to `php-moncash-sdk`! Every kind of contribution is welcome: bug reports, documentation, tests, and features.

This project adheres to the [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold it.

## Reporting Bugs

Open an [issue](https://github.com/midsonlajeanty/php-moncash-sdk/issues) using the bug report template. A minimal snippet that reproduces the problem (a `Config`, a `PaymentRequest`, and the `makePayment()` / `getTransactionDetailsByOrderId()` call) makes a fix much faster.

For security vulnerabilities, see [SECURITY.md](.github/SECURITY.md); **never** open a public issue, and never paste real credentials.

## Development Setup

Requires PHP 7.4+ and Composer 2.

```bash
git clone https://github.com/midsonlajeanty/php-moncash-sdk.git
cd php-moncash-sdk
composer install
```

To run the examples, copy the credentials template and fill it in (it is gitignored):

```bash
cp example/constant.php.example example/constant.php
```

## Running the Test Suite

The `test` script runs everything CI runs:

```bash
composer test            # unit tests + refactor check + lint check + static analysis
```

Individual steps are also available:

```bash
composer test:unit       # Pest test suite
composer test:lint       # code style check (PHP-CS-Fixer, dry run)
composer test:types      # static analysis (PHPStan)
composer test:refactor   # Rector check (dry run)

composer lint            # apply code style fixes
composer refactor        # apply Rector refactorings
```

> **Note:** the library targets **PHP 7.4 – 8.5** at runtime, but the dev/test tooling (Rector, PHPStan, Pest 1.x) requires **PHP 8.1+**. Run `composer test` on PHP **8.1 – 8.3** (8.4+ breaks Pest 1.x). CI runs the full suite on `8.1`/`8.2`/`8.3` and a runtime compatibility job (`--no-dev` install + lint + smoke-load) on `7.4`/`8.0`/`8.4`/`8.5`; PHPStan's `phpVersion` range additionally checks the source for **7.4 – 8.5**.

## Coding Standards

- `declare(strict_types=1)` in every source file, typed properties and return types.
- Keep the public API aligned with the NatCash SDK (see the "Common conventions" table in the README).
- Backward compatibility: never remove a public method or class — deprecate it with `@trigger_error(..., E_USER_DEPRECATED)` and keep a delegating alias.
- All code, comments, and documentation in English.

## Pull Requests

Make sure `composer test` is green before opening a PR, and add tests for any new behavior.
