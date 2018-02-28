Sprout Fields
===================

Sprout Fields adds several common field types to Craft CMS. Sprout Fields focuses on fields for an international community with a Craft-friendly user experience.  

- Address Field (International)
- Email Field
- Gender (Inclusive)
- Phone Field (International)
- Predefined
- Regular Expression (Exclusive)
- URL Field

----

## Front-end Usage

``` twig
{# Address #}
{{ entry.addressField.countryCode }}
{{ entry.addressField.administrativeArea }}
{{ entry.addressField.locality }}
{{ entry.addressField.postalCode }}
{{ entry.addressField.address1 }}
{{ entry.addressField.address2 }}

{# Email Field #}
{{ entry.emailField }}

{# Email Dropdown Field #}
{{ entry.emailDropdownField }}

{# Gender #}
{{ entry.genderField }}

{# Phone #}
{{ entry.phoneFieldAll.international }}
{{ entry.phoneFieldAll.national }}
{{ entry.phoneFieldAll.E164 }}
{{ entry.phoneFieldAll.RFC3966 }}

{{ entry.phoneFieldAll.country }}
{{ entry.phoneFieldAll.phone }}
{{ entry.phoneFieldAll.code }}

{# Predefined Field #}
{{ entry.predefinedField }}

{# Regular Expression Field #}
{{ entry.regularExpressionField }}

{# URL Field #}
{{ entry.urlField }}
```

----

## Control Panel Usage

Once installed, a user can add any number of _Sprout Fields_ to their Field Layouts.

1. Go to _Settings → Fields_
2. Select _New Field_
3. Choose the Sprout Field of your choosing from the Field Type dropdown
4. Delight!

----

## Getting Started 

### Requirements

This plugin requires Craft CMS 3.0.0-RC1 or later.

### Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require barrelstrength/sprout-fields

3. In the Control Panel, go to _Settings → Plugins_ and click the “Install” button for Sprout Fields.