<?php if($profile->getPublicFields()) { ?>
<table class="table_profile_fields">
<?php foreach($profile->getPublicFields() as $field) { ?>

	<tr>
	<th class="label"> <?php echo Yii::t('UserModule.user', $field->title); ?> </th> 
	<td> <?php echo $profile->{$field->varname}; ?> </td>
	</tr>

<?php } ?>
</table>
<?php } ?>

<div class="clear"></div>
