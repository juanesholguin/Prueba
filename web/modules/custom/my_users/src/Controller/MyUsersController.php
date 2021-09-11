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

}
