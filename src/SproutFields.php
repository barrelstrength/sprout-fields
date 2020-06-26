<?php

namespace barrelstrength\sproutfields;

use barrelstrength\sproutbase\app\fields\fields\Address as AddressField;
use barrelstrength\sproutbase\app\fields\fields\Email as EmailField;
use barrelstrength\sproutbase\app\fields\fields\Gender as GenderField;
use barrelstrength\sproutbase\app\fields\fields\Name as NameField;
use barrelstrength\sproutbase\app\fields\fields\Notes as NotesField;
use barrelstrength\sproutbase\app\fields\fields\Phone as PhoneField;
use barrelstrength\sproutbase\app\fields\fields\Predefined as PredefinedField;
use barrelstrength\sproutbase\app\fields\fields\PredefinedDate as PredefinedDateField;
use barrelstrength\sproutbase\app\fields\fields\RegularExpression as RegularExpressionField;
use barrelstrength\sproutbase\app\fields\fields\Template as TemplateField;
use barrelstrength\sproutbase\app\fields\fields\Url as UrlField;
use barrelstrength\sproutbase\config\base\SproutBasePlugin;
use barrelstrength\sproutbase\config\configs\FieldsConfig;
use barrelstrength\sproutbase\config\configs\ControlPanelConfig;
use barrelstrength\sproutbase\SproutBaseHelper;
use craft\base\Element;
use craft\events\ElementEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Elements;
use craft\services\Fields;
use Throwable;
use yii\base\Event;

class SproutFields extends SproutBasePlugin
{
    /**
     * @var string
     */
    public $schemaVersion = '3.5.3';

    /**
     * @var string
     */
    public $minVersionRequired = '3.8.3';

    public static function getSproutConfigs(): array
    {
        return [
            FieldsConfig::class
        ];
    }

    public function init()
    {
        parent::init();

        SproutBaseHelper::registerModule();

        Event::on(Elements::class, Elements::EVENT_AFTER_SAVE_ELEMENT, static function(ElementEvent $event) {
            $this->handlePredefinedFields($event);
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

    /**
     * @param ElementEvent $event
     *
     * @throws Throwable
     */
    private function handlePredefinedFields(ElementEvent $event)
    {
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
    }
}


