<?php

class WarEffort
{

    public function __construct()
    {
        $this->_db_chars = Yii::app()->db_chars;
    }

    public function fetch($side)
    {
        if($side != 'horde' and $side != 'alliance') return;
        $quests = array(
            'horde' => array(8609, 8600, 8615, 8532, 8549, 8611, 8542, 8604, 8580, 8588, 8607, 8545, 8582, 8613, 8590),
            'alliance' => array(8499, 8522, 8509, 8492, 8511, 8517, 8524, 8513, 8503, 8494, 8526, 8520, 8505, 8528, 8515),
        );
        $quests_repeatable = array(
            'horde' => array(8610, 8601, 8616, 8533, 8550, 8612, 8543, 8605, 8581, 8589, 8608, 8546, 8583, 8614, 8591),
            'alliance' => array(8500, 8523, 8510, 8493, 8512, 8518, 8525, 8514, 8504, 8495, 8527, 8521, 8506, 8529, 8516),
        );
        $resource_max = array(
            'horde' => array(400000, 60000, 10000, 90000, 96000, 10000, 22000, 250000, 19000, 60000, 250000, 18000, 26000, 17000, 80000),
            'alliance' => array(24000, 400000, 20000, 90000, 180000, 800000, 14000, 110000, 33000, 28000, 20000, 600000, 26000, 17000, 80000),
        );

        $db = Yii::app()->db_world;
        $command = $db->createCommand()
            ->select('i.name as name, i.entry as item_entry, q.ReqItemCount1 as count, q.entry as entry')
            ->from('item_template i, quest_template q')
            ->where(array('and', 'i.entry = q.ReqItemId1', array('in', 'q.entry', $quests[$side])));

        $data = $command->queryAll();
        
        $db = new WowDatabase();
        $db = $db->getDb();
        
        $command = $db->createCommand()
            ->select('count(*) as count, quest')
            ->from('character_queststatus')
            ->where(array('and', 'rewarded = 1', array('in', 'quest', $quests[$side])))
            ->group('quest');

        $quest_counts = $command->queryAll();

        $complited = array();

        foreach($quest_counts as $quest)
        {
            $complited[$quest['quest']] = $quest['count'];
        }

        $command = $db->createCommand()
            ->select('count(*) as count, quest')
            ->from('character_queststatus')
            ->where(array('and', 'rewarded = 1', array('in', 'quest', $quests_repeatable[$side])))
            ->group('quest');

        $quest_counts = $command->queryAll();

        foreach($quest_counts as $quest)
        {
            $complited[$quest['quest']-1] += $quest['count'];
        }

        $quests_max = array_flip($quests[$side]);

        for($i = 0; $i < count($data); $i++)
        {
            $entry = $data[$i]['entry'];
            $data[$i]['complited'] = isset($complited[$entry]) ? $complited[$entry] : 0;
            $data[$i]['max'] = $resource_max[$side][$quests_max[$entry]];
        }
        
        return $data;
    }
}