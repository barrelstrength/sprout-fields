<?php

namespace barrelstrength\sproutfields\integrations\feedme\elements;

use Cake\Utility\Hash;
use Craft;
use craft\elements\Entry as EntryElement;
use craft\elements\User as UserElement;
use craft\feedme\base\Element;
use craft\feedme\base\ElementInterface;
use craft\feedme\Plugin;
use craft\models\Section;

use craft\base\Element as BaseElement;
use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;
use craft\helpers\Db;

class Redirect extends Element implements ElementInterface
{
    // Properties
    // =========================================================================

    public static $name = 'Redirect';
    public static $class = 'barrelstrength\sproutbaseredirects\elements\Redirect';

    public $element;


    // Templates
    // =========================================================================

    public function getGroupsTemplate()
    {
        return 'sprout-fields/feedme/elements/redirects/groups';
    }

    public function getColumnTemplate()
    {
        return 'sprout-fields/feedme/elements/redirects/column';
    }

    public function getMappingTemplate()
    {
        //return 'feed-me/_includes/elements/entry/map';
        return 'sprout-fields/feedme/elements/redirects/map';
    }


    // Public Methods
    // =========================================================================

    public function getGroups()
    {
        return [];
    }

    public function getQuery($settings, $params = [])
    {
        $query = \barrelstrength\sproutbaseredirects\elements\Redirect::find();

        $criteria = $params;

        $siteId = Hash::get($settings, 'siteId');

        if ($siteId) {
            $criteria['siteId'] = $siteId;
        }

        Craft::configure($query, $criteria);

        return $query;
    }

    public function setModel($settings)
    {
        $this->element = new EntryElement();

        return $this->element;
    }
}

