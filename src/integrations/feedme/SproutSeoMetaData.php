<?php

namespace barrelstrength\sproutfields\integrations\feedme;

use barrelstrength\sproutbasefields\SproutBaseFields;
use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use barrelstrength\sproutbasefields\models\Address as AddressModel;

class SproutSeoMetaData extends Field implements FieldInterface
{
    // Properties
    // =========================================================================

    public static $name = 'ElementMetadata';
    public static $class = 'barrelstrength\sproutseo\fields\ElementMetadata';


    // Templates
    // =========================================================================

    public function getMappingTemplate()
    {
        return 'sprout-fields/feedme/metadata';
    }


    // Public Methods
    // =========================================================================
    /**
     * @return array
     */
    public function parseField()
    {
        $feedData = $this->feedData;

        $metaData = [
            'enableMetaDetailsSearch',
            'enableMetaDetailsOpenGraph',
            'enableMetaDetailsTwitterCard',
            'enableMetaDetailsGeo',
            'enableMetaDetailsRobots',
            'canonical',
            'title',
            'description',
            'keywords',
            'ogType',
            'ogTitle',
            'ogDescription',
            'ogImage',
            'twitterCard',
            'twitterTitle',
            'twitterDescription',
            'twitterImage',
            'twitterCreator',
            'region',
            'placename',
            'latitude',
            'longitude'
        ];

        $robots = ['noindex', 'nofollow', 'noarchive', 'noimageindex', 'noodp', 'noydir'];

        $parsedData = [];
        foreach ($metaData as $meta) {

            $key = 'seoMetaData/metaData/' . $meta;

            if (isset($feedData[$key])) {
                $parsedData[$meta] = $feedData[$key];
            }
        }

        foreach ($robots as $robot) {

            $key = 'seoMetaData/metaData/robots/' . $robot;

            if (isset($feedData[$key])) {
                $parsedData['robots'][$robot] = $feedData[$key];
            }
        }

        $elementMetaData = [];
        $elementMetaData['metaData'] = $parsedData;
        //\Craft::dump($elementMetaData);
        return $elementMetaData;
    }
}
