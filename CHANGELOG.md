# Changelog

## 3.6.1 - 2020-02-12

## Added
- Added the Template Field for selecting Twig Templates with Auto-suggest and Dropdown field style options

### Changed
- Updated `barrelstrength/sprout-base-fields` requirement to v1.3.1
- Updated `barrelstrength/sprout-base` requirement to v5.1.1

## 3.6.0 - 2020-02-05

### Changed
- Updated models to use `defineRules()` method
- Removed `EditableTable.js` file
- Updated `barrelstrength/sprout-base-fields` requirement to v1.3.0
- Updated `barrelstrength/sprout-base` requirement to v5.1.0

## 3.5.4 - 2020-01-15

### Updated
- Updated `barrelstrength/sprout-base-fields` to v1.2.3

### Fixed 
- Fixed array offset error in PHP 7.4 ([#405][405-sproutbasefields]) 

[405-sproutbasefields]: https://github.com/barrelstrength/craft-sprout-forms/issues/405

## 3.5.3 - 2020-01-15

### Updated
- Updated `barrelstrength/sprout-base-fields` to v1.2.2

### Fixed 
- Fixed error in address table migration ([#182][182-sproutseo])

[182-sproutseo]: https://github.com/barrelstrength/craft-sprout-seo/issues/182

## 3.5.2 - 2020-01-15

### Fixed
- Fixed bug where optional Phone field would not validate with blank value

## 3.5.1 - 2020-01-09

### Updated
- Updated `barrelstrength/sprout-base-fields` to v1.2.1

### Fixed
- Fixed scenario where address table updates may not get triggered in migrations
 
## 3.5.0 - 2020-01-09

### Added
- Added support for displaying Address on Revisions using `Field::getStaticHtml()`
- Added `barrelstrength\sproutbasefields\services\Name`
- Added `barrelstrength\sproutbasefields\services\Phone::getCountries()` 
- Added `barrelstrength\sproutbasefields\models\Address::getCountryCode()`
- Added `barrelstrength\sproutbasefields\events\OnSaveAddressEvent::$address`

### Changed
- Updated how Address Fields are saved and retrieved to better handle Drafts, Revisions, and other integrations
- Updated and standardized shared logic, validation, and response for fields Email, Name, Phone, Regular Expression, and Url 
- Improved multi-site support for Addresses
- Updated dynamic email validation to exclude check for unique email setting
- Updated Phone field to save `null` instead of empty JSON blob
- Updated Name field to save `null` instead of empty JSON blob
- Addresses are now stored only in the `sproutfields_adddresses` table. Updated `barrelstrength\sproutfields\fields\Address::hasContentColumn` to return false.
- Updated `barrelstrength\sproutbasefields\services\Address::deleteAddressById()` to require address ID
- Improved fallbacks for Address Field's default country and language
- Moved methods from `barrelstrength\sproutbasefields\helpers\AddressHelper` to `barrelstrength\sproutbasefields\services\Address`
- Moved methods from `barrelstrength\sproutbasefields\helpers\AddressHelper` to `barrelstrength\sproutbasefields\services\AddressFormatter`
- Updated `barrelstrength\sproutbasefields\helpers\AddressHelper` to `barrelstrength\sproutbasefields\services\AddressFormatter`
- Deprecated property `barrelstrength\sproutbasefields\events\OnSaveAddressEvent::$model`
- Renamed `barrelstrength\sproutbasefields\services\Address::getAddress()` => `getAddressFromElement()`
- Renamed data attribute `addressid` => `address-id`
- Renamed data attribute `defaultcountrycode` => `default-country-code`
- Renamed data attribute `showcountrydropdown` => `show-country-dropdown`
- Updated `barrelstrength/sprout-base-fields` to v1.2.0
- Updated `commerceguys/addressing` to v1.0.6
- Updated `giggsey/libphonenumber-for-php` to v8.11.1

### Fixed
- Fixed Phone validation bug on initial Drafts
- Fixed Email Field unique email validation with Drafts
- Fixed display issue with Gibraltar addresses
- Fixed bug where Address input fields did not display in edit modal after Address was cleared

### Removed
- Removed `barrelstrength\sproutfields\fields\Phone::getCountries()`
- Removed `barrelstrength\sproutfields\fields\Address::serializeValue()`
- Removed `barrelstrength\sproutbasefields\helpers\AddressHelper`
- Removed `barrelstrength\sproutbasefields\controllers\actionDeleteAddress()`
- Removed `barrelstrength\sproutbasefields\models\Name;:$fullName`
- Removed `commerceguys/intl`

## 3.4.4 - 2019-08-14

### Changed
- Updated barrelstrength/sprout-base-fields requirement v1.1.0

### Fixed
- Fixed bug where unique email field setting did not exclude soft deleted entries ([#328][#328sproutforms])

[#328sproutforms]: https://github.com/barrelstrength/craft-sprout-forms/issues/328

## 3.4.3 - 2019-07-14

### Changed
- Updated barrelstrength/sprout-base-fields requirement v1.0.9
- Updated barrelstrength/sprout-base-import requirement v1.0.5

## 3.4.2 - 2019-07-09

### Added
- Added support for Craft 3.2 allowAnonymous updates

### Changed
- Updated craftcms/cms requirement to v3.2.0
- Updated barrelstrength/sprout-base-fields requirement to 1.0.8

## 3.4.1 - 2019-06-10

### Changed
- Updated barrelstrength/sprout-base-fields requirement v1.0.7

### Fixed
- Fixed JS error when using Notes Field ([#2][#2basefields])

[#2basefields]: https://github.com/barrelstrength/craft-sprout-base-fields/issues/2

## 3.4.0 - 2019-05-24

### Added 
- Added dynamic rendering for the Predefined Field

### Changed
- Predefined Field Date data type has been moved to a separate Predefined Date Field
- Updated barrelstrength/sprout-base-fields requirement v1.0.6

### Fixed
- Fixed bug in Predefined Date data type migration

## 3.3.1 - 2019-05-21

### Added 
- Added Predefined Field setting to support Text and Date Data Types 

### Changed
- Updated barrelstrength/sprout-base-fields requirement v1.0.5

### Fixed
- Fixed bug where Name field could throw error on Entry edit page
- Improved Postgres support

## 3.3.0 - 2019-04-30

### Changed
- Updated icon

## 3.2.9 - 2019-04-20

### Changed
- Updated barrelstrength/sprout-base-fields requirement v1.0.4
- Updated barrelstrength/sprout-base requirement v5.0.0

### Fixed
- Fixed Phone field bug in migration from Craft 2 to Craft 3 ([#86])

[#86]: https://github.com/barrelstrength/craft-sprout-fields/issues/86

## 3.2.8 - 2019-03-13

> {warning} This is a critical release. Please update to the latest to ensure your Address Field Administrative Area code data is being saved correctly.

### Changed
- Updated barrelstrength/sprout-base-fields requirement v1.0.3

### Fixed
- Fixed bug where Administrative Area Input was not populated correctly ([#85])

[#85]: https://github.com/barrelstrength/craft-sprout-fields/issues/85

## 3.2.6 - 2019-03-06

### Fixed
- Fixed error related to the Project Config when migrating from Craft 2 to Craft 3 ([#84])

[#84]: https://github.com/barrelstrength/craft-sprout-fields/issues/84

## 3.2.5 - 2019-03-01

### Changed
- Updated barrelstrength/sprout-base-fields requirement v1.0.2

### Fixed
- Fixed invalid path alias error when running console commands ([#83])

[#83]: https://github.com/barrelstrength/craft-sprout-fields/issues/83

## 3.2.4 - 2019-02-26

### Changed
- Updated craftcms/cms requirement to v3.1.15
- Added barrelstrength/sprout-base-fields requirement v1.0.1

### Fixed 
- Fixed Address Field settings that blocked field from being saved in Postgres and Project Config ([#77], [#81])
- Fixed a console error occurring due to line break in string literal ([#1][#1sproutbasefields])

[#77]: https://github.com/barrelstrength/craft-sprout-fields/issues/77
[#81]: https://github.com/barrelstrength/craft-sprout-fields/issues/81
[#1sproutbasefields]: https://github.com/barrelstrength/craft-sprout-base-fields/pull/1

## 3.2.3 - 2019-02-14

### Fixed
- Added barrelstrength/sprout-base-import requirement v1.0.0

## 3.2.2 - 2019-02-13

### Added
- Added Craft 3.1 support

### Changed
- Improved translation support
- Updated barrelstrength/sprout-base requirement to v4.0.6
- Added barrelstrength/sprout-base-fields requirement v1.0.0

### Fixed
- Fixed bug where `settings` column was not found when migrating from Craft 3.0 to 3.1 

## 3.2.1 - 2019-01-23

## Changed
- Updates version number to ensure Craft Plugin Store recognizes this release

## 3.2.0 - 2019-01-23

## Added
- Added highlight countries settings to Address Field
- Added some default options to translate the Address Field country dropdown

## Changed
- Improved indication of input fields in Address Field modal [#57]
- Updated Predefined Field to better handle Matrix fields and new Element values
- Refactored Address Field and standardized conventions for use across Fields, Forms, and SEO use cases
- Updated Address Field classes in HTML output
- Updated Address Field model to include countryThreeLetterCode, currencyCode, and locale
- Updated barrelstrength/sprout-base to require v4.0.4

## Fixed
- Fixed Address Field clear button as it did not clear the Address data for new Entries
- Fixed Address Field error on when field was displayed as a column on the Elenent Index page
- Fixed bug where Name field _toString method was not returning a string
- Fixed output exceptions for Turkey, Åland Islands, and Jersey

[#57]: https://github.com/barrelstrength/craft-sprout-fields/issues/57

## 3.1.21 - 2018-11-28

### Added
- Fixed bug where Address Field clear button did not have an effect before field is saved ([#68])

### Changed
- Updated Sprout Base requirement to v4.0.3

[#68]: https://github.com/barrelstrength/craft-sprout-fields/issues/68

## 3.1.20 - 2018-11-14

### Added
- Added option to hide or show Predefined Field in Field Layout
- Added option to display Predefined Field as a textarea field

### Changed
- Updated Predefined Field settings to use textarea
- Updated Sprout Base requirement to v4.0.2
- Updated commerceguys/addressing requirement to v1.0.1

## 3.1.13 - 2018-10-29

### Changed
- Updated Sprout Base requirement to v4.0.0

## 3.1.12 - 2018-10-27

### Changed
- Updates Sprout Import references to Sprout Base

## 3.1.11 - 2018-10-23

### Fixed
- Fixed bug on address field when entries is save as new entry [#65]

## 3.1.9 - 2018-09-12

### Fixed
- Fixed bug where Address Field did not respect the default country setting ([#63])
- Fixed bug where Address Field did not respect the hide country setting ([#63])

[#63]: https://github.com/barrelstrength/craft-sprout-fields/issues/63

## 3.1.8 - 2018-08-30

### Fixed
- Fixed error where Name Field could throw errors when value was null [#62]

[#62]: https://github.com/barrelstrength/craft-sprout-fields/issues/62

## 3.1.7 - 2018-08-01

### Fixed
- Fixed release notes syntax 

## 3.1.6 - 2018-08-01

### Added
- Added country property to Address model ([#56]) 

### Changed
- Updated Sprout Base requirement to v3.0.1

### Fixed
- Added support for migrating Sprout Field classes for non-global fields ([#55])
- Fixed rendering bug in Address modal when switching countries ([#61])

[#55]: https://github.com/barrelstrength/craft-sprout-fields/issues/55
[#56]: https://github.com/barrelstrength/craft-sprout-fields/issues/56
[#61]: https://github.com/barrelstrength/craft-sprout-fields/issues/61

## 3.1.5 - 2018-07-26

## Changed
- Updated Sprout Base requirement to v3.0.0

## 3.1.4 - 2018-07-26

### Changed
- Updated Sprout Base requirement to v2.0.10

### Fixed
- Fixed issue where Address Field prompted user that a form had changed after page load ([#60])

[#60]: https://github.com/barrelstrength/craft-sprout-fields/issues/60

## 3.1.3 - 2018-06-11

### Fixed
- Fixed bug where some characters in the URL Field would not validate ([#48])
- Fixed bug where Address, Name, and Phone field could lose value when set to Not Translatable ([#51])
- Fixed bug where Data Sources migration could fail if being run for the second time ([#54])
 
[#48]: https://github.com/barrelstrength/craft-sprout-fields/issues/48
[#51]: https://github.com/barrelstrength/craft-sprout-fields/issues/51
[#54]: https://github.com/barrelstrength/craft-sprout-fields/issues/54

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
