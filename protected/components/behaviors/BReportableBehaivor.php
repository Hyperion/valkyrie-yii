<?php

class BReportableBehaivor extends CActiveRecordBehavior
{

    public $reportModelClass     = 'Report';
    public $ownerControllerField = 'owner_controller';
    public $ownerModuleField     = 'owner_module';
    public $ownerIdField         = 'owner_id';
    public $reportTextField      = 'report_text';
    public $ownerController = null;
    public $ownerModule     = null;

    function addReport($text)
    {
        $report = new $this->reportModelClass;

        $report->setAttribute($this->reportTextField, $text);
        $report->setAttribute($this->ownerIdField, $this->getOwner()->getPrimaryKey());
        $report->setAttribute($this->ownerControllerField, $this->ownerController);
        $report->setAttribute($this->ownerModuleField, $this->ownerModule);

        return $report->save();
    }

    function getReports()
    {
        $report = $this->getModelInstance();

        $criteria = new CDbCriteria();
        $criteria->compare($this->ownerIdField, $this->getOwner()->getPrimaryKey());
        $criteria->compare($this->ownerControllerField, $this->ownerController);
        $criteria->compare($this->ownerModuleField, $this->ownerModule);

        return $report->findAll($criteria);
    }

    private function getModelInstance()
    {
        if(!isset($this->reportModelClass))
        {
            throw new CException(Yii::t('app', 'reportModelClass should be defined.'));
        }
        return CActiveRecord::model($this->reportModelClass);
    }

    function afterDelete($event)
    {
        $reports = $this->getReports();
        foreach($reports as $report)
        {
            $report->delete();
        }

        parent::afterDelete($event);
    }

}