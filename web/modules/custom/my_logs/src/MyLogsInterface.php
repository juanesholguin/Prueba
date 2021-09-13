<?php

namespace Drupal\my_logs;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a my logs entity type.
 */
interface MyLogsInterface extends ContentEntityInterface, EntityOwnerInterface {

  /**
   * Gets the my logs creation timestamp.
   *
   * @return int
   *   Creation timestamp of the my logs.
   */
  public function getCreatedTime();

  /**
   * Sets the my logs creation timestamp.
   *
   * @param int $timestamp
   *   The my logs creation timestamp.
   *
   * @return \Drupal\my_logs\MyLogsInterface
   *   The called my logs entity.
   */
  public function setCreatedTime($timestamp);

}
