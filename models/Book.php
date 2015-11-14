<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property integer $released_at
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Author $author
 */
class Book extends \yii\db\ActiveRecord
{
    const IMAGES_DIRECTORY = 'web/uploads/';
    const IMAGES_URL       = '@web/uploads/';

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'released_at'], 'required'],
            [['released_at', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'safe'],
            [['imageFile'], 'file', 'extensions'=>'jpg, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'imageFile' => 'Preview',
            'image' => 'Preview',
            'released_at' => 'Released At',
            'author_id' => 'Author',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    public function getImageUrl()
    {
        return ($this->image) ? Url::to(self::IMAGES_URL . $this->image) : false;
    }

    /**
     * @inheritdoc
     * @return BookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BookQuery(get_called_class());
    }
}
