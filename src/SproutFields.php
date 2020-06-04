<?php

namespace barrelstrength\sproutfields;

use barrelstrength\sproutbase\config\base\SproutCentralInterface;
use barrelstrength\sproutbase\config\configs\CampaignsConfig;
use barrelstrength\sproutbase\config\configs\EmailConfig;
use barrelstrength\sproutbase\config\configs\FieldsConfig;
use barrelstrength\sproutbase\config\configs\GeneralConfig;
use barrelstrength\sproutbase\config\configs\ReportsConfig;
use barrelstrength\sproutbase\config\configs\SentEmailConfig;
use barrelstrength\sproutbase\SproutBaseHelper;
use barrelstrength\sproutbase\app\fields\Address as AddressField;
use barrelstrength\sproutbase\app\fields\Email as EmailField;
use barrelstrength\sproutbase\app\fields\Gender as GenderField;
use barrelstrength\sproutbase\app\fields\Name as NameField;
use barrelstrength\sproutbase\app\fields\Notes as NotesField;
use barrelstrength\sproutbase\app\fields\Phone as PhoneField;
use barrelstrength\sproutbase\app\fields\Predefined as PredefinedField;
use barrelstrength\sproutbase\app\fields\PredefinedDate as PredefinedDateField;
use barrelstrength\sproutbase\app\fields\RegularExpression as RegularExpressionField;
use barrelstrength\sproutbase\app\fields\Template as TemplateField;
use barrelstrength\sproutbase\app\fields\Url as UrlField;
use craft\base\Element;
use craft\base\Plugin;
use craft\events\ElementEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Elements;
use craft\services\Fields;
use yii\base\Event;

/**
 * @property array $sproutDependencies
 * @property array $settings
 */
class SproutFields extends Plugin implements SproutCentralInterface
{
    /**
     * @var string
     */
    public $schemaVersion = '3.5.3';

    /**
     * @var string
     */
    public $minVersionRequired = '2.1.3';

    public static function getSproutConfigs(): array
    {
        return [
            GeneralConfig::class,
            FieldsConfig::class
        ];
    }

    public function init()
    {
        parent::init();

        SproutBaseHelper::registerModule();

        // Process all of our Predefined Fields after an Element is saved
        Event::on(Elements::class, Elements::EVENT_AFTER_SAVE_ELEMENT, static function(ElementEvent $event) {
            /** @var Element $element */
            $element = $event->element;
            $isNew = $event->isNew;

            $fieldLayout = $element->getFieldLayout();

            if ($fieldLayout) {
                foreach ($fieldLayout->getFields() as $field) {
                    if ($field instanceof PredefinedField || $field instanceof PredefinedDateField) {
                        /** @var PredefinedField $field */
                        $field->processFieldValues($element, $isNew);
                    }
                }
            }
        });

        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES, static function(RegisterComponentTypesEvent $event) {
            $event->types[] = AddressField::class;
            $event->types[] = EmailField::class;
            $event->types[] = GenderField::class;
            $event->types[] = NameField::class;
            $event->types[] = NotesField::class;
            $event->types[] = PhoneField::class;
            $event->types[] = PredefinedField::class;
            $event->types[] = PredefinedDateField::class;
            $event->types[] = RegularExpressionField::class;
            $event->types[] = TemplateField::class;
            $event->types[] = UrlField::class;
        });
    }
}


