<?php
class Migrate20200328175530CreateTableRole extends \strangerfw\core\migrate\BaseMigrate {
  private $dbh = null;
  public function __construct($default_database) {
    parent::__construct($default_database);
  }

  public function up() {
    $sql = <<<EOM
CREATE TABLE roles (
  id int(9) NOT NULL AUTO_INCREMENT,
  name varchar(64) NOT NULL,
  created_at datetime NOT NULL,
  modified_at datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY index_roles_id (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
EOM;
    parent::up($sql);
  }

  public function down(){
    $sql = <<<EOM
DROP TABLE roles;
EOM;
    parent::down($sql);
  } 
}