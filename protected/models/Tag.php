<?php

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property integer $id
 * @property string $alias
 * @property string $name
 */
class Tag extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, name', 'required'),
			array('alias, name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, alias, name', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
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
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function findByArticle($id){
        $command = Yii::app()->db
            ->createCommand('SELECT tag_id FROM article_tags WHERE article_id = :article_id')
            ->bindParam(':article_id', $id, PDO::PARAM_INT);
        $tagIds = $command->queryColumn();
        
        $cond = new CDbCriteria();
        $cond->addInCondition('id', $tagIds);
        return self::model()->findAll($cond);
    }
    
    public static function get($tagName){
        $tagAlias = Helper::transliterate($tagName);        
        $tag = Tag::model()->findByAttributes(array('alias' => $tagAlias));
        
        if (!$tag){
            $tag = new Tag();
            $tag->alias = $tagAlias;
            $tag->name = $tagName;
            $tag->save();
        }
        return $tag;
    }
    
    public function addRelation($article_id){
        //добавить связь
        $tid = $this->id;
        $command = Yii::app()->db
            ->createCommand('INSERT INTO article_tags (article_id,tag_id) VALUES(:article_id,:tag_id)')
            ->bindParam(':article_id', $article_id, PDO::PARAM_INT)
            ->bindParam(':tag_id', $tid);             
        return $command->execute();        
    }

    public function deleteRelation($article_id){
        $tid = $this->id;
        $command = Yii::app()->db
            ->createCommand('DELETE FROM article_tags WHERE article_id = :article_id AND tag_id = :tag_id')
            ->bindParam(':article_id', $article_id, PDO::PARAM_INT)
            ->bindParam(':tag_id', $tid);
        return $command->execute();        
    }
    
    public function deleteAllRelations($article_id){
        $command = Yii::app()->db
            ->createCommand('DELETE FROM article_tags WHERE article_id = :article_id')
            ->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        return $command->execute();        
    }
    
    /*public function delete() {
        $tid = $this->id;
        $command = Yii::app()->db
            ->createCommand('SELECT article_id FROM article_tags WHERE tag_id = :tag_id')
            ->bindParam(':tag_id', $id, PDO::PARAM_INT);
        $tagArticle = $command->queryScalar();
        
        if ($tagArticle){
            throw new CDbException('Tag related with Article '.$tagArticle);
        } else {
            parent::delete();
        } 
    }*/
    
}
