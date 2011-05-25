<?php

class PostController extends Controller
{
	public $layout='column2';

	private $_model;

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionView()
	{
		$post=$this->loadModel();
		$comment=$this->newComment($post);

		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}

	public function actionCreate()
	{
		$cs=Yii::app()->getClientScript();	
		$cs->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/base/jquery-ui.css');
		$cs->registerCssFile('/css/jquery.fileupload-ui.css');
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js');
		$cs->registerScriptFile('/js/jquery.fileupload.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/jquery.fileupload-ui.js', CClientScript::POS_END);
		$cs->registerScriptFile('/js/application.js', CClientScript::POS_END);

		$model=new Material('post');
		if(isset($_POST['Material']))
		{
			$model->attributes=$_POST['Material'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpload()
	{
		
		$options = array(
		    'upload_dir' => Yii::app()->basePath.'/../uploads/images/',
   			'upload_url' => '/uploads/images/',
    		'thumbnails_dir' => Yii::app()->basePath.'/../uploads/thumbnails/',
    		'thumbnails_url' => '/uploads/thumbnails/',
    		'thumbnail_max_width' => 100,
    		'thumbnail_max_height' => 100,
    		'field_name' => 'file'
		);

		$upload_handler = new UploadHandler($options);

		switch ($_SERVER['REQUEST_METHOD'])
		{
    		case 'HEAD':
    		case 'GET':
        		$upload_handler->get();
        		break;
    		case 'POST':
        		$upload_handler->post();
        		break;
    		case 'DELETE':
        		$upload_handler->delete();
        		break;
    		default:
        		header('HTTP/1.0 405 Method Not Allowed');
		}
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();
		$model['scenario'] = 'post';
		if(isset($_POST['Material']))
		{
			$model->attributes=$_POST['Material'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionVote($id, $type)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = Vote::model()->findByAttributes(array(
				'user_id'     => Yii::app()->user->id,
				'material_id' => (int) $id,));
			if($model == null)
			{
				$model = new Vote;
				$model['user_id'] = Yii::app()->user->id;
				$model['material_id'] = (int) $id;
				$model['value'] = ($type == 'positive') ? 1 : -1;
				$model->save();
			}
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex($type = false)
	{
		$count=Yii::app()
			->db
			->createCommand('SELECT COUNT(*) 
				FROM materials 
				WHERE status="'.Material::STATUS_PUBLISHED.'" AND type="'.Material::TYPE_POST.'"')
			->queryScalar();

		$sql['new'] = 'SELECT m.id, m.title, c.title AS category
				FROM materials m, categories c
				WHERE 
					m.status      = "'.Material::STATUS_PUBLISHED.'" AND 
					m.type        = "'.Material::TYPE_POST.'" AND
					m.category_id = c.id
				ORDER BY m.create_time DESC';

        $sql['popular'] = 'SELECT m.id, m.title, c.title AS category
                FROM materials m
				LEFT JOIN votes v
				ON m.id = v.material_id
				LEFT JOIN categories c
				ON m.category_id = c.id
                WHERE 
                    m.status      = "'.Material::STATUS_PUBLISHED.'" AND 
                    m.type        = "'.Material::TYPE_POST.'"
                GROUP BY m.id
                ORDER BY SUM(CASE WHEN v.material_id THEN v.value ELSE 0 END) DESC';

        $sql['notpopular'] = 'SELECT m.id, m.title, c.title AS category
                FROM materials m
                LEFT JOIN votes v
                ON m.id = v.material_id
                LEFT JOIN categories c
                ON m.category_id = c.id
                WHERE 
                    m.status      = "'.Material::STATUS_PUBLISHED.'" AND 
                    m.type        = "'.Material::TYPE_POST.'"
                GROUP BY m.id
                ORDER BY SUM(CASE WHEN v.material_id THEN v.value ELSE 0 END) ASC';

        $sql['editable']='SELECT m.id, m.title, c.title AS category
                FROM materials m
                LEFT JOIN comments com
                ON m.id = com.material_id
                LEFT JOIN categories c
                ON m.category_id = c.id
                WHERE 
                    m.status      = "'.Material::STATUS_PUBLISHED.'" AND 
                    m.type        = "'.Material::TYPE_POST.'"
				GROUP BY m.id
				ORDER BY COUNT(com.id) DESC';

		
		if($type)
		{
			switch($type)
			{
				case 'new': 		$sql = $sql['new']; 		break;
				case 'editable': 	$sql = $sql['editable']; 	break;
				case 'notpopular': 	$sql = $sql['notpopular']; 	break;
				case 'popular': 	$sql = $sql['popular']; 	break;
				default: break;
			}
			$dataProvider=new CSqlDataProvider($sql, array(
				'totalItemCount' => $count,
				'pagination'=>array(
					'pageSize'=>Yii::app()->params['postsPerPage'],
				),
			));
		}
		else
		{
			foreach($sql as $type => $value)
			{
	            $dataProvider[$type] = new CSqlDataProvider($value, array(
    	            'totalItemCount' => $count,
        	        'pagination'=>array(
            	        'pageSize'=>Yii::app()->params['postsPerPage'],
                	),
            	));

			}
			$type = false;
		}
		$this->render('index',array(
			'type' => $type,
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionAdmin()
	{
		$model=new Material('search');
		if(isset($_GET['Material']))
			$model->attributes=$_GET['Material'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSuggestTags()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=Tag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				if(Yii::app()->user->isGuest)
					$condition='status="'.Material::STATUS_PUBLISHED.'" OR status="'.Material::STATUS_ARCHIVED.'"';
				else
					$condition='';
				$this->_model=Material::model()->findByPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	protected function newComment($post)
	{
		$comment=new Comment('post_comment');
		$comment['material_id'] = $post['id'];
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
}
