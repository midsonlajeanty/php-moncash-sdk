---
name: Bug report
about: Report a problem with the MonCash SDK
title: ''
labels: bug
assignees: midsonlajeanty
---

**Describe the bug**
A clear and concise description of what the bug is.

**To Reproduce**
Steps to reproduce the behavior:

1. Configuration used (`Config::from([...])`, sandbox or production mode)
2. Code run (e.g. `makePayment(...)`, `getTransactionDetailsByOrderId(...)`, `getTransactionDetailsByTransactionId(...)`)
3. Output / error seen (exception class + message, HTTP response status)

**Expected behavior**
A clear and concise description of what you expected to happen.

**Environment**

- SDK version: [e.g. 1.0.0]
- Composer version: [`composer --version`]
- PHP version: [`php -v`]
- OS: [e.g. Ubuntu 24.04, macOS 15]

**Additional context**
Add any other context about the problem here (sanitized request/response
payloads, CI logs, …).

> ⚠️ Never share secrets in an issue: `clientId`, `clientSecret`, OAuth tokens.
