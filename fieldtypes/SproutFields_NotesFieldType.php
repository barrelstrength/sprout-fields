<?php
namespace Craft;

class SproutFields_NotesFieldType extends BaseFieldType
{
    private $options = array(
        'style' => array(
            'infoPrimaryDocumentation' => 'Primary Information',
            'infoSecondaryDocumentation' => 'Secondary Information',
            'warningDocumentation' => 'Warning',
            'dangerDocumentation' => 'Danger',
            'highlightDocumentation' => 'Highlight'
        ),
        'output' => array(
            'markdown' => 'Markdown',
            'richText' => 'Rich Text',
            'html' => 'HTML'
        )
    );

    /**
     * Blocktype name
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('Notes');
    }

    /**
     * Define database column
     *
     * @return false
     */
    public function defineContentAttribute()
    {
        // block type doesn’t need its own column
        // in the content table, return false
        return false;
    }

    /**
     * Define blocktype settings
     *
     * @return array List of our available styles
     */
    protected function defineSettings()
    {
        return array(
            'instructions' => array(AttributeType::Mixed),
            'style' => array(AttributeType::Mixed, 'default' => 'infoPrimaryDocumentation'),
            'output' => array(AttributeType::Mixed, 'default' => 'markdown')
        );
    }

    /**
     * Display our settings
     *
     * @return string Returns the template which displays our settings
     */
    public function getSettingsHtml()
    {
        $settings = $this->getSettings();      

        return craft()->templates->render('sproutfields/_fieldtypes/notes/settings', array(
            'options' => $this->options,
            'settings' => $settings
        ));
    }

    /**
     * Display our blocktype
     *
     * @param string $name  Our blocktype handle
     * @param string $value Always returns blank, our block
     *                       only styles the Instructions field
     * @return string Return our blocks input template
     */
    public function getInputHtml($name, $value)
    {
        $settings = $this->getSettings();
        $selectedStyle = $settings->style;

        $pluginSettings = craft()->plugins->getPlugin('sproutfields')->getSettings()->getAttributes();

        // @todo - can probably simplify this code once settings are in place
        $selectedStyleCss = "";
        if (isset($pluginSettings[$selectedStyle]))
        {
            $selectedStyleCss = str_replace("{{ name }}", $name, $pluginSettings[$selectedStyle]);
        }

        return craft()->templates->render('sproutfields/_fieldtypes/notes/input', array(
            'name' => $name,
            'settings' => $settings,
            'selectedStyleCss' => $selectedStyleCss
        ));
    }
}
