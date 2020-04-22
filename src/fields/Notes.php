<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbasefields\web\assets\quill\QuillAsset;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\errors\DeprecationException;
use craft\helpers\FileHelper;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 *
 * @property array $options
 * @property mixed $settingsHtml
 */
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
        return Craft::t('sprout-fields', 'Notes (Sprout Fields)');
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
     *
     * @throws Exception
     * @throws InvalidConfigException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getSettingsHtml()
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle(QuillAsset::class);

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/notes/settings',
            [
                'field' => $this,
                'options' => $this->getOptions(),
                'styles' => $this->_getCustomStyleOptions()
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @param                       $value
     * @param ElementInterface|null $element
     *
     * @return string
     * @throws Exception
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws DeprecationException
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
        } else if (strpos($selectedStyle, '{{ name }}') !== false) {
            Craft::$app->getDeprecator()->log('{{ name }}', 'Sprout Fields Notes Field dynamic token `{{ name }}` has been deprecated. Use `FIELDHANDLE` instead.');

            $selectedStyleCss = str_replace(
                '{{ name }}',
                $name,
                $selectedStyle
            );
        }

        if ($this->notes === null) {
            $this->notes = '';
        }

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/notes/input',
            [
                'field' => $this,
                'id' => $namespaceInputId,
                'name' => $name,
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
     * @throws Exception
     */
    private function _getConfig(string $dir = 'sproutnotes')
    {
        $file = $this->style;
        // Return our default css
        $path = Craft::getAlias('@sproutbasefields/templates/_special/Default.css');

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
     * @throws Exception
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

    private function getOptions(): array
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
