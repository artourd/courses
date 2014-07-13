<?php

/**
 * This is the model class for table "branch".
 *
 * The followings are the available columns in table 'branch':
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property integer $scope_id
 * @property string $created
 * @property string $updated
 * @property integer $active
 * @property string $picture
 * @property string $thumb
 * @property string $ico
 *
 * The followings are the available model relations:
 * @property Scope $scope
 * @property Product[] $products
 */
class Branch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'branch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, title, scope_id', 'required'),
			array('scope_id, active', 'numerical', 'integerOnly'=>true),
			array('alias, title', 'length', 'max'=>50),
			array('picture, thumb, ico', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, alias, title, scope_id, created, updated, active, picture, thumb, ico', 'safe', 'on'=>'search'),
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
			'scope' => array(self::BELONGS_TO, 'Scope', 'scope_id'),
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
			'scope_id' => 'Scope',
			'created' => 'Created',
			'updated' => 'Updated',
			'active' => 'Active',
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
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('scope_id',$this->scope_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('ico',$this->ico,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Branch the static model class
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
    
    public static function getForDropDown($scope_id){
        $crit = new CDbCriteria();
        $crit->condition = 'scope_id = "'.$scope_id.'"';
        $allModels = Branch::model()->findAll( $crit );
   
        $items = array();
        foreach ($allModels as $model){
            $items[$model->id] = $model->title;
        }   
        reset($items);        
        return $items;
    }    
}
