<?php

namespace Drupal\azure_storage;

use Drupal\Core\Config\ConfigFactoryInterface;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Queue\QueueRestProxy;
use Psr\Log\LoggerInterface;

/**
 * Class AzureStorageClient.
 *
 * @package Drupal\azure_storage
 */
class AzureStorageClient implements AzureStorageClientInterface {

  /**
   * The Azure Storage settings.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Logger service.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * Azure Queue client.
   *
   * @var \MicrosoftAzure\Storage\Queue\Internal\IQueue
   */
  protected $queueClient;

  /**
   * AzureStorageClient constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   A configuration factory instance.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   */
  public function __construct(ConfigFactoryInterface $config_factory, LoggerInterface $logger) {
    $this->config = $config_factory->get('azure_storage.settings');
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public function setStorageQueue($connection_string = NULL) {
    if ($connection_string === NULL) {
      $protocol = $this->config->get('protocol');
      $account_name = $this->config->get('account_name');
      $account_key = AzureStorage::getAccountKey();
      $endpoint_suffix = $this->config->get('endpoint_suffix');
      $connection_string = "DefaultEndpointsProtocol=$protocol;AccountName=$account_name;AccountKey=$account_key;EndpointSuffix=$endpoint_suffix";
    }
    $this->queueClient = QueueRestProxy::createQueueService($connection_string);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function addMessageToQueue($queue_name, $message) {
    try {
      $this->queueClient->createMessage($queue_name, $message);
    }
    catch (ServiceException $e) {
      $this->logger->error($e->getMessage());
      return FALSE;
    }
    return TRUE;
  }

}
