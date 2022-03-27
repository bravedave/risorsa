<?php
/*
 * David Bray
 * BrayWorth Pty Ltd
 * e. david@brayworth.com.au
 *
 * MIT License
 *
*/

namespace risorsa;

use Json;
use strings;

class controller extends \Controller {
  protected function _index() {

    $this->render([
      'title' => $this->title = config::label,
      'primary' => ['matrix'],
      'secondary' => ['index'],
      'data' => (object)[
        'searchFocus' => true,
        'pageUrl' => strings::url($this->route)
      ]
    ]);
  }

  protected function before() {
    config::risorsa_checkdatabase();
    parent::before();

    $this->viewPath[] = __DIR__ . '/views/';  // location for module specific views
  }

  protected function postHandler() {
    $action = $this->getPost('action');

    if ('get-by-id' == $action) {
      /*
        (_ => {
          _.post({
            url: _.url('risorsa'),
            data: {
              action: 'get-by-id',
              id : 1
            },
          }).then(d => {
            if ('ack' == d.response) {
              console.log(d.data);
            } else {
              _.growl(d);
            }
          });

        })(_brayworth_);
       */
      if ($id = (int)$this->getPost('id')) {
        $dao = new dao\risorsa;
        if ($dto = $dao->getByID($id)) {
          Json::ack($action)
            ->add('data', $dto);
        } else {
          Json::nak($action);
        }
      } else {
        Json::nak($action);
      }
    } elseif ('get-matrix' == $action) {
      /*
        (_ => {
          _.post({
            url: _.url('risorsa'),
            data: {
              action: 'get-matrix'
            },
          }).then(d => {
            if ('ack' == d.response) {
              console.table(d.data);
            } else {
              _.growl(d);
            }
          });

        })(_brayworth_);
       */
      $dao = new dao\risorsa;
      Json::ack($action)
        ->add('data', $dao->getMatrix());
    } elseif ('risorsa-save' == $action) {
      $a = [
        'computer' => $this->getPost('computer'),
        'purchase_date' => $this->getPost('purchase_date'),
        'computer_name' => $this->getPost('computer_name'),
        'cpu' => $this->getPost('cpu'),
        'memory' => $this->getPost('memory'),
        'hdd' => $this->getPost('hdd'),
        'os' => $this->getPost('os')

      ];

      $dao = new dao\risorsa;
      if ($id = (int)$this->getPost('id')) {

        $dao->UpdateByID($a, $id);
      } else {
        $dao->Insert($a);
      }
      Json::ack($action); // json return { "response": "ack", "description" : "risorsa-save" }
    } else {
      parent::postHandler();
    }
  }

  public function edit($id = 0) {
    // tip : the structure is available in the view at $this->data->dto
    $this->data = (object)[
      'title' => $this->title = config::label,
      'dto' => new dao\dto\risorsa
    ];

    if ( $id = (int)$id) {
      $dao = new dao\risorsa;
      $this->data->dto = $dao->getByID($id);
      $this->data->title .= ' edit';
    }

    $this->load('edit');
  }
}
