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
class ModalBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build() {

    $query = \Drupal::database()->select('myusers', 'u');
    $query->fields('u');
    $query->orderBy('id', 'DESC');
    $query->range(0, 1);
    $result = $query->execute()->fetchAll();
    $id = 1;

    if ($result) {
      $id = $result[0]->id + 1;
    }

    $build = [
      '#theme' => 'modal',
      '#title' => 'User saved',
      '#description' => 'Modal window to display saved user id',
      '#cache' => [
        'max-age' => 0,
      ]
    ];
    $build['#id'] = $id;

    return $build;
  }

}
