<?php
class Migrate20181110223249CreateTableBoard extends \strangerfw\core\migrate\BaseMigrate{
  private $dbh = null;
  public function __construct($default_database) {
    parent::__construct($default_database);
  }

  public function up() {
    $sql = <<<EOM
CREATE TABLE boards (
  id int(9) NOT NULL AUTO_INCREMENT,
  title varchar(128) NOT NULL,
  body text NOT NULL,
  created_at datetime NOT NULL,
  modified_at datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY index_boards_id (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
EOM;
    parent::up($sql);
  }

  public function down(){
    $sql = <<<EOM
DROP TABLE boards;
EOM;
    parent::down($sql);
  } 
}