
# Change Log
All notable changes to this project will be documented in this file.
 
 
## [Unreleased]

## [2.0.0] - 2026-07-03

### Added
- `Config` object (+ `from()`), `PaymentRequest` DTO (+ `from()`).
- Exception hierarchy: `InvalidConfigException`, `InvalidPaymentRequestException`, `ApiException` (subclasses of `MoncashException`).
- `PaymentStatus` constants; injectable Guzzle client (`getClient()`/`setClient()`); lazy OAuth authorization.
- Tooling: PHPStan level 6, Rector, PHP-CS-Fixer; `analyse`/`format`/`lint`/`refactor` scripts; enriched CI pipeline.
- `declare(strict_types=1)` + typed properties + return types throughout.
- `MoncashInterface`, the public contract implemented by the `Moncash` gateway, so consumers can type-hint it and mock it in tests.
- Laravel integration (Laravel 9 to 13): auto-discovered `MoncashServiceProvider`, a `Moncash` facade, and a publishable `config/moncash.php` driven by `MONCASH_*` environment variables. The core SDK stays framework-agnostic; the Laravel layer is opt-in.

### Changed
- `new Moncash(Config, debug)` is the standard constructor signature; `makePayment(PaymentRequest)` returns `PaymentResponse`.
- `Payment` → `PaymentResponse`; `PaymentDetails` → `TransactionDetails` (aliases preserved for backward compatibility).
- Value objects (`Config`, `PaymentRequest`, `PaymentResponse`, `TransactionDetails`), the `Moncash` gateway and the helper classes (`Constants`, `PaymentStatus`, `By`, `Authorization`) are now `final` (previously documented `@final` only). Mock `MoncashInterface` instead of the gateway; construct value objects directly.
- Dev tooling: replaced PHP-CS-Fixer with Laravel Pint, added Larastan next to PHPStan, and upgraded the test stack to Pest 3 + Testbench. CI now runs a Laravel matrix (PHP 8.2–8.4 × Laravel 11–13) plus a runtime-compatibility job (PHP 7.4–8.5).

### Deprecated
- `new Moncash(clientId, clientSecret, debug)`; `makePayment(orderId, amount)`.
- `getPaymentDetailsByOrderId()`/`getPaymentDetailsByTransactionId()` → `getTransactionDetailsBy*()`.
- `TransactionDetails::getCost()` → `getAmount()`; `PaymentResponse::getExpireAt()` → `getExpiresAt()`.
- Classes `Mds\Moncash\Payment` and `Mds\Moncash\PaymentDetails`.
- `Config::fromArray()` → `Config::from()`; `PaymentRequest::fromArray()` → `PaymentRequest::from()`.

### Fixed
- Expiration date construction (`DateTime::setTimestamp()` instead of passing a `strtotime()` result to the constructor).

## [1.0.1] - 2024-06-27

### Changed
- Fixed: Replace `By` enum with `By` class (7.4 compatibility)

## [1.0.0] - 2024-06-27

### Added
- Create Payment Transaction and get gateway URL  (Moncash Checkout)
- Get Transaction Details by Transaction and Order ID
