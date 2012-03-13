<?php

class BGalleryBehavior extends CBehavior
{

    public function getImages()
    {
        return Yii::app()->db
                ->createCommand('SELECT id FROM images WHERE (user_id = :user_id AND user_guid = 0) OR (user_guid = :user_guid AND user_guid != 0)')
                ->queryColumn(array(
                    ':user_id' => $this->owner->id,
                    ':user_guid' => (isset(Yii::app()->controller->user_guid)) ? Yii::app()->controller->user_guid : '0',
            ));
    }

    public function getAlbums()
    {
        return Yii::app()->db
                ->createCommand('SELECT id FROM albums WHERE user_id = :user_id')
                ->queryColumn(array(':user_id' => $this->owner->id));
    }

}
