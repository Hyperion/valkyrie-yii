<?php

class WowDropLoot
{
	private static function add_loot(&$loot, $newloot)
	{
		// Записываем все существующие в луте итемы в массив
		$e = array();
		foreach($loot as $offset => $item)
			$e[$item['entry']] = $offset;

		foreach($newloot as $newitem)
		{
			// MUST NOT HAPPEN
			if(!is_array($newitem))
				return;
			// Если в луте есть такая вещь
			if(isset($e[$newitem['entry']]))
			{
				$loot[$e[$item['entry']]]['mincount'] = min($loot[$e[$item['entry']]]['mincount'], $newitem['mincount']);
				$loot[$e[$item['entry']]]['maxcount'] = max($loot[$e[$item['entry']]]['maxcount'], $newitem['maxcount']);
				$loot[$e[$item['entry']]]['percent'] += $newitem['percent'];
				$loot[$e[$item['entry']]]['group'] = 0;
			}
			else
				$loot[] = $newitem;
		}
	}

	public static function loot($table, $lootid, $mod = 1)
	{
		// Все элементы
		$loot = array();
		$groups = array();
		// Мего запрос :)
		$rows = Yii::app()->db_world->createCommand("
			SELECT 
				l.ChanceOrQuestChance, 
				l.mincountOrRef, 
				l.maxcount,
				l.groupid,
				i.displayid,
				i.entry,
				i.name,
				i.itemLevel,
				i.Quality
			FROM  {$table} l
			LEFT JOIN item_template i ON l.item=i.entry
			WHERE
				l.entry= {$lootid}
			ORDER BY groupid ASC, ChanceOrQuestChance DESC")->queryAll();
	

		$last_group = 0;
		$last_group_equal_chance = 100;
		// Перебираем
		foreach($rows as $row)
		{
			// Не группа
			if($row['groupid'] == 0)
			{
				// Ссылка
				if($row['mincountOrRef'] < 0)
					self::add_loot($loot, self::loot('reference_loot_template', -$row['mincountOrRef'], abs($row['ChanceOrQuestChance']) / 100 * $row['maxcount'] * $mod));
				else
					// Обыкновенный дроп
					self::add_loot($loot, array(array(
						'percent'   => max(abs($row['ChanceOrQuestChance']) * $mod, 0),
						'mincount'  => $row['mincountOrRef'],
						'maxcount'  => $row['maxcount'],
						'entry'		=> $row['entry'],
						'name'		=> $row['name'],
						'itemLevel' => $row['itemLevel'],
						'quality'	=> $row['Quality'],
						'icon'		=> Yii::app()->db
            				->createCommand("SELECT icon FROM wow_icons WHERE displayid = {$row['displayid']} LIMIT 1")
            				->queryScalar(),
					)));
			}
			// Группа
			else
			{
				$chance = abs($row['ChanceOrQuestChance']);
				// Новая группа?
				if($row['groupid'] <> $last_group)
				{
					$last_group = $row['groupid'];
					$last_group_equal_chance = 100;
				}

				// Шанс лута задан
				if($chance > 0)
				{
					$last_group_equal_chance -= $chance;
					$last_group_equal_chance = max($last_group_equal_chance, 0);

					// Ссылка
					if($row['mincountOrRef'] < 0)
					{
						self::add_loot($loot, self::loot('reference_loot_template', -$row['mincountOrRef'], $chance / 100 * $row['maxcount'] * $mod));
					}
					else
						self::add_loot($loot, array(array(
							'percent'  => $chance * $mod,
							'mincount' => $row['mincountOrRef'],
							'maxcount' => $row['maxcount'],
							'entry'		=> $row['entry'],
							'name'		=> $row['name'],
							'itemLevel' => $row['itemLevel'],
							'quality'   => $row['Quality'],
							'icon'		=> Yii::app()->db
            					->createCommand("SELECT icon FROM wow_icons WHERE displayid = {$row['displayid']} LIMIT 1")
            					->queryScalar(),
						)));
				}
				// Шанс не задан, добавляем эту группу в группы
				else
				{
					$groups[$last_group][] = array(
						'mincount' => $row['mincountOrRef'],
						'maxcount' => $row['maxcount'],
						'groupchance'=>$last_group_equal_chance * $mod,
						'entry'		=> $row['entry'],
						'name'		=> $row['name'],
						'itemLevel' => $row['itemLevel'],
						'quality'	=> $row['Quality'],
						'icon'		=> Yii::app()->db
            				->createCommand("SELECT icon FROM wow_icons WHERE displayid = {$row['displayid']} LIMIT 1")
            				->queryScalar(),
					);
				}
			}
		}

		// Перебираем и добавляем группы
		foreach($groups as $group)
		{
			$num = count($group);
			foreach($group as $item)
			{
				$item['percent'] = $item['groupchance'] / $num;
				self::add_loot($loot, array($item));
			}
		}
		return $loot;
	}

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
