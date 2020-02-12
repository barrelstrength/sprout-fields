<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields;

use barrelstrength\sproutbase\SproutBaseHelper;
use barrelstrength\sproutbasefields\SproutBaseFieldsHelper;
use barrelstrength\sproutbaseimport\services\Importers;
use barrelstrength\sproutfields\fields\Address as AddressField;
use barrelstrength\sproutfields\fields\Email as EmailField;
use barrelstrength\sproutfields\fields\Gender as GenderField;
use barrelstrength\sproutfields\fields\Name as NameField;
use barrelstrength\sproutfields\fields\Notes as NotesField;
use barrelstrength\sproutfields\fields\Phone as PhoneField;
use barrelstrength\sproutfields\fields\Predefined as PredefinedField;
use barrelstrength\sproutfields\fields\PredefinedDate as PredefinedDateField;
use barrelstrength\sproutfields\fields\RegularExpression as RegularExpressionField;
use barrelstrength\sproutfields\fields\Template as TemplateField;
use barrelstrength\sproutfields\fields\Url as UrlField;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Email as EmailFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Gender as GenderFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Notes as NotesFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Phone as PhoneFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Predefined as PredefinedFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\RegularExpression as RegularExpressionFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Url as UrlFieldImporter;
use Craft;
use craft\base\Element;
use craft\base\Plugin;
use craft\events\ElementEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Elements;
use craft\services\Fields;
use yii\base\Event;

/**
 *
 * @property array $settings
 */
class SproutFields extends Plugin
{
    /**
     * @var string
     */
    public $schemaVersion = '3.5.3';

    /**
     * @var string
     */
    public $minVersionRequired = '2.1.3';

    /**
     * @inheritdoc
     * This empty method is required to avoid an error related to the Project Config when migrating from Craft 2 to Craft 3
     */
    public function setSettings(array $settings)
    {
    }

    /**
     * @inheritdoc
     */
    public function getSettings()
    {
        return null;
    }

    public function init()
    {
        parent::init();

        SproutBaseHelper::registerModule();
        SproutBaseFieldsHelper::registerModule();

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

        Event::on(Importers::class, Importers::EVENT_REGISTER_IMPORTER_TYPES, static function(RegisterComponentTypesEvent $event) {

            $plugin = Craft::$app->getPlugins()->getPlugin('sprout-import');

            if ($plugin) {
//            $event->types[] = AddressFieldImporter::class;
                $event->types[] = EmailFieldImporter::class;
                $event->types[] = GenderFieldImporter::class;
                $event->types[] = UrlFieldImporter::class;
                $event->types[] = NotesFieldImporter::class;
                $event->types[] = PhoneFieldImporter::class;
                $event->types[] = PredefinedFieldImporter::class;
                $event->types[] = RegularExpressionFieldImporter::class;
            }
        });
    }
}


