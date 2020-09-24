<?php

namespace Drupal\azure_storage;

/**
 * Interface AzureStorageClientInterface.
 *
 * @package Drupal\azure_storage
 */
interface AzureStorageClientInterface {

  /**
   * Set a storage queue.
   *
   * When no connection string is given, one will be looked up from config.
   *
   * @param $connection_string
   *  Optional Azure connection string.
   *
   * @return $this
   *  AzureClient.
   */
  public function setStorageQueue($connection_string = NULL);

  /**
   * Adds a message to the queue.
   *
   * @param $queue_name
   *   Azure Storage Queue name.
   * @param $message
   *   Message.
   *
   * @return $this
   *  AzureClient.
   */
  function addMessageToQueue($queue_name, $message);

}
