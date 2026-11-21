# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned
- Event broadcasting
- Async event processing
- Event priorities

---

## [2.0.0] - 2026-11-21

### Breaking
- Require Triangle Engine 9.x for the plugin configuration hooks used by event bootstrap; Engine 8 is no longer supported.

### Changed
- Validate each converted event listener before registration.

---

## [1.0.0] - 2024-08-01 - LTS Release

### Added
- Initial LTS release
- Full documentation
- Event system (Observer pattern)
- Event listeners
- Event subscribers
- Event queuing support
- Wildcard event listeners

### Changed
- Improved event dispatch performance
- Enhanced event listener registration
