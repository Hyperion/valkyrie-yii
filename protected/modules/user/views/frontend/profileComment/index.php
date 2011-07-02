<h2> <?php echo Yii::t('UserModule.user', 'Profile Comments'); ?> </h2>

<?php 
$dataProvider = new CActiveDataProvider('ProfileComment', array(
			'criteria'=>array(
				'condition'=>'profile_id = :profile_id',
				'params' => array(':profile_id' => $model->id),
				'order'=>'createtime DESC')
			)
		);

$this->renderPartial('/profileComment/create', array(
			'comment' => new ProfileComment,
			'profile' => $model));

$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'/profileComment/_view',
			));  

