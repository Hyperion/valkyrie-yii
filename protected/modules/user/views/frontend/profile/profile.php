<?php
$this->pageTitle = Yii::app()->name.' - '.UserModule::t("Profile");
$this->breadcrumbs = array(
    UserModule::t("Profile"),
);

$this->pageCaption = UserModule::t('Your profile');

$this->widget('BootAlert');
?>
<table class="table table-striped table-condensed detail-view">
    <tr>
        <th><?php echo CHtml::encode($model->getAttributeLabel('username')); ?></th>
        <td><?php echo CHtml::encode($model->username); ?></td>
    </tr>
    <?php
    $profileFields = ProfileField::model()->forOwner()->sort()->findAll();
    if ($profileFields):
        foreach ($profileFields as $field):
            //echo "<pre>"; print_r($profile); die();
            ?>
            <tr>
                <th><?php echo CHtml::encode(UserModule::t($field->title)); ?></th>
                <td><?php echo (($field->widgetView($profile)) ? $field->widgetView($profile) : CHtml::encode((($field->range) ? Profile::range($field->range, $profile->getAttribute($field->varname)) : $profile->getAttribute($field->varname)))); ?></td>
            </tr>
            <?php
        endforeach;
    ////$profile->getAttribute($field->varname)
    endif;
    ?>
    <tr>
        <th><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></th>
        <td><?php echo CHtml::encode($model->email); ?></td>
    </tr>
    <tr>
        <th><?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?></th>
        <td><?php echo date("d.m.Y H:i:s", $model->createtime); ?></td>
    </tr>
    <tr>
        <th><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?></th>
        <td><?php echo date("d.m.Y H:i:s", $model->lastvisit); ?></td>
    </tr>
    <tr>
        <th><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></th>
        <td><?php echo CHtml::encode(User::itemAlias("UserStatus", $model->status)); ?></td>
    </tr>
</table>
