<?php

class Spell extends CActiveRecord
{

    public $info = false;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'wow_spells';
    }

    public function formatInfo()
    {
        $regExp = "/\\$+(?:([\/,*])?([0-9]*);)?([d+\;(\d*)?([1-9]*)([A-z])([1-3]*)(([A-z, ]*)\:([A-z, ]*)\;)?/";

        $info = $this->tooltip_loc0;
        $attributes = $this->attributes;
        
        //TODO: rewrite after support $this in PHP 5.4.0 

        $this->info = preg_replace_callback($regExp, function ($match) use ($attributes)
            {
                $select   = '';
                $match[5] = ($match[5]) ? $match[5] : '1';
                $match[4] = strtolower($match[4]);

                switch($match[4])
                {
                    case 'z':
                        return "[Home]";
                    case 'l':
                        return $match[8];
                    case 'g':
                        return $match[7];
                    case 'h':
                        $select = 'procChance';
                        break;
                    case 'u':
                        return '';
                    //$this->RegExpU($match);
                    case 'v':
                        $select = 'affected_target_level';
                        break;
                    case 'q':
                        $select = 'effect' . $match[5] . 'MiscValue';
                        break;
                    case 'i':
                        $select = 'spellTargets';
                        break;
                    case 'b':
                        $select = 'effect' . $match[5] . 'PointsPerComboPoint';
                        break;
                    case 'm': case 's':
                        $select = 'effect' . $match[5] . 'BasePoints';
                        break;
                    case 'a':
                        $select = 'effect' . $match[5] . 'radius';
                        break;
                    case 'd':
                        $select = 'durationID';
                        break;
                    case 'o':
                        $select = 'durationID, effect' . $match[5] . 'Amplitude, effect' . $match[5] . 'BasePoints';
                        break;
                    case 't':
                        $select = 'effect' . $match[5] . 'Amplitude';
                        break;
                    case 'n':
                        $select = 'procCharges';
                        break;
                    case 'x':
                        $select = 'effect' . $match[5] . 'ChainTarget';
                        break;
                    default:
                        break;
                }

                if($match[3])
                {
                    $command = Yii::app()->db->createCommand()
                        ->select($select)
                        ->from('wow_spells')
                        ->where('spellID = :spellID');
                    if($match[4] == 'o')
                        $value   = $command->queryRow(false, array(':spellID' => $match[3]));
                    else
                        $value     = $command->queryScalar(array(':spellID' => $match[3]));
                }
                elseif($match[4] == 'o')
                    $value     = array($attributes['durationID'], $attributes['effect' . $match[5] . 'Amplitude'], $attributes['effect' . $match[5] . 'BasePoints']);
                else
                    $value = $attributes[$select];

                if(is_array($value))
                    $value = Spell::GetRealDuration($value[0], $value[1], $match[5]) * ($value[2] + 1);

                if($match[4] == 's' or $match[4] == 'm')
                    $value += 1;
                elseif($match[4] == 'i' and !$value)
                    $value = 'nearby';
                elseif($match[4] == 'a')
                    $value = Spell::GetRadius($value, $match[5]);
                elseif($match[4] == 'd')
                    $value = Spell::GetDuration($value). ' sec';
                elseif($match[4] == 't')
                    $value /= 1000;

                if($match[2])
                    if($match[1] == "/")
                        $value = abs(($value + 1) / $match[2]);
                    else if($match[1] == "*")
                        $value = abs(($value + 1) * $match[2]);

                return $value;
            }, $info); 
    }

    public static function GetDuration($durationId)
    {
        return Yii::app()->db->createCommand("SELECT durationBase FROM wow_spellduration WHERE durationID = $durationId")->queryScalar() / 1000;
    }

    public static function GetRealDuration($durationId, $amplitude, $effIdx)
    {
        return self::GetDuration($durationId) / ($amplitude ? ($amplitude / 1000) : 5);
    }

    public static function GetRadius($radiusId, $effIdx)
    {
        return Yii::app()->db->createCommand("SELECT radiusBase FROM wow_spellradius WHERE radiusID = $radiusId")->queryScalar();
    }

    public function getIconName()
    {
        return strtolower(trim($this->dbConnection
                        ->createCommand("SELECT iconname FROM wow_spellicons WHERE id = {$this->spellicon} LIMIT 1")
                        ->queryScalar()));
    }

    public function getCastTime()
    {
        return $this->dbConnection
                ->createCommand("SELECT base FROM wow_spellcasttimes WHERE id = {$this->spellcasttimesID} LIMIT 1")
                ->queryScalar() / 1000;
    }

    public function getRange()
    {
        return $this->dbConnection->createCommand("SELECT rangeMax FROM wow_spellrange WHERE rangeID = {$this->rangeID} LIMIT 1")->queryScalar();
    }
}
