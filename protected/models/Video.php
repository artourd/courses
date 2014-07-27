<?php

/**
 * This is the model class for table "video".
 *
 * The followings are the available columns in table 'video':
 * @property integer $id
 * @property integer $article_id
 * @property string $link
 * @property string $title
 * @property string $desc
 */
class Video extends CActiveRecord
{
    public $scope_id = null;
    public $product_id = null;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('article_id', 'required'),
			array('id, article_id', 'numerical', 'integerOnly'=>true),
			array('link, desc', 'length', 'max'=>250),
            array('alias', 'length', 'max'=>50),
			array('title', 'length', 'max'=>100),
			array('desc', 'length', 'max'=>250),            
            array('created', 'length', 'max'=>20),
            array('updated', 'length', 'max'=>20),
            array('picture', 'length', 'max'=>100),
            array('thumb', 'length', 'max'=>100),
            array('ico', 'length', 'max'=>100),              
            array('active', 'numerical', 'integerOnly'=>true),            
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, article_id, link, title, alias, desc, created, updated, active, picture, thumb, ico, order ', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'article'=>array(self::BELONGS_TO, 'Article', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'scope_id' => 'Scope',
            'product_id' => 'Product',
            'article_id' => 'Article',
			'link' => 'Link',
			'title' => 'Title',
            'alias' => 'alias',
			'desc' => 'Desc',
            'created' => 'Created',
            'updated' => 'Updated',
            'active' => 'Active',
            'ord' => 'Order',
            'picture' => 'Picture',
            'thumb' => 'Thumb',
            'ico' => 'Ico',              
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('desc',$this->desc,true);
        $criteria->compare('alias',$this->alias,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);
        $criteria->compare('active',$this->active,true);
        $criteria->compare('picture',$this->title,true);
        $criteria->compare('thumb',$this->title,true);
        $criteria->compare('ico',$this->title,true); 
        $criteria->compare('order',$this->ord,true); 
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Video the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    protected function beforeSave()
    {
        if (empty($this->created)){
          $this->created = date('Y-m-d H:i:s');
        }
        $this->updated = date('Y-m-d H:i:s');
        
        return parent::beforeSave();
    }     
    
    public static function existByAlias($alias, $article_id = null){
        $crit = new CDbCriteria();
        if ($article_id){
            $crit->condition = 'article_id = :article_id AND alias = :alias';
            $crit->params = array(':article_id' => $article_id, ':alias' => $alias);
        } else {
            $crit->condition = 'alias = :alias';
            $crit->params = array(':alias' => $alias);
        }
        return (bool) Video::model()->count($crit);
    }

    public static function getMaxOrder($article_id){
        return Yii::app()->db->createCommand("SELECT MAX(ord) FROM video WHERE article_id = :article_id")
            ->bindValue(':article_id', $article_id)
            ->queryScalar();
    }
}
