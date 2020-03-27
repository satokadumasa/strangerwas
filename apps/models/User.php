<?php
class User extends \strangerfw\core\model\BaseModel {
  public $table_name  = 'users';
  public $model_name  = 'User';
  public $model_class_name  = 'User';

  //  Relation
  public $belongthTo = null;
  public $has = [
    'UserInfo' => [
      'JOIN_COND' => 'LEFT',
      'FOREIGN_KEY' => 'user_id'
    ],
    'Board' => [
      'JOIN_COND' => 'LEFT',
      'FOREIGN_KEY' => 'user_id'
    ],
    'Book' +> [
      'JOIN_COND' => 'LEFT',
      'FOREIGN_KEY' => 'user_id',
    ],
  ];
  public $has_many_and_belongs_to = null;

  public function __construct(&$dbh) {
    parent::__construct($dbh);
  }

  public function save($form) {
    $form[$this->model_name]['password'] = md5($form[$this->model_name]['password'].SALT);
    $form[$this->model_name]['notified_at'] = null;
    $form[$this->model_name]['role_id'] = USER_ROLE_ID;
    $form[$this->model_name]['authentication_key'] = \strangerfw\utils\StringUtil::makeRandStr(16);
    parent::save($form);
    return $form;
  }

  public function update($form) {
    $session = \strangerfw\core\Session::get();
    unset($form[$this->model_name]['password_confirm']);
    $form[$this->model_name]['password'] = md5($form[$this->model_name]['password'].SALT);
    $form[$this->model_name]['notified_at'] = date('Y-m-d H:i:s');
    unset($form[$this->model_name]['role_id']);
    $form[$this->model_name]['authentication_key'] = null;
    parent::save($form);
    return $form;
  }

  public function auth($form) {
    $form[$this->model_name]['password'] = md5($form[$this->model_name]['password'].SALT);
    $data = $this->where('User.username', '=', $form[$this->model_name]['username'])
                 ->where('User.password', '=', $form[$this->model_name]['password'])
                 ->where('User.authentication_key', 'IS NULL', null)
                 ->find('first');
    return $data;
  }
}
