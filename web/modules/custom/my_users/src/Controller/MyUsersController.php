<?php

namespace Drupal\my_users\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for My users routes.
 */
class MyUsersController extends ControllerBase
{

  /**
   * Consult register users
   * @return array
   */
  public function consult() {
    $query = \Drupal::database()->select('myusers', 'u');
    $query->fields('u');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $result = $pager->execute()->fetchAll();

    $rows = [];

    foreach ($result as $item) {
      $row = (array)$item;
      $rows[] = $row;
    }

    $build['table'] = [
      '#rows' => $rows,
      '#header' => ['Id', 'Name'],
      '#type' => 'table'
    ];
    $build['pager'] = array(
      '#type' => 'pager'
    );

    return $build;
  }

  /**
   * Import register users
   * @return array
   */
  public function import() {
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Import'),
    ];

    return $build;
  }

}
