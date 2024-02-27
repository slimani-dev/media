# Changelog

## V 0.0.5

### Added
- Added `addMediaFiles` function to the class.
    - Allows adding media files to a specified collection.
    - Deletes existing media files in the collection if `keep` parameter is set to `false`.
    - Generates a unique code based on current time to prepend to the file name.


### Fixed
- Fixed a bug in `registerMediaCollections` function.
    - Added condition to prevent arrays with only values from causing errors.
