<div class="form">
<?php
$this->title = Yii::t('UserModule.user', 'Upload avatar');

$this->breadcrumbs = array(Yii::t('UserModule.user', 'Profile'), Yii::t('UserModule.user', 'Upload avatar'));

if($model->avatar) {
	echo '<h2>';
	echo Yii::t('UserModule.user', 'Your Avatar image');
	echo '</h2>';
	echo $model->getAvatar();
}
else
	echo Yii::t('UserModule.user', 'You do not have set an avatar image yet');

	echo '<br />';

if($this->module->avatarMaxWidth != 0)
	echo '<p>' . Yii::t('UserModule.user', 'The image should have at least 50px and a maximum of 200px in width and height. Supported filetypes are .jpg, .gif and .png') . '</p>';

	echo CHtml::errorSummary($model);
	echo CHtml::beginForm(array('//user/avatar/editAvatar'), 'POST', array(
				'enctype' => 'multipart/form-data'));
	echo '<div class="row">';
	echo CHtml::activeLabelEx($model, 'avatar');
	echo CHtml::activeFileField($model, 'avatar');
	echo CHtml::error($model, 'avatar');
	echo '</div>';
	echo CHtml::Button(Yii::t('UserModule.user', 'Remove Avatar'), array(
				'submit' => array(
					'avatar/removeAvatar')));
	echo CHtml::submitButton(Yii::t('UserModule.user', 'Upload Avatar'));
	echo CHtml::endForm();

?>
</div>
