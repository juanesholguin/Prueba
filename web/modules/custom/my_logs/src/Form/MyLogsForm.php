<?php

namespace Drupal\my_logs\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the my logs entity edit forms.
 */
class MyLogsForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New my logs %label has been created.', $message_arguments));
      $this->logger('my_logs')->notice('Created new my logs %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The my logs %label has been updated.', $message_arguments));
      $this->logger('my_logs')->notice('Updated new my logs %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.my_logs.canonical', ['my_logs' => $entity->id()]);
  }

}
