
# Change Log
All notable changes to this project will be documented in this file.
 
 
## [Unreleased]

### Added
- `Config` object (+ `from()`), `PaymentRequest` DTO (+ `from()`).
- Exception hierarchy: `InvalidConfigException`, `InvalidPaymentRequestException`, `ApiException` (subclasses of `MoncashException`).
- `PaymentStatus` constants; injectable Guzzle client (`getClient()`/`setClient()`); lazy OAuth authorization.
- Tooling: PHPStan level 6, Rector, PHP-CS-Fixer; `analyse`/`format`/`lint`/`refactor` scripts; enriched CI pipeline.
- `declare(strict_types=1)` + typed properties + return types throughout.

### Changed
- `new Moncash(Config, debug)` is the standard constructor signature; `makePayment(PaymentRequest)` returns `PaymentResponse`.
- `Payment` → `PaymentResponse`; `PaymentDetails` → `TransactionDetails` (aliases preserved for backward compatibility).

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
