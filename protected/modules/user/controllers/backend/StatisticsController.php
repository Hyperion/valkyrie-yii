<?php

class StatisticsController extends AdminController
{
    const PAGE_SIZE=10;

    public function actionIndex()
    {
        $this->render('statistics', array(
                    'total_users' => User::model()->count(),
                    'active_users' => User::model()->count('status = '.User::STATUS_ACTIVE),
                    'active_first_visit_users' => User::model()->count('status = '.User::STATUS_ACTIVE_FIRST_VISIT),
                    'todays_registered_users' => User::model()->count('createtime >= '.strtotime(date('Y-m-d'))),
                    'inactive_users' => User::model()->count('status = '.User::STATUS_NOTACTIVE),
                    'banned_users' => User::model()->count('status = '.User::STATUS_BANNED),
                    'admin_users' => User::model()->count('superuser = 1'),
                    'profiles' => Profile::model()->count(),
                    'profile_fields' => ProfileField::model()->count(),
                    'profile_views' => ProfileVisit::model() !== false ? ProfileVisit::model()->count() : null,
                    'messages' => Message::model()->count(),
                    'logins_today' => $this->loginsToday(),
                    ));
    }

    public function getStartOfDay($time = 0)
    {
        if($time == 0)
            $time = time();
        $hours = date("G", $time);
        $minutes = date("i", $time);
        $seconds = date("s", $time);

        $temp = $time;
        $temp -= ($hours * 3600);
        $temp -= ($minutes * 60);
        $temp -= $seconds;

        $today = $temp;
        $first = $today;

        return $first;
    }


    public function loginsToday()
    {
        $day = $this->getStartOfDay(time());
        return User::model()->count(
            'lastvisit > :begin and lastvisit < :end', array(
                ':begin' => $day,
                ':end' => $day + 86400));
    }

}
