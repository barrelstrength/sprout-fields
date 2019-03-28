<?php

namespace barrelstrength\sproutfields\migrations;

use barrelstrength\sproutfields\fields\Phone;
use craft\db\Migration;
use craft\db\Query;

/**
 * m190328_000000_fix_craft2_phone_values migration.
 */
class m190328_000000_fix_craft2_phone_values extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $phoneFields = (new Query())
            ->select(['handle'])
            ->from(['{{%fields}}'])
            ->where(['type' => Phone::class, 'context' => 'global'])
            ->all();

        foreach ($phoneFields as $phoneField) {
            $columnName = 'field_'.$phoneField['handle'];
            $rows = (new Query())
                ->select(['id', $columnName])
                ->from(['{{%content}}'])
                ->andWhere(['is not', $columnName, null])
                ->all();

            foreach ($rows as $row) {
                $number = json_decode($row[$columnName], true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $phoneValue = [
                        'country' => 'US',
                        'phone' => $row[$columnName]
                    ];

                    $phoneValueAsJson = json_encode($phoneValue);
                    $testJson = json_decode($phoneValueAsJson, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        $this->update('{{%content}}', [$columnName => $phoneValueAsJson], ['id' => $row['id']], [], false);
                    }
                }
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m190328_000000_fix_craft2_phone_values cannot be reverted.\n";
        return false;
    }
}
