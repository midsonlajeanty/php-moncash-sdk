# Security Policy

## Supported Versions

| Version | Supported          |
| :------ | :----------------- |
| 1.x     | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability within this project, please **do not** report it through public GitHub issues.

Instead, please use one of the following private channels:

- **GitHub Private Vulnerability Reporting** (Preferred):
  [Report a vulnerability](https://github.com/midsonlajeanty/php-moncash-sdk/security/advisories/new)
- **Email**: [midsonlajeanty@proton.me](mailto:midsonlajeanty@proton.me)

### What to include

To help us address the issue quickly, please include as much detail as possible:

- **Type of issue**: (e.g., credential leak, token exposure, request forgery, etc.)
- **Affected version(s)**
- **Steps to reproduce**: Ideally with a minimal snippet.
- **Potential impact**: How this vulnerability could be exploited.

### Our Response

You will receive an initial response within **72 hours**. Once the issue is confirmed, a fix will be prepared and released as quickly as possible. You will be credited in the release notes unless you prefer to remain anonymous.

## Scope Notes

This SDK handles payment credentials (client id / client secret) and OAuth tokens for the MonCash gateway. Never commit real credentials, and never paste secrets into a public issue. Treat the contents of `example/constant.php` as secrets — it is gitignored on purpose.
