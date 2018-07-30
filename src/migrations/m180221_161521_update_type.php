<?php

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
use barrelstrength\sproutfields\fields\Notes;
use craft\db\Query;

/**
 * m180221_161522_notes_fields migration.
 */
class m180221_161521_update_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $emailIds = $this->getIdsByType('SproutFields_Email');

        if (!empty($emailIds)) {
            $this->update('{{%fields}}', [
                'type' => 'barrelstrength\sproutfields\fields\Email'
            ], [
                'id' => $emailIds
            ], [], false);
        }

        return true;
    }

    /**
     * Get the ids with context not from the sprout form fields
     * @param $type
     *
     * @return array
     */
    private function getIdsByType($type)
    {
        return (new Query())
            ->select(['id'])
            ->from(['{{%fields}}'])
            ->where(['type' => $type])
            ->andWhere(['NOT REGEXP', 'context', 'sproutForms:.*'])
            ->column();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180221_161521_update_type cannot be reverted.\n";
        return false;
    }
}
