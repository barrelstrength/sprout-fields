<?php

namespace barrelstrength\sproutfields;

use barrelstrength\sproutbase\app\import\services\Importers;
use barrelstrength\sproutbase\SproutBaseHelper;
use barrelstrength\sproutfields\fields\Address as AddressField;
use barrelstrength\sproutfields\fields\Name as NameField;
use barrelstrength\sproutfields\fields\Phone as PhoneField;
use barrelstrength\sproutfields\fields\Email as EmailField;
use barrelstrength\sproutfields\fields\Gender as GenderField;
use barrelstrength\sproutfields\fields\Url as UrlField;
use barrelstrength\sproutfields\fields\Notes as NotesField;
use barrelstrength\sproutfields\fields\Predefined as PredefinedField;
use barrelstrength\sproutfields\fields\RegularExpression as RegularExpressionField;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Email as EmailFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Gender as GenderFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Url as UrlFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Notes as NotesFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Phone as PhoneFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\Predefined as PredefinedFieldImporter;
use barrelstrength\sproutfields\integrations\sproutimport\importers\fields\RegularExpression as RegularExpressionFieldImporter;
use Craft;
use craft\base\Plugin;
use yii\base\Event;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;

class SproutFields extends Plugin
{
    /**
     * @var string
     */
    public $schemaVersion = '3.1.0';

    /**
     * @var string
     */
    public $minVersionRequired = '2.1.3';

    public function init()
    {
        parent::init();

        SproutBaseHelper::registerModule();

        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES, function(RegisterComponentTypesEvent $event) {
            $event->types[] = AddressField::class;
            $event->types[] = EmailField::class;
            $event->types[] = GenderField::class;
            $event->types[] = NameField::class;
            $event->types[] = NotesField::class;
            $event->types[] = PhoneField::class;
            $event->types[] = PredefinedField::class;
            $event->types[] = RegularExpressionField::class;
            $event->types[] = UrlField::class;
        });

        Event::on(Importers::class, Importers::EVENT_REGISTER_IMPORTER_TYPES, function(RegisterComponentTypesEvent $event) {

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

    /**
     * @inheritdoc
     */
    public function setSettings(array $settings)
    {
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return string
     */
    public static function t($message, array $params = [])
    {
        return Craft::t('sprout-fields', $message, $params);
    }
}


