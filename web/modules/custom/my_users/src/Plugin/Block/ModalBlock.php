<?php

namespace Drupal\my_users\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "my_users_example",
 *   admin_label = @Translation("Modal block"),
 *   category = @Translation("My users")
 * )
 */
class ModalBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $query = \Drupal::database()->select('myusers', 'u');
    $query->fields('u');
    $query->range(0,1);
    $result = $query->execute()->fetchAll();
    $id = "";

    if ($result){
      $id = $result[0]->id;
    }
    $build = [
      '#theme' => 'modal',
      '#title' => 'User saved',
      '#description' => 'Modal window to display saved user id'
    ];
    $build['#id'] = $id;
    return $build;
  }

}
