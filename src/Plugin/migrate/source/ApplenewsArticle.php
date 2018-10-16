<?php

namespace Drupal\applenews\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Applenews Article source plugin.
 *
 * @MigrateSource(
 *   id = "d7_applenews_article",
 *   source_module = "applenews",
 * )
 */
class ApplenewsArticle extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('applenews_entities', 'ae')
      ->fields('ae')
      ->fields('aes', ['data'])
      ->fields('n', ['type']);
    $query->innerJoin('applenews_entity_settings', 'aes', 'ae.entity_type = aes.entity_type AND ae.entity_id = aes.entity_id AND ae.revision_id = aes.revision_id');
    $query->innerJoin('node', 'n', 'n.nid = ae.entity_id');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Deserialize the data field and compose the links field.
    $data = unserialize($row->getSourceProperty('data'));
    $links = [
      'channel' => $data['channels'][0],
      'sections' => $data['sections'],
      'self' => 'https://news-api.apple.com/articles/' . $row->getSourceProperty('article_id'),
    ];
    $row->setSourceProperty('links', serialize($links));

    // Convert postdate into a datetime.
    $created_at = gmdate('Y-m-d\TH:i:s\Z', $row->getSourceProperty('postdate'));
    $row->setSourceProperty('postdate', $created_at);

    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'post_id' => $this->t('The post identifier'),
      'entity_type' => $this->t('The entity type'),
      'entity_id' => $this->t('The entity identifer'),
      'revision_id' => $this->t('The entity revision'),
      'exid' => $this->t('The {applenews_status}.id of the export used'),
      'article_id' => $this->t('Apple News article ID'),
      'article_revision_id' => $this->t('Apple News article revision ID'),
      'share_url' => $this->t('Apple News Share URL'),
      'postdate' => $this->t('Post date timestamp'),
      'data' => $this->t('Apple News settings for this entity'),
      'type' => $this->t('The entity bundle'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['post_id'] = [
      'type' => 'integer',
      'alias' => 'ae',
    ];
    return $ids;
  }

}
