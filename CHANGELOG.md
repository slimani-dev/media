# Changelog

## v 0.0.6

### Changed

- Updated `addMediaFiles` function to allow preserving original files.
    - Now accepts an additional parameter `$preserveOriginal` to specify whether to preserve the original file.
    - If `$preserveOriginal` is set to `true`, the original file will be preserved.

## V 0.0.5

### Added

- Added `addMediaFiles` function to the class.
    - Allows adding media files to a specified collection.
    - Deletes existing media files in the collection if `keep` parameter is set to `false`.
    - Generates a unique code based on current time to prepend to the file name.

### Fixed

- Fixed a bug in `registerMediaCollections` function.
    - Added condition to prevent arrays with only values from causing errors.
