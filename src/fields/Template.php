<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutfields\fields;

use barrelstrength\sproutbasefields\SproutBaseFields;
use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\helpers\ArrayHelper;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @property array $elementValidationRules
 * @property mixed $settingsHtml
 */
class Template extends Field implements PreviewableFieldInterface
{
    /**
     * The field type  to display to the user
     *
     * @var string dropdown|autosuggest
     */
    public $inputStyle = 'dropdown';

    /**
     * Indicates if all templates are available or only templates within a folder
     *
     * @var string all|folder
     */
    public $suggestedTemplates = 'all';

    /**
     * The template folder to use if limiting the templates to a specific folder
     *
     * @var string
     */
    public $templateFolder;

    public function init() {
        // Set the templateFolder to null if we don't need it
        if ($this->suggestedTemplates !== 'folder') {
            $this->templateFolder = null;
        }
    }

    /**
     * @return string
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-fields', 'Template (Sprout Fields)');
    }

    /**
     * @return string|null
     */
    public function getSettingsHtml()
    {
        $templateDirectoryOptions = $this->getTemplateDirectories();

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/template/settings',
            [
                'field' => $this,
                'templateDirectoryOptions' => $templateDirectoryOptions
            ]);
    }

    /**
     * @param mixed                             $value
     * @param \craft\base\ElementInterface|null $element
     *
     * @return string
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        $inputId = Craft::$app->getView()->formatInputId($name);
        $namespaceInputId = Craft::$app->getView()->namespaceInputId($inputId);

        $fieldContext = SproutBaseFields::$app->utilities->getFieldContext($this, $element);

        $templateDropdownOptions = [];
        $templateSuggestions = [];

        // Kinda silly but helps make it clear which version of the array we are working with
        if ($this->inputStyle === 'dropdown') {
            $templateDropdownOptions = $this->getTemplateOptions($this->inputStyle, $this->templateFolder);
        }

        if ($this->inputStyle === 'autosuggest') {
            $templateSuggestions = $this->getTemplateOptions($this->inputStyle, $this->templateFolder);
        }

        return Craft::$app->getView()->renderTemplate('sprout-base-fields/_components/fields/formfields/template/input',
            [
                'namespaceInputId' => $namespaceInputId,
                'id' => $inputId,
                'name' => $name,
                'value' => $value,
                'fieldContext' => $fieldContext,
                'element' => $element,
                'templateDropdownOptions' => $templateDropdownOptions,
                'templateSuggestions' => $templateSuggestions,
                'field' => $this
            ]);
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        $rules[] = 'validateTemplate';

        return $rules;
    }

    /**
     * Validates our fields submitted value beyond the checks
     * that were assumed based on the content attribute.
     *
     *
     * @param Element|ElementInterface $element
     *
     * @return void
     */
    public function validateTemplate(ElementInterface $element)
    {
        $value = $element->getFieldValue($this->handle);

        // Confirm submitted value is an existing template within the scope defined in the settings

        // Is in array of possible templates?
        // File exists?

//        if (!$templateExists) {
//            $message = SproutBaseFields::$app->emailField->getErrorMessage($this);
//            $element->addError($this->handle, $message);
//        }
    }

    /**
     * @inheritdoc
     */
    public function getTableAttributeHtml($value, ElementInterface $element): string
    {
        $html = '';

        if ($value) {
            $html = '<code>'.$value.'</code>';
        }

        return $html;
    }

    /**
     * Gets the available template directories as an options array
     *
     * @return array|void
     */
    public function getTemplateDirectories()
    {
        // Get all the template files sorted by path length
        $root = Craft::$app->getPath()->getSiteTemplatesPath();

        if (!is_dir($root)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root));
        /** @var \SplFileInfo[] $files */
        $dirs = [];

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            // Prep directory list
            if ($file->isDir() && $file->getFilename() === '.') {
                if ($file->getPath() === $root) {
                    continue;
                }

                $dirs[] = $file->getPath();
            }
        }

        asort($dirs);

        $templateDirectoryOptions = [];
        foreach ($dirs as $path) {
            $templatePath = str_replace($root.'/', '', $path);
            $templateDirectoryOptions[] = [
                'label' => $templatePath,
                'value' => $templatePath
            ];
        }

        return $templateDirectoryOptions;
    }

    /**
     * Returns Dropdown field options or Auto-suggest field suggestions for templates
     *
     * @param null $templatePath
     *
     * @return array
     */
    public function getTemplateOptions($inputStyle, $templatePath = null): array
    {
        // Get all the template files sorted by path length
        $root = Craft::$app->getPath()->getSiteTemplatesPath();

        if ($templatePath) {
            $root .= '/'.$templatePath;
        }

        if (!is_dir($root)) {
            return [];
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root));
        /** @var \SplFileInfo[] $files */
        $files = [];
        $pathLengths = [];

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            // Prep Template List
            if (!$file->isDir() && $file->getFilename()[0] !== '.') {
                $files[] = $file;
                $pathLengths[] = strlen($file->getRealPath());
            }
        }

        if ($inputStyle === 'dropdown') {
            uasort($files, static function($a, $b) {
                /**
                 * @var \SplFileInfo $a
                 * @var \SplFileInfo $b
                 */
                return $a->getPath() <=> $b->getPath();
            });
        } else {
            array_multisort($pathLengths, SORT_NUMERIC, $files);
        }

        // Now build the suggestions array
        $suggestions = [];
        $templates = [];
        $sites = [];
        $config = Craft::$app->getConfig()->getGeneral();
        $rootLength = strlen($root);

        foreach (Craft::$app->getSites()->getAllSites() as $site) {
            $sites[$site->handle] = Craft::t('site', $site->name);
        }

        foreach ($files as $file) {
            $template = substr($file->getRealPath(), $rootLength + 1);

            // Can we chop off the extension?
            $extension = $file->getExtension();
            if (in_array($extension, $config->defaultTemplateExtensions, true)) {
                $template = substr($template, 0, strlen($template) - (strlen($extension) + 1));
            }

            $hint = null;

            // Is it in a site template directory?
            foreach ($sites as $handle => $name) {
                if (strpos($template, $handle.DIRECTORY_SEPARATOR) === 0) {
                    $hint = $name;
                    $template = substr($template, strlen($handle) + 1);
                    break;
                }
            }

            // Avoid listing the same template path twice (considering localized templates)
            if (isset($templates[$template])) {
                continue;
            }

            // Add the template folder back to the files within the folder
            if ($templatePath) {
                $template = $templatePath.'/'.$template;
            }

            $templates[$template] = true;
            $suggestions[] = [
                'name' => $template,
                'hint' => $hint,
            ];

            $dropdownOptions[] = [
                'label' => $template,
                'value' => $template
            ];
        }

        ArrayHelper::multisort($suggestions, 'name');

        if ($inputStyle == 'autosuggest') {
            return [
                [
                    'label' => Craft::t('app', 'Templates'),
                    'data' => $suggestions,
                ]
            ];
        }

        return $dropdownOptions;
    }
}
