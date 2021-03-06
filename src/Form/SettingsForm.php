<?php

namespace Drupal\azure_storage\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'azure_storage.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('azure_storage.settings');

    $form['protocol'] = [
      '#type' => 'select',
      '#title' => $this->t('Default Endpoints Protocol'),
      '#description' => $this->t('Default endpoints protocol to use.'),
      '#default_value' => $config->get('protocol'),
      '#options' => [
        'http' => $this->t('Http'),
        'https' => $this->t('Https'),
      ],
      '#required' => TRUE,
    ];

    $form['account_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Account Name'),
      '#description' => $this->t('The Account Name for Azure Storage'),
      '#default_value' => $config->get('account_name'),
      '#required' => TRUE,
    ];

    $form['account_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Account Key'),
      '#description' => $this->t('The Account Key for Azure Storage'),
      '#default_value' => $config->get('account_key'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('azure_storage.settings')
      ->set('protocol', $form_state->getValue('protocol'))
      ->set('account_name', $form_state->getValue('account_name'))
      ->set('account_key', $form_state->getValue('account_key'))
      ->save();
  }

}
