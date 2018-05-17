# Changelog

## 3.1.2 - 2018-05-15

### Fixed
- Fixes release notes warning syntax

## 3.1.1 - 2018-05-15

> {warning} If you have more than one Sprout Plugin installed, to avoid errors use the 'Update All' option.

### Added
- Added minVersionRequired: Sprout Fields v2.1.3 

### Changed
- Updated application folder structure
- Moved all templates to Sprout Base
- Moved all asset bundles to Sprout Base
- Moved schema and component definitions to Plugin class
- Updated Sprout Base requirement to v2.0.0 
- Updated Craft requirement to v3.0.0

## 3.0.8 - 2018-04-20

## Fixed
- Fixed issue where Notes field caused a javascript error

## 3.0.7 - 2018-04-18

## Fixed
- Fixed issue where Phone field could return an error when empty
- Fixed Address Field display issues
- Fixed potential icon display issue

## 3.0.6 - 2018-04-03

## Fixed
- Fixed Sprout Import Field Importer registration

## 3.0.5 - 2018-04-03

## Changed
- Updated Sprout Import service layer references from: `mockData` => `fieldImporter`
- Moves name field CP settings to Sprout Base
- Fixed potential conflicts with svg icon styles

## Fixed 
- Added migration for creating `sproutfields_addresses` table when migrating from Craft 2 to Craft 3

## 3.0.3 - 2018-03-08

### Fixed
- Fixes bug where Phone Field could throw error when empty ([#38](https://github.com/barrelstrength/craft-sprout-fields/issues/38))
- Fixes bug where Name Field referenced deprecated method 

## 3.0.2 - 2018-03-01

### Changed
- Updated Sprout Base requirement

### Fixed
- Fixed Name field validation bug

## 3.0.1 - 2018-03-01

### Added
- Added Craft License

## 3.0.0 - 2018-03-01

### Added
- Added Address Field (International)
- Added Gender Field (Inclusive)
- Added Name Field (International)
- Added Phone Field (International)
- Added Predefined Field

### Changed
- Renamed Link Field to URL Field
- Updated Notes Field style settings to be managed by config css files

### Removed
- Removed Email Select Field in Craft CP (data will be migrated to Plain Text Field)
- Removed Hidden Field in Craft CP (data will be migrated to Plain Text Field)
- Removed Invisible Field in Craft CP (data will be migrated to Plain Text Field)
- Removed Phone Field and mask in favor of international Phone Field  (data will be migrated to Plain Text Field)

## 2.1.3 - 2017-08-29

### Changed
- Updated default pattern for Phone field to work with Android and iPhone devices

## 2.1.2 - 2017-08-25

### Changed
- Updated legacy Redactor syntax for lists

### Fixed
- Fixed bug in Notes field where the &#039;Default&#039; style option would throw an error in Sprout Forms front-end field output
- Fixed bug in Notes field where &#039;Hide Field Label&#039; option had no effect on Sprout Forms front-end field output
- Fixed incorrect placeholder text in Invisible field settings
- Fixed bug in Phone field where submitting an empty field would not save if Pattern Mask was enabled

## 2.1.1 - 2017-01-11

### Added
- Added Regular Expression Field type
- Added Notes Field Default style option
- Added Notes Field option to hide the field label
- Added Email Select Field support for comma-separated email addresses

### Fixed
- Fixed a bug where Phone Field did not accept empty values
- Fixed an issue where Phone Field could throw an HTML5 pattern attribute syntax error for some phone patterns

## 2.1.0 - 2016-09-26

### Added
- Added support to add Email, Email Select, Hidden, Invisible, Link, and Phone fields as columns in Element Index column configurator
- Added Sprout Import integrations for Email, Email Select, Hidden, Invisible, Link, and Phone fields
- Added craft.sproutFields.obfuscateEmailAddresses variable

### Changed
- Updated Email, Link, and Phone field actions to use icons
- Added support for &#039;default&#039; setting in Email Select template
- Added support for &#039;selected&#039; setting in Email Select output
- Removed the use of wildcards when using Craft::import()

### Fixed
- Fixed issue where Phone field mask did not display
- Fixed incorrect log method name

## 2.0.5 - 2016-05-18

### Fixed
- Fixed issue where the placeholder setting did not display when using the Email and Link fields.
- Fixed bug where Email Select field did not obfuscate email addresses in front-end output.

## 2.0.4 - 2016-04-20

### Added
- Added placeholder setting to Email, Link and Phone fields
- Added Sprout Import integration for importing fake data into email fields

### Fixed
- Fixed error when Email Select field is used with Sprout Forms getField tag

## 2.0.3 - 2016-03-30

### Added
- Added PHP 7 compatibility

### Fixed
- Fixed a bug where Notes field did not minimize when used within a Matrix field

## 2.0.2 - 2016-02-04

### Added
- Added migration to update legacy Sprout More Info fields to Notes fields

### Changed
- Notes no longer requires a database column in the content table

### Fixed
- Fixed error when Link field type was included on Recent Entries dashboard widget

## 2.0.1 - 2015-12-31

### Fixed
- Fixed issue where error message could be blank when the Email Field failed validation
- Fixed issue where error message could be blank when the Link Field failed validation

## 2.0.0 - 2015-12-02

### Added
- Added Plugin icon
- Added Plugin description
- Added link to documentation
- Added link to plugin settings
- Added link to release feed
- Added Email Select field (Initial Release)
- Added Email Select field support for Sprout Forms and Sprout Email
- Added Notes field (previously Sprout More Info)
- Added Notes field support for Sprout Forms
- Added support to expand/collapse Notes fields in the Control Panel and retain state

### Changed
- Improved default styles for Notes field to accomodate more common elements
- Improved several naming conventions
- Improved behavior when updating Notes output setting to immediately display related options
- Improved phone validation to occur on `input` instead of on `blur`

### Fixed
- Fixed a bug where Phone field settings could load without making all selected settings visible
- Fixed a bug where Email, Link, and Phone field custom validation settings could remain even after they were toggled off
- Fixed Phone field link to display if valid on page load
- Fixed a bug where Unique Email validation didn&#039;t take into account new Elements

## 1.0.0 - 2015-10-20

### Added
- Added Phone Field (Initial Release)
- Added Hidden Field (Initial Release)
- Added Invisible Field (Initial Release)
- Added Email Field (previously Sprout Email Field)
- Added Link Field (previously Sprout Link Field)
- Added support for validation using HTML5 patterns and custom error messages
- Added Sprout Forms front-end field support for Phone, Email, Link, Hidden, and Invisible fields.

### Changed
- Standardized settings and naming conventions across all field types
- Updated Phone, Link, and Email field to support input types tel, url, and email
