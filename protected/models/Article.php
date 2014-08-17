<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $short
 * @property string $content
 * @property string $created
 * @property string $updated
 * @property string $published
 * @property string $author
 * @property string $meta_desc
 * @property string $meta_keys
 */
class Article extends CActiveRecord
{
    public $scope_id = null;
    public $product = null;
    public $tags = array();


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, alias, title, content, published', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('alias, title, short, author_id', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, alias, product_id, title, short, content, created, updated, published, author_id, order, level, style', 'safe', 'on'=>'search'),
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
            'product'=>array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'alias' => 'Alias',
			'title' => 'Title',
			'short' => 'Short',
			'content' => 'Content',
            'scope_id' => 'Scope',
			'product_id' => 'Product',            
			'created' => 'Created',
			'updated' => 'Updated',
			'published' => 'Published',
			'author_id' => 'Author',
            'level' => 'Level',
            'style' => 'Style',
            'ord' => 'Order',
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
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('product_id',$this->product_id);        
		$criteria->compare('content',$this->content,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('published',$this->published,true);
		$criteria->compare('author_id',$this->author_id,true);
        $criteria->compare('order',$this->ord,true);
        $criteria->compare('style',$this->style,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
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
        
        Yii::app()->cache->delete('article_'.$this->id);
        
        return parent::beforeSave();
    }    
    
    public static function getForDropDown($product_id){
        $crit = new CDbCriteria();
        $crit->condition = 'product_id = "'.$product_id.'"';
        $allModels = self::model()->findAll( $crit );
   
        $items = array();
        foreach ($allModels as $model){
            $items[$model->id] = $model->title;
        }   
        reset($items);        
        return $items;
    }        
    
    /**
     * 
     * @param type $filters
     * @param type $tags
     * @return type
     */
    public static function getItems($filters = array(), $tags = array(), $direct = null ){
        //http://www.yiiframework.com/doc/guide/1.1/ru/database.query-builder
        $command = Yii::app()->db->createCommand();
        $command->select('id')
                ->from('article')
                ->where('published > 0')
                ->order('id desc')
                ->limit(10, 0);
        
        $ids = $command->queryColumn();
        
        foreach ($ids as $id){
            $items[$id] = self::getItem($id);
        }
        
        return $items;
    }
    
    public static function getItem($id){
        $item = false;//Yii::app()->cache->get('article_'.$id);
        
        if ($item === false){            
            $prods = Product::getItems();
            
            $item = self::model()->findByPk($id);
            $item->product = $prods[$item->product_id];
            $item->tags = Tag::findByArticle($item->id);
            
            //Yii::app()->cache->set('article_'.$id, $item, 86400 * 365);
        }
                
        return $item;
    }
}
