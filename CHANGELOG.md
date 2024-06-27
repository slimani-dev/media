# Changelog

## Version 0.0.13

### Fixes

- add 'type','mime_type'

## Version 0.0.12

### Fixes

- fixed some code style problems
- fixed some logic problems

## Version 0.0.9

### Changed

- In `MediaCast.php`:
    - Adjusted the `get` method signature to remove unnecessary spacing in the PHPDoc block.
    - Added a condition to return the value if it's an instance of `Media`.
- In `MediaCollectionCast.php`:
    - Added a condition to return the value if it's not an array, empty, or if its elements are instances of `Media`.

## V 0.0.8

### Changed

- Modified `MediaCast` class:
    - Updated `get` method to return a nullable `Media` instance.
    - Updated `set` method to return a nullable `Media` instance.
- Modified `UseMediaModel` trait:
    - Added logic to refresh the model after every media file is added, ensuring accurate state representation.

## V 0.0.7

### Changed

- Modified `MediaCast` class:
    - Updated `set` method to clear media collection before adding new files.
    - Added a check to ensure `UploadedFile` is passed as value parameter.
- Modified `MediaCollectionCast` class:
    - Updated `set` method to clear media collection before adding new files.
    - Added a check to ensure `UploadedFile[]` is passed as value parameter.
- Modified `Media` model:
    - Renamed `getCastObject` method to `toArray`.
    - Updated `toArray` method to include only specific attributes.
    - Added `url` and `mime` attributes to the `$appends` property.
    - Defined `url` and `mime` attributes using `Attribute` class.
- Modified `UseMediaModel` trait:
    - Updated `addMediaFiles` method signature to remove the `$keep` parameter.
    - Removed `$keep` parameter usage from `addMediaFiles` method implementation.
    - Updated the PHPDoc to reflect changes in method signature.

## V 0.0.6

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
