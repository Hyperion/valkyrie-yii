<?php

class WowDropLoot
{
    public static function drop($table, $item)
    {
        $rows = Yii::app()->db_world->createCommand(
                "SELECT ChanceOrQuestChance, mincountOrRef, maxcount, entry
                FROM {$table}
                WHERE item = {$item}")
            ->queryAll();
        $drop = array();
        foreach ($rows as $i => $row)
        {
            if ($row['mincountOrRef'] > 0)
            {
                $num = $row['entry'];
                $drop[$num] = array();
                $drop[$num]['percent'] = abs($row['ChanceOrQuestChance']);
                $drop[$num]['mincount'] = $row['mincountOrRef'];
                $drop[$num]['maxcount'] = $row['maxcount'];
                
                // We are looking for loot, which refers to this loot
                $refrows = Yii::app()->db_world->createCommand(
                        "SELECT entry FROM {$table} WHERE mincountOrRef = -{$num}")
                    ->queryAll();
                foreach ($refrows as $i => $refrow)
                {
                    $num = $refrow['entry'];
                    $drop[$num] = array();
                    $drop[$num]['percent'] = abs($row['ChanceOrQuestChance']);
                    $drop[$num]['mincount'] = $row['mincountOrRef'];
                    $drop[$num]['maxcount'] = $row['maxcount'];
                }
            }
        }
        return $drop;
    }
}