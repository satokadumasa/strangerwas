<?php
class PrefController extends \strangerfw\core\controller\BaseController{
  public function __construct($uri, $url = null) {
    $conf = \strangerfw\core\Config::get('database.config');
    $database = $conf['default_database'];
    parent::__construct($database, $uri, $url);
    $this->controller_class_name = str_replace('Controller', '', get_class($this));;
  }

  public function index() {
    $prefs = new Pref($this->dbh);
    $limit = 10 * (isset($this->request['page']) ? $this->request['page'] : 1);
    $offset = 10 * (isset($this->request['page']) ? $this->request['page'] - 1 : 0);

    $datas = $prefs->where('Pref.id', '>', 0)->limit($limit)->offset($offset)->find('all');

    $ref = isset($this->request['page']) ? $this->request['page'] : 0;
    $next = isset($this->request['page']) ? $this->request['page'] + 1 : 2;

    $this->set('Title', 'Pref List');
    $this->set('datas', $datas);
    $this->set('Pref', $datas);
    $this->set('ref', $ref);
    $this->set('next', $next);
  }

  public function show() {
    $datas = null;
    $id = $this->request['id'];

    $prefs = new Pref($this->dbh);
    $datas = $prefs->where('Pref.id', '=', $id)->find('first');
    $this->set('Title', 'Pref Ditail');
    $this->set('Pref', $datas['Pref']);
    $this->set('datas', $datas);
  }

  public function create() {
    $this->debug->log("PrefController::create()");
    $prefs = new Pref($this->dbh);
    $form = $prefs->createForm();
    $this->set('Title', 'Pref Create');
    $this->set('Pref', $form['Pref']);
  }

  public function save(){
    $this->debug->log("PrefController::save()");
    try {
      $this->dbh->beginTransaction();
      $prefs = new Pref($this->dbh);
      $prefs->save($this->request);
      $this->dbh->commit();
      $url = BASE_URL . 'Pref' . '/show/' . $prefs->primary_key_value . '/';
      $this->redirect($url);
    } catch (\Exception $e) {
      $this->debug->log("PrefController::create() error:" . $e->getMessage());
      $this->set('Title', 'Pref Save Error');
      $this->set('error_message', '保存ができませんでした。');
    }
  }

  public function edit() {
    $this->debug->log("PrefController::edit()");
    try {
      $datas = null;
      $id = $this->request['id'];

      $prefs = new Pref($this->dbh);
      $datas = $prefs->where('Pref.id', '=', $id)->find('first');
      $this->set('Title', 'Pref Edit');
      $this->set('Pref', $datas['Pref']);
      $this->set('datas', $datas);
    } catch (\Exception $e) {
      $this->debug->log("PrefController::edit() error:" . $e->getMessage());
    }
  }

  public function delete() {
    try {
      $this->dbh->beginTransaction();
      $prefs = new Pref($this->dbh);
      $prefs->delete($this->request['id']);
      $this->dbh->commit();
      $url = BASE_URL . 'Pref' . '/index/';
    } catch (\Exception $e) {
      $this->debug->log("UsersController::delete() error:" . $e->getMessage());
    }
  }


}