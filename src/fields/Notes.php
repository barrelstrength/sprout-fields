<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use barrelstrength\sproutbase\web\assets\sproutfields\notes\QuillAsset;

use barrelstrength\sproutfields\SproutFields;
use craft\helpers\FileHelper;

class Notes extends Field
{

    /**
     * @var text
     */
    public $notes;

    /**
     * @var text
     */
    public $style;

    /**
     * @var bool
     */
    public $hideLabel;

    /**
     * @var text
     */
    public $output;

    public static function displayName(): string
    {
        return SproutFields::t('Notes (Sprout)');
    }

    /**
     * Define database column
     *
     * @return false
     */
    public function defineContentAttribute()
    {
        // field type doesn’t need its own column
        // in the content table, return false
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle(QuillAsset::class);

        return Craft::$app->getView()->renderTemplate(
            'sprout-fields/_fieldtypes/notes/settings',
            [
                'styles' => $this->_getCustomStyleOptions(),
                'options' =>  $this->getOptions(),
                'field' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);
        $selectedStyle = $this->_getConfig();

        $selectedStyleCss = str_replace(
            "{{ name }}",
            $name,
            $selectedStyle
        );

        if (is_null($this->notes)){
            $this->notes = '';
        }

        return Craft::$app->getView()->renderTemplate(
            'sprout-base/sproutfields/_includes/forms/notes/input',
            [
                'id' => $namespaceInputId,
                'name' => $name,
                'field' => $this,
                'selectedStyleCss' => $selectedStyleCss
            ]
        );
    }

    /**
     * Returns a css style
     *
     * @param string      $dir  The directory name within the config/ folder to look for the config file
     *
     * @return string
     * @throws \yii\base\Exception
     */
    private function _getConfig(string $dir= 'sproutnotes')
    {
        $file = $this->style;
        // Return our default css
        $path = Craft::getAlias('@barrelstrength/sproutfields/templates/_special/Default.css');

        $customPath = Craft::$app->getPath()->getConfigPath().DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$file;

        if (is_file($customPath)) {
            $path = $customPath;
        }

        return file_get_contents($path);
    }

    /**
     * Returns the available Notes css
     *
     * @param string $dir The directory name within the config/ folder to look for config files
     *
     * @return array
     * @throws \yii\base\Exception
     */
    private function _getCustomStyleOptions(string $dir = 'sproutnotes'): array
    {
        $options = ['' => Craft::t('sprout-fields', 'Default')];
        $path = Craft::$app->getPath()->getConfigPath().DIRECTORY_SEPARATOR.$dir;

        if (is_dir($path)) {
            $files = FileHelper::findFiles($path, [
                'only' => ['*.css'],
                'recursive' => false
            ]);

            foreach ($files as $file) {
                $options[pathinfo($file, PATHINFO_BASENAME)] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return $options;
    }

    private function getOptions()
    {
        $options = [
            'output' => [
                'richText' => 'Rich Text',
                'markdown' => 'Markdown',
                'html' => 'HTML'
            ]
        ];

        return $options;
    }
}
