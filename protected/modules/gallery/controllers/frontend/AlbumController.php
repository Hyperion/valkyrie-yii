<?php

class AlbumController extends Controller
{

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'view'   => 'application.components.actions.View',
        );
    }

}
