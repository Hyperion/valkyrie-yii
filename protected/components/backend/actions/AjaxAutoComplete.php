<?php

class AjaxAutoComplete extends CAction
{
    public $model;
    public $searchByAttributes;
    public $additionalAttributes = array();

    public function run($term)
    {
        if (Yii::app()->request->isAjaxRequest && !empty($term)) {
            $criteria = new CDbCriteria;

            foreach($this->searchByAttributes as $attribute) {
                $criteria->addSearchCondition($attribute, $term, true, 'OR');
            }

            $returnAttributes = CMap::mergeArray(
                array('id' => '$record->getPrimaryKey()', 'label' => '$record->getToString()'), $this->additionalAttributes
            );

            $results = array();
            $model = new $this->model;
            foreach($model::model()->findAll($criteria) as $record) {
                $_result = array();
                foreach($returnAttributes as $returnAttributeKey=>$returnAttributeExpression) {
                    $_result[$returnAttributeKey] = Yii::app()->evaluateExpression(
                        $returnAttributeExpression,
                        array('record' => $record)
                    );
                }
                $results[] = $_result;
            }
            echo CJSON::encode($results);
        }
    }
}
