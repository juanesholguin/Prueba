<?php

namespace Drupal\my_logs\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\my_logs\MyLogsInterface;
use Drupal\user\UserInterface;

/**
 * Defines the my logs entity class.
 *
 * @ContentEntityType(
 *   id = "my_logs",
 *   label = @Translation("My logs"),
 *   label_collection = @Translation("My logses"),
 *   handlers = {
 *     "view_builder" = "Drupal\my_logs\MyLogsViewBuilder",
 *     "list_builder" = "Drupal\my_logs\MyLogsListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\my_logs\Form\MyLogsForm",
 *       "edit" = "Drupal\my_logs\Form\MyLogsForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "my_logs",
 *   admin_permission = "administer my logs",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/content/my-logs/add",
 *     "canonical" = "/my_logs/{my_logs}",
 *     "edit-form" = "/admin/content/my-logs/{my_logs}/edit",
 *     "delete-form" = "/admin/content/my-logs/{my_logs}/delete",
 *     "collection" = "/admin/content/my-logs"
 *   },
 *   field_ui_base_route = "entity.my_logs.settings"
 * )
 */
class MyLogs extends ContentEntityBase implements MyLogsInterface {

  /**
   * {@inheritdoc}
   *
   * When a new my logs entity is created, set the uid entity reference to
   * the current user as the creator of the entity.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += ['uid' => \Drupal::currentUser()->id()];
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setDescription(t('The user ID of the my logs author.'))
      ->setSetting('target_type', 'user')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the my logs was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['ip'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Ip'))
      ->setDescription(t('Ip for user'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['Type'] = BaseFieldDefinition::create("list_string")
      ->setDefaultValue([['value' => 'Login'], ['value' => 'Registration']])
      ->setSettings([
        'allowed_values' => ['login' => 'Login', 'registration' => 'Registration']
      ])
      ->setLabel('Type')
      ->setDescription('Log type')
      ->setRequired(TRUE)
      ->setCardinality(1)
      ->setDisplayOptions('form', array(
        'type' => 'select',
        'weight' => 2,
      ))
      ->setDisplayConfigurable('form', TRUE);

    return $fields;
  }

}
