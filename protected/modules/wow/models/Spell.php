<?php

class Spell extends CActiveRecord
{
	public $info = false;

	public static function model($className=__CLASS__)
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
            
            $this->info = $this->tooltip_loc0;
            
            $matches = array();
            
            preg_match_all($regExp, $this->info , $matches, PREG_SET_ORDER);

            foreach($matches as $match)
            {
                switch (strtolower($match[4]))
                {
                    case 'u':
                        $this->RegExpU($match);
                    break;
                    case 'h':
                        $this->RegExpH($match);
                    break;
                    case 'z':
                        $this->info = str_replace($match[0], "[Home]", $this->info);
                    break;
                    case 'v':
                        $this->RegExpV($match);
                    break;
                    case 'q':
                        $this->RegExpQ($match);
                    break;
                    case 'i':
                        $this->RegExpI($match);
                    break;
                    case 'b':
                        $this->RegExpB($match);
                    break;
                    case 'm':
                        $this->RegExpM($match);
                    break;
                    case 'a':
                        $this->RegExpA($match);
                    break;
                    case 'd':
                        $this->RegExpD($match);
                    break;
                    case 'o':
                        $this->RegExpO($match);
                    break;
                    case 's':
                        $this->RegExpS($match);
                    break;
                    case 't':
                        $this->RegExpT($match);
                    break;
                    case 'l':
                        $this->info = str_replace($match[0], $match[8], $this->info);
                    break;
                    case 'g':
                        $this->info = str_replace($match[0], $match[7], $this->info);
                    break;
                    case 'n':
                        $this->RegExpN($match);
                    break;
                    case 'x':
                        $this->RegExpX($match);
                    break;
                    default:
                    break;
                }
            }
	}
        
        private function GetDuration($durationId)
        {
            return $this->dbConnection->createCommand("SELECT durationBase FROM wow_spellduration WHERE durationID = $durationId")->queryScalar() / 1000;
        }

        private function GetRealDuration($durationId, $amplitude, $effIdx)
        {
            return $this->GetDuration($durationId) / ($amplitude ? ($amplitude / 1000) : 5);
        }
        
        private function GetRadius($radiusId, $effIdx)
        {
            return $this->dbConnection->createCommand("SELECT radiusBase FROM wow_spellradius WHERE radiusID = $radiusId")->queryScalar();
        }
        
        private function RegExpU($match)
        {
            if ($match[3])
                $stackAmount = $this->dbConnection->createCommand("SELECT stackAmount FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar(); 
            else
                $stackAmount = $this->stackAmount;

            $this->info = str_replace($match[0], $stackAmount, $this->info);
        }
        
        private function RegExpH($match)
        {
            if ($match[3])
                $procChance = $this->dbConnection->createCommand("SELECT procChance FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar(); 
            else
                $procChance = $this->procChance;

            $this->info = str_replace($match[0], $procChance, $this->info);
        }
        
        private function RegExpV($match)
        {
            if ($match[3])
                $targetLevel = $this->dbConnection->createCommand("SELECT affected_target_level FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar(); 
            else
                $targetLevel = $this->affected_target_level;

            $this->info = str_replace($match[0], $targetLevel, $this->info);
        }

        private function RegExpX($match)
        {
            if ($match[3])
                $chainTarget = $this->dbConnection->createCommand("SELECT effect{$match[5]}ChainTarget FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar(); 
            else
                $chainTarget = $this->{'effect'.$match[5].'ChainTarget'};

            $this->info = str_replace($match[0], $chainTarget, $this->info);
        }
        
        private function RegExpN($match)
        {
            if ($match[3])
                $procCharges = $this->dbConnection->createCommand("SELECT procCharges FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar(); 
            else
                $procCharges = $this->procCharges;

            $this->info = str_replace($match[0], $procCharges, $this->info);
        }
        
        private function RegExpI($match)
        {
            if ($match[3])
                $spellTargets = $this->dbConnection->createCommand("SELECT spellTargets FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar(); 
            else
                $spellTargets = $this->spellTargets;

            $this->info = str_replace($match[0], $spellTargets ? $spellTargets : "nearby", $this->info);
        }
        
        private function RegExpT($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $effectAmplitude = $this->dbConnection->createCommand("SELECT effect{$match[5]}Amplitude FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                    if ($match[1] == "/")
                        $effectAmplitude = $effectAmplitude / 1000 / $match[2];
                    else if ($match[1] == "*")
                        $effectAmplitude = $effectAmplitude / 1000 * $match[2];
                }
                else
                {
                    if ($match[1] == "/")
                        $effectAmplitude = $this->{'effect'.$match[5].'Amplitude'} / 1000 / $match[2];
                    else if ($match[1] == "*")
                        $effectAmplitude = $this->{'effect'.$match[5].'Amplitude'} / 1000 * $match[2];
                }
            }
            else if ($match[3])
            {
                $effectAmplitude = $this->dbConnection->createCommand("SELECT effect{$match[5]}Amplitude FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                $effectAmplitude /= 1000;
            }
            else
                $effectAmplitude = $this->{'effect'.$match[5].'Amplitude'} / 1000;

            $this->info = str_replace($match[0], $effectAmplitude, $this->info);
        }
        
        private function RegExpS($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $value = $this->dbConnection->createCommand("SELECT effect{$match[5]}BasePoints FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                    if ($match[1] == "/")
                        $value = abs(($value + 1) / $match[2]);
                    else if ($match[1] == "*")
                        $value = abs(($value + 1) * $match[2]);
                }
                else
                {
                    if ($match[1] == "/")
                        $value = abs(($this->{'effect'.$match[5].'BasePoints'} + 1) / $match[2]);
                    else if ($match[1] == "*")
                        $value = abs(($this->{'effect'.$match[5].'BasePoints'} + 1) * $match[2]);
                }
            }
            else if ($match[3])
                $value = abs(1 + $this->dbConnection->createCommand("SELECT effect{$match[5]}BasePoints FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar());
            else
                $value = abs($this->{'effect'.$match[5].'BasePoints'} + 1);
            
            $this->info = str_replace($match[0], $value, $this->info);
        }
        
        private function RegExpO($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $tSpell = $this->dbConnection->createCommand("SELECT * FROM wow_spells WHERE spellID = {$match[3]}")->queryRow();
                    if ($match[1] == "/")
                        $value = $this->GetRealDuration($tSpell["durationID"], $tSpell["effect{$match[5]}Amplitude"], $match[5]) * ($tSpell["effect{$match[5]}BasePoints"] + 1) / $match[2];
                    else if ($match[1] == "*")
                        $value = $this->GetRealDuration($tSpell["durationID"], $tSpell["effect{$match[5]}Amplitude"], $match[5]) * ($tSpell["effect{$match[5]}BasePoints"] + 1) * $match[2];
                }
                else
                {
                    if ($match[1] == "/")
                        $value = $this->GetRealDuration($this->durationID, $this->{'effect'.$match[5].'Amplitude'}, $match[5]) * ($this->{'effect'.$match[5].'BasePoints'} + 1) / $match[2];
                    else if ($match[1] == "*")
                        $value = $this->GetRealDuration($this->durationID, $this->{'effect'.$match[5].'Amplitude'}, $match[5]) * ($this->{'effect'.$match[5].'BasePoints'} + 1) * $match[2];
                }
            }
            else if ($match[3])
            {
                $tSpell = $this->dbConnection->createCommand("SELECT * FROM wow_spells WHERE spellID = {$match[3]}")->queryRow();
                $value = $this->GetRealDuration($tSpell["durationID"], $tSpell["effect{$match[5]}Amplitude"], $match[5]) * ($tSpell->{'effect'.$match[5].'BasePoints'} + 1);
            }
            else
                $value = $this->GetRealDuration($this->durationID, $this->{'effect'.$match[5].'Amplitude'}, $match[5]) * ($this->{'effect'.$match[5].'BasePoints'} + 1);

            $this->info = str_replace($match[0], $value, $this->info);
        }
        
        private function RegExpD($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $duration = $this->dbConnection->createCommand("SELECT durationID FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                    if ($match[1] == "/")
                        $duration = $this->GetDuration($duration) / $match[2];
                    else if ($match[1] == "*")
                        $duration = $this->GetDuration($duration) * $match[2];
                }
                else
                {
                    if ($match[1] == "/")
                        $duration = $this->GetDuration($this->durationID) / $match[2];
                    else if ($match[1] == "*")
                        $duration = $this->GetDuration($this->durationID) * $match[2];
                }
            }
            else if ($match[3])
            {
                $durationId = $this->dbConnection->createCommand("SELECT durationID FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                $duration = $this->GetDuration($durationId);
            }
            else
                $duration = $this->GetDuration($this->durationID);

            $this->info = str_replace($match[0], $duration, $this->info);
        }
        
        private function RegExpA($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $radius = $this->dbConnection->createCommand("SELECT effect{$match[5]}radius FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                    if ($match[1] == "/")
                        $radius = $this->GetRadius($radius, $match[5]) / $match[2];
                    else if ($match[1] == "*")
                        $radius = $this->GetRadius($radius, $match[5]) * $match[2];
                }
                else
                {
                    if ($match[1] == "/")
                        $radius = $this->GetRadius($this->{'effect'.$match[5].'radius'}, $match[5]) / $match[2];
                    else if ($match[1] == "*")
                        $radius = $this->GetRadius($this->{'effect'.$match[5].'radius'}, $match[5]) * $match[2];
                }
            }
            else if ($match[3])
            {
                $radius = $this->dbConnection->createCommand("SELECT effect{$match[5]}radius FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                $radius = $this->GetRadius($radius, $match[5]);
            }
            else
                $radius = $this->GetRadius($this->{'effect'.$match[5].'radius'}, $match[5]);

            $this->info = str_replace($match[0], $radius, $this->info);
        }
        
        private function RegExpM($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $effectBasePoints = $this->dbConnection->createCommand("SELECT effect{$match[5]}BasePoints FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                    if ($match[1] == "/")
                        $effectBasePoints = abs(($effectBasePoints + 1) / $match[2]);
                    else if ($match[1] == "*")
                        $effectBasePoints = abs(($effectBasePoints + 1) * $match[2]);
                }
                else
                {
                    if ($match[1] == "/")
                        $effectBasePoints = abs(($this->{'effect'.$match[5].'BasePoints'} + 1) / $match[2]);
                    else if ($match[1] == "*")
                        $effectBasePoints = abs(($this->{'effect'.$match[5].'BasePoints'} + 1) * $match[2]);
                }
            }
            else if ($match[3])
                $effectBasePoints = abs(1 + $this->dbConnection->createCommand("SELECT effect{$match[5]}BasePoints FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar());
            else
                $effectBasePoints = abs($this->{'effect'.$match[5].'BasePoints'} + 1);

            $this->info = str_replace($match[0], $effectBasePoints, $this->info);
        }
        
        private function RegExpB($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $effectPointsPerComboPoint = $this->dbConnection->createCommand("SELECT effect{$match[5]}PointsPerComboPoint FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                    if ($match[1] == "/")
                        $effectPointsPerComboPoint = $effectPointsPerComboPoint / $match[2];
                    else if ($match[1] == "*")
                        $effectPointsPerComboPoint = $effectPointsPerComboPoint * $match[2];
                }
                else
                {
                    if ($match[1] == "/")
                        $effectPointsPerComboPoint = $this->{'effect'.$match[5].'PointsPerComboPoint'} / $match[2];
                    else if ($match[1] == "*")
                        $effectPointsPerComboPoint = $this->{'effect'.$match[5].'PointsPerComboPoint'} * $match[2];
                }
            }
            else if ($match[3])
                $effectPointsPerComboPoint = $this->dbConnection->createCommand("SELECT effect{$match[5]}PointsPerComboPoint FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
            else
                $effectPointsPerComboPoint = $this->{'effect'.$match[5].'PointsPerComboPoint'};

            $this->info = str_replace($match[0], $effectPointsPerComboPoint, $this->info);
        }
        
        private function RegExpQ($match)
        {
            if ($match[2])
            {
                if ($match[3])
                {
                    $effectMiscValue = $this->dbConnection->createCommand("SELECT effect{$match[5]}MiscValue FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar();
                    if ($match[1] == "/")
                        $effectMiscValue = abs($effectMiscValue / $match[2]);
                    else if ($match[1] == "*")
                        $effectMiscValue = abs($effectMiscValue * $match[2]);
                }
                else
                {
                    if ($match[1] == "/")
                        $effectMiscValue = abs($this->{'effect'.$match[5].'MiscValue'} / $match[2]);
                    else if ($match[1] == "*")
                        $effectMiscValue = abs($this->{'effect'.$match[5].'MiscValue'} * $match[2]);
                }
            }
            else if ($match[3])
                $effectMiscValue = abs($this->dbConnection->createCommand("SELECT effect{$match[5]}MiscValue FROM wow_spells WHERE spellID = {$match[3]}")->queryScalar());
            else
                $effectMiscValue = abs($this->{'effect'.$match[5].'MiscValue'});

            $this->info = str_replace($match[0], $effectMiscValue, $this->info);
        }
        
        public function getIconName()
        {
            return trim($this->dbConnection->createCommand("SELECT iconname FROM wow_spellicons WHERE id = {$this->spellicon}")->queryScalar());
        }
}
