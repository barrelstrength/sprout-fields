<?php

namespace barrelstrength\sproutfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use barrelstrength\sproutbase\app\fields\web\assets\quill\QuillAsset;

use barrelstrength\sproutfields\SproutFields;
use craft\helpers\FileHelper;

class Notes extends Field
{

    /**
     * @var string
     */
    public $notes;

    /**
     * @var string
     */
    public $style;

    /**
     * @var bool
     */
    public $hideLabel;

    /**
     * @var string
     */
    public $output;

    public static function displayName(): string
    {
        return SproutFields::t('Notes (Sprout)');
    }

    /**
     * @inheritdoc
     */
    public static function hasContentColumn(): bool
    {
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
            'sprout-base-fields/_components/fields/formfields/notes/settings',
            [
                'styles' => $this->_getCustomStyleOptions(),
                'options' => $this->getOptions(),
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
        $selectedStyleCss = '';

        // Swap all instances of FIELDHANDLE with this specific field handle
        if (strpos($selectedStyle, 'FIELDHANDLE') !== false) {
            $selectedStyleCss = str_replace(
                'FIELDHANDLE',
                $name,
                $selectedStyle
            );
        } else {

            // @deprecate - v3.0 in favor of FIELDHANDLE
            if (strpos($selectedStyle, '{{ name }}') !== false) {
                Craft::$app->getDeprecator()->log('{{ name }}', 'Sprout Fields Notes Field dynamic token `{{ name }}` has been deprecated. Use `FIELDHANDLE` instead.');

                $selectedStyleCss = str_replace(
                    '{{ name }}',
                    $name,
                    $selectedStyle
                );
            }
        }

        if ($this->notes === null) {
            $this->notes = '';
        }

        return Craft::$app->getView()->renderTemplate(
            'sprout-base-fields/_components/fields/formfields/notes/input',
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
     * @param string $dir The directory name within the config/ folder to look for the config file
     *
     * @return bool|string
     * @throws \yii\base\Exception
     */
    private function _getConfig(string $dir = 'sproutnotes')
    {
        $file = $this->style;
        // Return our default css
        $path = Craft::getAlias('@sproutbase/app/fields/templates/_special/Default.css');

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
        $options = [];
        $defaultOption = ['' => Craft::t('sprout-fields', 'Default')];
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

        // Append our Default option to an alphabetical list of additional options
        $options = array_merge($defaultOption, array_reverse($options));

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
