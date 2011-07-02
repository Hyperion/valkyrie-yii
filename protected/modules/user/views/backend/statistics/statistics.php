<?php

$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users') => array('index'),
    Yii::t('UserModule.user', 'Statistics'));

echo '<table class="statistics" cellspacing=0 cellpadding=0>';
$f = '<tr><td>%s</td><td>%s</td></tr>';
printf($f, Yii::t('UserModule.user', 'Total users'), $total_users);
printf($f, Yii::t('UserModule.user', 'Active users'), $active_users);
printf($f, Yii::t('UserModule.user', 'Active first visit users'), $active_first_visit_users);
printf($f, Yii::t('UserModule.user', 'New users registered today'), $todays_registered_users);
printf($f, Yii::t('UserModule.user', 'Inactive users'), $inactive_users);
printf($f, Yii::t('UserModule.user', 'Banned users'), $banned_users);
printf($f, Yii::t('UserModule.user', 'Admin users'), $admin_users);
printf($f, Yii::t('UserModule.user', 'Profiles'), $profiles);
printf($f, Yii::t('UserModule.user', 'Different viewn Profiles'), $profile_views);
printf($f, Yii::t('UserModule.user', 'Profile fields'), $profile_fields);
printf($f, Yii::t('UserModule.user', 'Messages'), $messages);
printf($f, Yii::t('UserModule.user', 'Different users logged in today'), $logins_today);
echo '</table>';
