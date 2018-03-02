# Sprout Fields

Sprout Fields adds several common field types to Craft CMS. Sprout Fields focuses on fields for an international community with a Craft-friendly user experience.  

- Address Field (International)
- Email Field
- Gender (Inclusive)
- Name (International)
- Notes
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

{# Gender #}
{{ entry.genderField }}

{# Name #}
{{ entry.nameField.getFriendlyName() }}
{{ entry.nameField.getFullName() }}
{{ entry.nameField.getFullNameExtended() }}

{{ entry.nameField.prefix }}
{{ entry.nameField.firstName }}
{{ entry.nameField.middleName }}
{{ entry.nameField.lastName }}
{{ entry.nameField.suffix }}

{# Phone #}
{{ entry.phoneField.international }}
{{ entry.phoneField.national }}
{{ entry.phoneField.E164 }}
{{ entry.phoneField.RFC3966 }}

{{ entry.phoneField.country }}
{{ entry.phoneField.phone }}
{{ entry.phoneField.code }}

{# Predefined Field #}
{{ entry.predefinedField }}

{# Regular Expression Field #}
{{ entry.regularExpressionField }}

{# URL Field #}
{{ entry.urlField }}
```

----

## Documentation

See the [Sprout Website](https://sprout.barrelstrengthdesign.com/craft-plugins/fields/docs) for documentation, guides, and additional resources. 

## Support

- [Send a Support Ticket](https://sprout.barrelstrengthdesign.com/craft-plugins/request/support) via the Sprout Website.
- [Create an issue](https://github.com/barrelstrength/craft-sprout-fields/issues) on Github.

<a href="https://sprout.barrelstrengthdesign.com" target="_blank">
  <img src="https://sprout.barrelstrengthdesign.com/content/plugins/sprout-icon.svg" width="72" align="right">
</a>