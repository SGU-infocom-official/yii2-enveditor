<?php

namespace sguinfocom\enveditor;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * customer module definition class
 */
class Module extends \yii\base\Module{

    public $controllerNamespace = 'sguinfocom\enveditor\controllers';

    public $allowedIds = null;

    public function init()
    {
       $ids = explode(",",$this->allowedIds);
       if (!in_array(Yii::$app->user->id,$ids)){
           throw new NotFoundHttpException('The requested page does not exist.');
       }
        parent::init();
    }

}
