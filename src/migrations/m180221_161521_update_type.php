<?php /** @noinspection ClassConstantCanBeUsedInspection */

namespace barrelstrength\sproutfields\migrations;

use craft\db\Migration;
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
        // SproutFields_Link changed to Url on Craft3
        $fields = [
            'SproutFields_Email'       => 'barrelstrength\sproutfields\fields\Email',
            'SproutFields_EmailSelect' => 'barrelstrength\sproutfields\fields\EmailSelect',
            'SproutFields_Hidden'      => 'barrelstrength\sproutfields\fields\Hidden',
            'SproutFields_Invisible'   => 'barrelstrength\sproutfields\fields\Invisible',
            'SproutFields_Link'        => 'barrelstrength\sproutfields\fields\Url',
            'SproutFields_Notes'       => 'barrelstrength\sproutfields\fields\Notes',
            'SproutFields_Phone'       => 'barrelstrength\sproutfields\fields\Phone',
            'SproutFields_RegularExpression' => 'barrelstrength\sproutfields\fields\RegularExpression',
        ];

        foreach ($fields as $oldField => $newField) {
            $ids = $this->getIdsByType($oldField);

            if (!empty($ids)) {
                $this->update('{{%fields}}', [
                    'type' => $newField
                ], [
                    'id' => $ids
                ], [], false);
            }
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
