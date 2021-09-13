<?php

namespace Drupal\my_logs;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

/**
 * Provides a view controller for a my logs entity type.
 */
class MyLogsViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  protected function getBuildDefaults(EntityInterface $entity, $view_mode) {
    $build = parent::getBuildDefaults($entity, $view_mode);
    // The my logs has no entity template itself.
    unset($build['#theme']);
    return $build;
  }

}
