<?php

/**
 * @file
 * Hooks provided by the Apple News module.
 */

/**
 * Registers your Apple News classes and defines defaults.
 *
 * @return array
 *   An associative array with the following keys:
 *   - api (required): Always 1 for any module implementing the Apple News 1
 *     API.
 *   - exports: Associative array of exports defined by this module, keyed on
 *     export machine name (matching /^[a-zA-Z0-9-_]$/), with keys:
 *     -  class (required): Class name to instantiate for the export.
 *     -  arguments: Array of arguments to pass to class constructor.
 *     -  name
 *     -  description
 *
 * @see hook_apple_news_api_alter()
 */
function hook_apple_news_api() {
  return [
    'api' => 1,
    'exports' => [
      'article' => [
        'class' => 'AppleNewsExportArticle',
        'arguments' => [],
        'name' => t('Articles'),
        'description' => t('Export articles as defined by default install profile.'),
      ],
    ],
  ];
}

/**
 * Alter information from all implementations of hook_apple_news_api().
 *
 * @param array $info
 *   An array of results from hook_apple_news_api(), keyed by module name.
 *
 * @see hook_apple_news_api()
 */
function hook_apple_news_api_alter(array &$info) {
  // Override the class for another module's migration - say, to add some
  // additional preprocessing in prepareRow().
  if (isset($info['MODULE_NAME']['key'])) {
    $info['MODULE_NAME']['key'] = 'new value';
  }
}

/**
 * Invoke Apple News insert operation hooks.
 *
 * @param string $article_id
 *   Apple News article ID.
 * @param string $article_revision_id
 *   Apple News article revision ID.
 * @param string $channel_id
 *   Apple News channel ID.
 * @param object $entity_wrapper
 *   Entity wrapper object.
 *   @see entity_metadata_wrapper()
 * @param string $entity_type
 *   Entity type.
 * @param array $data
 *   An array of article assets, used in insert and update operations.
 *
 * @see apple_news_op()
 */
function hook_apple_news_insert($article_id, $article_revision_id, $channel_id, $entity_wrapper, $entity_type, array $data) {
}

/**
 * Invoke Apple News update operation hooks.
 *
 * @param string $article_id
 *   Apple News article ID.
 * @param string $article_revision_id
 *   Apple News article revision ID.
 * @param string $channel_id
 *   Apple News channel ID.
 * @param object $entity_wrapper
 *   Entity wrapper object.
 *   @see entity_metadata_wrapper()
 * @param string $entity_type
 *   Entity type.
 * @param array $data
 *   An array of article assets, used in insert and update operations.
 *
 * @see apple_news_op()
 */
function hook_apple_news_update($article_id, $article_revision_id, $channel_id, $entity_wrapper, $entity_type, array $data) {
}

/**
 * Invoke Apple News delete operation hooks.
 *
 * @param string $article_id
 *   Apple News article ID.
 * @param string $channel_id
 *   Apple News channel ID.
 * @param object $entity_wrapper
 *   Entity wrapper object.
 *   @see entity_metadata_wrapper()
 * @param string $entity_type
 *   Entity type.
 *
 * @see apple_news_op()
 */
function hook_apple_news_delete($article_id, $channel_id, $entity_wrapper, $entity_type) {
}
