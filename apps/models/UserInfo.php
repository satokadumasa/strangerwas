<?php
class UserInfo extends \strangerfw\core\model\BaseModel {
  public $table_name  = 'user_infos';
  public $model_name  = 'UserInfo';
  public $model_class_name  = 'UserInfo';

  //  Relation
  public $belongthTo = null;
  public $has = null;
  public $has_many_and_belongs_to = null;

  public function __construct(&$dbh) {
    parent::__construct($dbh);
  }
}

