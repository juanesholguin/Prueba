<?php

namespace Drupal\my_users\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for My users routes.
 */
class MyUsersController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

  /**
   * Consult register users
   * @return array
   */
  public function consult(){
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Consult'),
    ];

    return $build;
  }

  /**
   * Register register users
   * @return array
   */
  public function register(){
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Register'),
    ];

    return $build;
  }

  /**
   * Import register users
   * @return array
   */
  public function import(){
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Import'),
    ];

    return $build;
  }

}
