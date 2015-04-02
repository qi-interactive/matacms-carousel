<?php

namespace matacms\carousel\controllers;

use yii;
use matacms\carousel\models\Carousel;
use matacms\carousel\models\CarouselSearch;
use matacms\carousel\models\CarouselItem;
use matacms\controllers\module\Controller;
use matacms\carousel\clients\CarouselClient;
use mata\widgets\fineuploader\FineUploader;
use mata\keyvalue\models\KeyValue;
use mata\media\models\Media;
use yii\helpers\Json;
use matacms\widgets\ActiveForm;
use yii\web\Response;
use matacms\widgets\videourl\helpers\VideoUrlHelper;

class CarouselItemController extends Controller 
{

    public function actions()
    {
        return [
            'rearrange' => [
                'class' => 'matacms\carousel\actions\RearrangeAction',
                'model' => new CarouselItem(),
                'onValidationErrorHandler' => function() { echo 'ERROR'; }
            ],
        ];
    }

    public function getModel() 
    {
        return new CarouselIiem();
    }

    public function getSearchModel() 
    {
        return new CarouselItemSearch();
    }

    /**
     * Create CarouselItem and create media entity for newly created CarouselItem document
     * @return [type] [description]
     */
    
    public function actionUploadSuccessful() 
    {
        $carouselId = \Yii::$app->getRequest()->get("carouselId");
        $carouselItemId = \Yii::$app->getRequest()->get("carouselItemId");
        $carouselItemModel = CarouselItem::find()->where(["Id" => $carouselItemId])->one();

        if(!$carouselItemModel) {
            $carouselItemModel = new CarouselItem;
            $carouselItemModel->CarouselId = $carouselId;
            if ($carouselItemModel->save() == false)
                throw new \yii\web\HttpException(500, $carouselItemModel->getTopError());
        }        

        $s3Endpoint = KeyValue::findValue(FineUploader::S3_ENDPOINT);
        $s3Bucket = KeyValue::findValue(FineUploader::S3_BUCKET);

        $imageURL = $s3Endpoint . "/" . $s3Bucket  . "/" . urlencode(\Yii::$app->getRequest()->post("key"));

        $mediaWidth = 0; 
        $mediaHeight = 0;
        $mimeType = "default";

        $imageAttributes = getimagesize($imageURL);

        if ($imageAttributes != null) {
            $mediaWidth = $imageAttributes[0];
            $mediaHeight = $imageAttributes[1];
            $mimeType = $imageAttributes['mime'];
        } else {
            $ch = curl_init($imageURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $mimeType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        }

        $mediaModel = Media::find()->forItem($carouselItemModel)->one();

        if(!$mediaModel) {
            $mediaModel = new Media() ;
            $mediaModel->attributes = array(
                "Name" => \Yii::$app->getRequest()->post("name"),
                "DocumentId" => $carouselItemModel->getDocumentId(),
                "URI" => $imageURL,
                "Width" => $mediaWidth,
                "Height" => $mediaHeight,
                "MimeType" => $mimeType
                );
        } else {
            $mediaModel->attributes = array(
                "Name" => \Yii::$app->getRequest()->post("name"),
                "URI" => $imageURL,
                "Width" => $mediaWidth,
                "Height" => $mediaHeight,
                "MimeType" => $mimeType
                );
        }

        if ($mediaModel->save() == false)
            throw new \yii\web\HttpException(500, $mediaModel->getTopError());

        // Change Media Id to CarouselItem Id
        $mediaModel->Id = $carouselItemModel->Id;
        Yii::$app->response->format = Response::FORMAT_JSON;
        echo Json::encode($mediaModel);
    }

    public function actionProcessVideoUrl() 
    {
        $carouselId = \Yii::$app->getRequest()->get("carouselId");
        $carouselItemId = \Yii::$app->getRequest()->get("carouselItemId");
        $carouselItemModel = CarouselItem::find()->where(["Id" => $carouselItemId])->one();

        $videoUrlForm = new \matacms\widgets\videourl\models\VideoUrlForm;
        if($videoUrlForm->load(Yii::$app->request->post()) && $videoUrlForm->validate()) {
            if(!$carouselItemModel) {
                $carouselItemModel = new CarouselItem;
                $carouselItemModel->CarouselId = $carouselId;
                if ($carouselItemModel->save() == false)
                    throw new \yii\web\HttpException(500, $carouselItemModel->getTopError());
            }
            $mediaModel = Media::find()->forItem($carouselItemModel)->one();
            if(!$mediaModel) {
                $mediaModel = new Media() ;
                $mediaModel->attributes = array(
                    "Name" => $videoUrlForm->videoUrl,
                    "DocumentId" => $carouselItemModel->getDocumentId(),
                    "URI" => $videoUrlForm->videoUrl,
                    "Width" => 0,
                    "Height" => 0,
                    "MimeType" => $this->identifyVideoServiceProvider($videoUrlForm->videoUrl),
                    "Extra" => Json::encode(['thumbnailUrl' => VideoUrlHelper::getPicture($videoUrlForm->videoUrl)])
                    );
            } else {
                $mediaModel->attributes = array(
                    "Name" => $videoUrlForm->videoUrl,
                    "URI" => $videoUrlForm->videoUrl,
                    "MimeType" => $this->identifyVideoServiceProvider($videoUrlForm->videoUrl),
                    "Extra" => Json::encode(['thumbnailUrl' => VideoUrlHelper::getPicture($videoUrlForm->videoUrl)])
                    );
            }

            if ($mediaModel->save() == false)
                throw new \yii\web\HttpException(500, $mediaModel->getTopError());

            // For response only
            $mediaModel->Extra = Json::decode($mediaModel->Extra);
            Yii::$app->response->format = Response::FORMAT_JSON;
            // Change Media Id to CarouselItem Id
            $mediaModel->Id = $carouselItemModel->Id;
            echo Json::encode($mediaModel);

        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo ActiveForm::validate($videoUrlForm);
        }      
    }

    public function actionAddMedia($carouselId, $widgetId, $image = false, $video = false) 
    {        
        return $this->renderAjax('_create', [
            'carouselId' => $carouselId,
            'widgetId' => $widgetId,
            'mediaTypes' => ['image' => $image, 'video' => $video],
            ]);
    }

    public function actionUpdate($id, $widgetId = false) 
    {
        $carouselItemModel = CarouselItem::find()->where(["Id" => $id])->one();

        if(Yii::$app->request->getIsPost()) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if($carouselItemModel->load(Yii::$app->request->post()) && $carouselItemModel->save()) {
                echo Json::encode(['Response'=>'OK']);
            } else {
                echo ActiveForm::validate($carouselItemModel);
            }
            Yii::$app->end();
        }
        
        return $this->renderAjax('_update', [
            'carouselItemModel' => $carouselItemModel,
            'widgetId' => $widgetId,
            'mediaModel' => Media::find()->forItem($carouselItemModel)->one()
            ]);
    }

    public function actionDelete($id) 
    {
        $carouselItemModel = CarouselItem::find()->where(["Id" => $id])->one();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if(Yii::$app->request->getIsPost()) {
            if($carouselItemModel->delete())
                echo Json::encode(['Response'=>'OK']);
            else
                echo Json::encode(['Response'=>'ERROR']);
            Yii::$app->end();
        }
        echo Json::encode(['Response'=>'ERROR']);
        Yii::$app->end();
    }

    protected function identifyVideoServiceProvider($value) 
    {
        $url = preg_replace('#\#.*$#', '', trim($value));
        $services_regexp = [
        '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/'     => 'vimeo',
        '/(?:https?:\/\/)?(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=)?([\w-]{10,})/'     => 'youtube'
        ];

        foreach ($services_regexp as $pattern => $service) {
            if(preg_match($pattern, $value, $matches)) {
                return 'video/'.$service;
            }
        }

        return "default";
    }
}
