<?php

namespace Drupal\my_users\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\InvokeCommand;

/**
 * Implements an example form.
 */
class RegisterUser extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'register_users';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    /* attached libraries*/
    $form['#attached']['library'][] = 'my_users/my_users';

    /* create field form */
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#prefix' => '<div id="nameUser"></div>',
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    /* buttons and actions */
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
      '#ajax' => array(
        'callback' => '::callbackUsers',
        'effect' => 'fade',
        'progress' => array(
          'type' => 'throbber',
          'message' => NULL,
        ),
      ),
    ];
    return $form;
  }

  public function callbackUsers(array $form, FormStateInterface $form_state) {
    /* attached libraries*/
    $ajax_response = new AjaxResponse();
    $id = $form_state->getValue('id');
    $name = $form_state->getValue('name');
    $characters = $this->validateCharacters($name);


    if ($characters) {
      $names_databases = $this->getNames($name);
      if ($names_databases) {
        $ajax_response->addCommand(new HtmlCommand("#nameUser", 'The user ' . $names_databases . ' already exists'));
      } else {
        $values = [
          'nombre' => $name,
        ];
        \Drupal::database()->insert('myusers')->fields($values)->execute();
        $ajax_response->addCommand(new HtmlCommand("#nameUser", ""));
        $ajax_response->addCommand(new InvokeCommand(NULL, 'myModal'));
      }
    } else {
      $ajax_response->addCommand(new HtmlCommand("#nameUser", "The name must have more than 5 letters"));
    }

    return $ajax_response;
  }


  public function validateCharacters($name) {
    $correct = true;

    if (strlen($name) < 5) {
      $correct = false;
    }
    return $correct;
  }

  public function getNames($name) {
    $name_user = "";
    $query = \Drupal::database()->select('myusers', 'u');
    $query->fields('u');
    $query->condition('u.nombre', $name);
    $result = $query->execute()->fetchAll();

    if ($result) {
      $name_user = $result[0]->nombre;
    }

    return $name_user;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }


}
