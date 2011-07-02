<div id="profile">
<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t("UserModule.user", "Profile");
$this->breadcrumbs=array(Yii::t("UserModule.user", "Profile"));
$this->title = Yii::t("UserModule.user", 'Your profile');
$this->renderPartial('/messages/new_messages');?>


<div class="avatar">
<?php echo $model->renderAvatar(); ?>
</div>

<table class="dataGrid">
<?php if(!$this->module->loginType & UserModule::LOGIN_BY_EMAIL) {?>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?>
</th>
    <td><?php echo CHtml::encode($model->username); ?>
</td>
</tr>
<?php 
}
		$profileFields = ProfileField::model()->forOwner()->sort()->with('group')->together()->findAll();
		if ($profileFields && Yii::app()->getModule('user')->enableProfiles) {
	foreach($profileFields as $field) {
		if($field->field_type == 'DROPDOWNLIST') {
			?>
			<tr>
				<th class="label"><?php echo CHtml::encode(Yii::t('UserModule.user', $field->title)); ?>
				</th>
				<td><?php 
				if(is_object($model->profile->{ucfirst($field->varname)}))
					echo CHtml::encode($model->profile->{ucfirst($field->varname)}->{$field->related_field_name}); ?>
						</td>
						</tr>
				<?php
		} else {
			?>
				<tr>
				<th class="label"><?php echo CHtml::encode(Yii::t('UserModule.user', $field->title)); ?>
				</th>
				<td><?php echo CHtml::encode($model->profile->getAttribute($field->varname)); ?>
				</td>
				</tr>
				<?php
		}
	}
}
?>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('password')); ?>
</th>
    <td><?php echo CHtml::link(Yii::t("UserModule.user", "Change password"),array(Core::route('{user}/changepassword'))); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?>
</th>
    <td><?php echo date(UserModule::$dateFormat,$model->createtime); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?>
</th>
    <td><?php echo date(UserModule::$dateFormat,$model->lastvisit); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?>
</th>
    <td><?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status));
    ?>
</td>
</tr>
</table>

<div id="friends">
<h2> <?php echo Yii::t('UserModule.user', 'My friends'); ?> </h2>
<?php
if($model->friends)
{
foreach($friends as $friend) {
?>
<div id="friend">
<div id="avatar">
<?php
$model->renderAvatar($friend);
?>
<div id='user'>
<?php 
echo CHtml::link(ucwords($friend->username), Yii::app()->createUrl('user/profile/view',array('id'=>$friend->id)));
?>
</div>
</div>
</div>
</div>
<?php
}
}else {
		echo Yii::t('UserModule.user', 'You have no friends yet');
	}
?>
</div>
<div id="visits">
<h2> <?php echo Yii::t('UserModule.user', 'This users have visited my profile'); ?> </h2>
<?php
	if($model->visits) {
		$format = Yii::app()->getModule('user')->dateTimeFormat;
		echo '<table>';
		printf('<th>%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th>',
			Yii::t('UserModule.user', 'Visitor'),
			Yii::t('UserModule.user', 'Time of first Visit'),
			Yii::t('UserModule.user', 'Time of last Visit'),
			Yii::t('UserModule.user', 'Num of Visits'),
			Yii::t('UserModule.user', 'Message')
);

		foreach($model->visits as $visit) {
			if(isset($visit->visitor))  //we need this in case a user quits
			{
			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
					CHtml::link($visit->visitor->username, array('user/view', 'id' => $visit->visitor_id)),
					date($format, $visit->timestamp_first_visit),
					date($format, $visit->timestamp_last_visit),
					$visit->num_of_visits,
					CHtml::link(Yii::t('UserModule.user', 'Write a message'), array('messages/compose', 'to_user_id' => $visit->visitor_id))
					);
		}
	}
		echo '</table>';
	} else {
		echo Yii::t('UserModule.user', 'Nobody has visited your profile yet');
	}
?>
</div>
</div>
