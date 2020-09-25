<?php

namespace Drupal\azure_storage;

/**
 * Class AzureStorage.
 *
 * @package Drupal\azure_storage
 */
final class AzureStorage {

  /**
   * Gets the Azure Storage Account key value.
   *
   * @param null $key_id
   *   Optional custom key module key id.
   *
   * @return string|null
   *   The key value if found or NULL.
   */
  public static function getAccountKey($key_id = NULL) {
    if ($key_id === NULL) {
      $key_id = \Drupal::config('azure_storage.settings')->get('account_key');
    }
    if ($key_id) {
      /** @var \Drupal\key\KeyRepositoryInterface $key_repository */
      $key_repository = \Drupal::service('key.repository');
      $key_entity = $key_repository->getKey($key_id);
      if ($key_entity) {
        return $key_entity->getKeyValue();
      }
    }
    return NULL;
  }

}
