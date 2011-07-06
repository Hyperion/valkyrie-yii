<?php

class CharacterReputation extends CActiveRecord
{
    const FACTION_HORDE = 1;
    const FACTION_ALLIANCE = 0;

    const REP_HATED =      0;
    const REP_HOSTILE =    1;
    const REP_UNFRIENDLY = 2;
    const REP_NEUTRAL =    3;
    const REP_FRIENDLY =   4;
    const REP_HONORED =    5;
    const REP_REVERED =    6;
    const REP_EXALTED =    7;

    const REPUTATION_CAP = 42999;
    const REPUTATION_BOTTOM = -42000;
    const MIN_REPUTATION_RANK = self::REP_HATED;
    const MAX_REPUTATION_RANK = 8;

    const REPUTATION_VALUE_HATED = -6000;
    const REPUTATION_VALUE_HOSTILE = -3000;
    const REPUTATION_VALUE_UNFRIENDLY = 0;
    const REPUTATION_VALUE_NEUTRAL = 3000;
    const REPUTATION_VALUE_FRIENDLY = 9000;
    const REPUTATION_VALUE_HONORED = 21000;
    const REPUTATION_VALUE_REVERED = 42000;
    const REPUTATION_VALUE_EXALTED = 42999;

    const FACTION_FLAG_VISIBLE = 0x01;         // makes visible in client (set or can be set at interaction with target of this faction)
    const FACTION_FLAG_AT_WAR  = 0x02;         // enable AtWar-button in client. player controlled (except opposition team always war state), Flag only set on initial creation
    const FACTION_FLAG_HIDDEN  = 0x04;         // hidden faction from reputation pane in client (player can gain reputation, but this update not sent to client)
    const FACTION_FLAG_INVISIBLE_FORCED = 0x08;// always overwrite FACTION_FLAG_VISIBLE and hide faction in rep.list, used for hide opposite team factions
    const FACTION_FLAG_PEACE_FORCED = 0x10;    // always overwrite FACTION_FLAG_AT_WAR, used for prevent war with own team factions
    const FACTION_FLAG_INACTIVE = 0x20;        // player controlled, state
    const FACTION_FLAG_RIVAL = 0x40;           // flag for the two competing outland factions

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Database::getConnection(Database::$realm);
    }

    public function tableName()
    {
        return 'character_reputation';
    }

    public function relations()
    {
        return array(
            'character' => array(self::BELONGS_TO, 'Character', 'guid'),
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'rank' => array(
                self::REP_HATED =>      'Hated',
                self::REP_HOSTILE =>    'Hostile',
                self::REP_UNFRIENDLY => 'Unfriendly',
                self::REP_NEUTRAL =>    'Neutral',
                self::REP_FRIENDLY =>   'Friendly',
                self::REP_HONORED =>    'Honored',
                self::REP_REVERED =>    'Revered',
                self::REP_EXALTED =>    'Exalted'
            ),
        );

        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public static function getFactionNameFromDB($factionId)
    {
        if($factionId == 0) {
            return 'Other';
        }
        $column = 'name_'.Yii::app()->language;
        return Yii::app()->db
                ->createCommand("SELECT $column
                    FROM `wow_factions`
                    WHERE `id` = $factionId LIMIT 1")
                ->queryScalar();
    }

}
