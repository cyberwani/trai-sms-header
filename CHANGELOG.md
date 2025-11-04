# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/).

---

## [1.0.3] - 2025-11-04
### Added
- `build-json` CLI subcommand to automatically generate or update `sender-list.json` from TRAI Excel (`.xlsx`) or CSV files.
- Documentation updates with full examples for `build-json` usage in `README.md`.

### Changed
- Improved CLI usage instructions and output formatting for better UX.

---

## [1.0.2] - 2025-11-04
### Changed
- Updated `sender-list.json` with latest TRAI DLT sender data and principal entity names.

---

## [1.0.1] - 2025-11-03
### Changed
- Refreshed `sender-list.json` with additional sender entries from TRAI records.

---

## [1.0.0] - 2025-11-02
### Added
- Initial release of **TRAI SMS Header** library and CLI tool.
- Header parsing for Operator, Circle, Sender ID, and Message Type.
- Default data maps for operator and circle prefixes.
- CLI inspection for formatted and JSON output modes.
