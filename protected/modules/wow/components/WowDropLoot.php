<?php

class WowDropLoot
{
    static $loot_groups;

    public static function drop($table, $item)
    {
        $total = 0;
    
        // Реверсный поиск лута начиная с референсной таблицы
        // Ищем в группах
        $drop = array();
        $curtable = 'reference_loot_template';
        $rows = Yii::app()->db_world->createCommand("
                SELECT entry, groupid, ChanceOrQuestChance, mincountOrRef, maxcount
                FROM {$curtable}
                WHERE
                    item = {$item}
                    AND mincountOrRef > 0")
            ->queryAll();
    
        while(true)
        {
            foreach($rows as $i => $row)
            {
                $chance = abs($row['ChanceOrQuestChance']);
                if($chance == 0)
                {
                    // Запись из группы с равным шансом дропа, считаем реальную вероятность
                    $zerocount = 0;
                    $chancesum = 0;
                    $subrows = Yii::app()->db_world->createCommand("
                            SELECT ChanceOrQuestChance
                            FROM {$curtable}
                            WHERE entry = {$row['entry']} AND groupid = {$row['groupid']}")
                        ->queryAll();
                    foreach($subrows as $i => $subrow)
                    {
                        if($subrow['ChanceOrQuestChance'] == 0)
                            $zerocount++;
                        else
                            $chancesum += abs($subrow['ChanceOrQuestChance']);
                    }
                    $chance = (100 - $chancesum) / $zerocount;
                }
                $chance = max($chance, 0);
                $chance = min($chance, 100);
                $mincount = $row['mincountOrRef'];
                $maxcount = $row['maxcount'];
    
                if($mincount < 0)
                {
                    // Референсная ссылка. Вероятность основывается на уже подсчитанной.
                    $num = $mincount;
                    $mincount = $drop[$num]['mincount'];
                    $chance = $chance * (1 - pow(1 - $drop[$num]['percent']/100, $maxcount));
                    $maxcount = $drop[$num]['maxcount']*$maxcount;
                }
    
                // Сохраняем подсчитанные для этих групп вероятности
                //(референсные записи хранятся с отрицательными номерами)
                $num = ($curtable <> $table) ? -$row['entry'] : $row['entry'];
                if(isset($drop[$num]))
                {
                    // Этот же элемент уже падал в другой подгруппе - считаем общую вероятность.
                    $newmin =($drop[$num]['mincount'] < $mincount) ? $drop[$num]['mincount'] : $mincount;
                    $newmax = $drop[$num]['maxcount'] + $maxcount;
                    $newchance = 100 - (100 - $drop[$num]['percent'])*(100-$chance)/100;
                    $drop[$num]['percent'] = $newchance;
                    $drop[$num]['mincount'] = $newmin;
                    $drop[$num]['maxcount'] = $newmax;
                }
                else
                {
                    $drop[$num] = array();
                    $drop[$num]['percent'] = $chance;
                    $drop[$num]['mincount'] = $mincount;
                    $drop[$num]['maxcount'] = $maxcount;
                    $drop[$num]['checked'] = false;
    
                    if($num > 0 && ++$total > 1000)
                        break;
                }
            }
    
            // Ищем хоть одну непроверенную reference-ную запись
            $num = 0;
            foreach($drop as $i => $value)
            {
                if($i < 0 && !$value['checked'])
                {
                    $num = $i;
                    break;
                }
            }
    
            // Нашли?
            if($num == 0)
            {
                // Все элементы проверены
                if($curtable != $table)
                {
                    // но это была reference-ная таблица - надо поискать в основной
                    $curtable = $table;
    
                    foreach($drop as $i => $value)
                        $drop[$i]['checked'] = false;
    
                    $rows = Yii::app()->db_world->createCommand("
                            SELECT entry, groupid, ChanceOrQuestChance, mincountOrRef, maxcount
                            FROM {$curtable}
                            WHERE
                                item = {$item}
                                AND mincountOrRef > 0")
                        ->queryAll();
                }
                else
                    // Если ничего не нашли и в основной таблице, то поиск закончен
                    break;
            }
            else
            {
                // Есть непроверенный элемент, надо его проверить
                $drop[$num]['checked'] = true;
                $rows = Yii::app()->db_world->createCommand("
                        SELECT entry, groupid, ChanceOrQuestChance, mincountOrRef, maxcount
                        FROM {$curtable}
                        WHERE mincountOrRef = {$num}")
                    ->queryAll();
            }
        }
    
        // Чистим reference-ные ссылки
        foreach($drop as $i => $value)
            if($i < 0)
                unset($drop[$i]);
    
        return $drop;
    }
}
