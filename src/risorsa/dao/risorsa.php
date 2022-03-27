<?php
/*
 * David Bray
 * BrayWorth Pty Ltd
 * e. david@brayworth.com.au
 *
 * MIT License
 *
*/

namespace risorsa\dao;

use dao\_dao;

class risorsa extends _dao {
  protected $_db_name = 'risorsa';
  protected $template = __NAMESPACE__ . '\dto\risorsa';

  public function getMatrix() : array {
    $sql = 'SELECT * FROM `risorsa`';
    if ( $res = $this->Result($sql)) {
      return $this->dtoSet($res);
    }

    return [];
  }

  public function Insert($a) {
    $a['created'] = $a['updated'] = self::dbTimeStamp();
    return parent::Insert($a);
  }

  public function UpdateByID($a, $id) {
    $a['updated'] = self::dbTimeStamp();
    return parent::UpdateByID($a, $id);
  }
}
