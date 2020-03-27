<?php
class UserController extends \strangerfw\core\controller\BaseController {
// class UserController {
  public $controller_class_name;
  public function __construct($uri, $url = null) {
    $debug= new \strangerfw\utils\Logger('DEBUG');
    $debug->log('UserController::__constructor()');
    $conf = \strangerfw\core\Config::get('database.config');
    $database = $conf['default_database'];
    parent::__construct($database, $uri, $url);
    $this->controller_class_name = str_replace('Controller', '', get_class($this));;
    $this->setAuthCheck(['create', 'edit', 'show', 'save', 'delete']);
    $this->role_ids = \strangerfw\core\Config::get('acc/users');
    $this->debug->log("UserController::__construct() end");
  }
  /**
   *  ログイン画面
   */
  public function login() {
    $auths = new \User($this->dbh);
    $form = $auths->createForm();
    $this->set('Title', 'Auth Login');
    $this->set('User', $form['User']);
  }

  /**
   *  ログアウト処理
   */
  public function logout() {
    session_destroy();
    $this->redirect(DOCUMENT_ROOT);
  }

  /**
   *  ログイン処理
   */
  public function auth() {
    try{
      if(\strangerfw\Authentication::auth($this->dbh, $this->request)){
        $this->redirect(DOCUMENT_ROOT);
      }
      else {
        $this->redirect(DOCUMENT_ROOT.'login/');
      }
    } catch (\Exception $e) {
      $this->redirect(DOCUMENT_ROOT.'login/');
    }
  }

  /**
   *
   */
  public function confirm(){
    $user = new \User($this->dbh);
    $data = $user->where('User.authentication_key', '=', $this->request['confirm_string'])->find('first');
    $data['User']['authentication_key'] = null;
    $user->save($data);
    $this->set('Title', 'User Confirmed');
    $this->set('message', 'Welcom, Confirmed your redistration.');
    $this->set('User', $data['User']);
    $this->set('datas', $data);
  }


  public function index() {
    $this->debug->log('UserController::index()');
    $users = new \User($this->dbh);
    $limit = 10 * (isset($this->request['page']) ? $this->request['page'] : 1);
    $offset = 10 * (isset($this->request['page']) ? $this->request['page'] - 1 : 0);

    $data = $users->contain(['UserInfo'])
      ->select([
        'User' => [
          'id',
          'username',
        ],
        'UserInfo' => [
          'username AS name',
          'addres',
        ],
      ])->find();

    $ref = isset($this->request['page']) ? $this->request['page'] : 0;
    $next = isset($this->request['page']) ? $this->request['page'] + 1 : 2;

    $this->set('Title', 'User List');
    $this->set('datas', $data);
    $this->set('User', $data);
    $this->set('ref', $ref);
    $this->set('next', $next);
  }

  public function show() {
/*
    $datas = null;
    $id = $this->request['id'];

    $users = new \User($this->dbh);
    $datas = $users->where('User.id', '=', $id)->find('first');
    $this->set('Title', 'User Ditail');
    $this->set('User', $datas['User']);
    $this->set('datas', $datas);
 */
  }

  public function create() {
/*
    $users = new \User($this->dbh);
    $form = $users->createForm();
    $this->set('Title', 'User Create');
    $this->set('User', $form['User']);
 */
  }

  public function save(){
/*
    try {
      $this->dbh->beginTransaction();
      $users = new \User($this->dbh);
      $users->save($this->request);
      $this->dbh->commit();
      $cmd = 'php ' . BIN_PATH . 'send_notify.php';
      $result = exec($cmd);
      $this->set('Title', 'User Save Error');
    } catch (\Exception $e) {
      $this->debug->log("UserController::save() error:" . $e->getMessage());
      $this->set('Title', 'User Save Error');
      $this->set('error_message', '保存ができませんでした。');
    }
 */
  }

  public function update(){
/*
    $session = \strangerfw\core\Session::get();
    try {
      $this->dbh->beginTransaction();
      $users = new \User($this->dbh);

      if (!isset($session['Auth'])) {
        throw new \Exception("権限がありません。", 1);
      }
      if (
          isset($session['Auth']) &&
          (
            isset($session['Auth'][$users->primary_key]) &&
            $session['Auth'][$users->primary_key] != $this->request['User'][$users->primary_key]
          )
        ) {
        throw new \Exception("権限がありません。", 1);
      }

      $users->update($this->request);
      $this->dbh->commit();
      $this->redirect(DOCUMENT_ROOT . 'User/show/' . $this->request['User'][$users->primary_key] .'/');
      exit();
      // $this->set('Title', 'User Save Error');
    } catch (\Exception $e) {
      $this->debug->log("UserController::update() error:" . $e->getMessage());
      $this->set('Title', 'User Save Error');
      $this->set('error_message', '保存ができませんでした。');
    }
 */
  }

  public function edit() {
/*
    try {
      $datas = null;
      $id = $this->request['id'];

      $users = new \User($this->dbh);
      $datas = $users->where('User.id', '=', $id)->find('first');
      $this->set('Title', 'User Edit');
      $this->set('User', $datas['User']);
      $this->set('datas', $datas);
    } catch (\Exception $e) {
      $this->debug->log("UserController::edit() error:" . $e->getMessage());
    }
 */
  }

  public function delete() {
/*
    try {
      $this->dbh->beginTransaction();
      $users = new \User($this->dbh);
      $users->delete($this->request['id']);
      $this->dbh->commit();
      $url = BASE_URL . User . '/index/';
    } catch (\Exception $e) {
      $this->debug->log("UsersController::delete() error:" . $e->getMessage());
    }
 */
  }
}
