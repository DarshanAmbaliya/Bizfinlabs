<?php

namespace Drupal\general_api\Plugin\rest\resource;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Html;

/**
 * Provides Program REST API.
 *
 * @RestResource(
 *   id = "program_rest_resource",
 *   label = @Translation("Program REST Resource"),
 *   uri_paths = {
 *     "canonical" = "/api/programs"
 *   }
 * )
 */
class ProgramRestResource extends ResourceBase
{

  protected $entityTypeManager;
  protected $requestStack;
  protected $fileUrlGenerator;

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    $logger,
    EntityTypeManagerInterface $entity_type_manager,
    $request_stack,
    FileUrlGeneratorInterface $file_url_generator
  ) {
    parent::__construct(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $serializer_formats,
      $logger
    );

    $this->entityTypeManager = $entity_type_manager;
    $this->requestStack = $request_stack;
    $this->fileUrlGenerator = $file_url_generator;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('general_api'),
      $container->get('entity_type.manager'),
      $container->get('request_stack'),
      $container->get('file_url_generator')
    );
  }
  protected function formatHtmlField($node, $field_name)
  {
    if ($node->hasField($field_name) && !$node->get($field_name)->isEmpty()) {
      return $node->get($field_name)->processed;
    }

    return '';
  }
  /**
   * GET /api/programs
   */
  public function get(Request $request)
  {

    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'program');
    $query->condition('status', 1);
    $query->sort('created', 'DESC');
    $query->accessCheck(TRUE);

    $nids = $query->execute();

    $nodes = $this->entityTypeManager
      ->getStorage('node')
      ->loadMultiple($nids);

    $data = [];

    foreach ($nodes as $node) {

      // Default image URL
      $image_url = NULL;

      if (!$node->get('field_media')->isEmpty()) {
        $media = $node->get('field_media')->entity;

        if ($media && $media->hasField('field_media_image') && !$media->get('field_media_image')->isEmpty()) {
          $file = $media->get('field_media_image')->entity;

          if ($file) {
            $image_url = $this->fileUrlGenerator->generateAbsoluteString($file->getFileUri());
          }
        }
      }

      // Schedule (date range)
      $schedule = NULL;
      if (!$node->get('field_schedule')->isEmpty()) {
        $schedule = [
          'start' => $node->get('field_schedule')->value,
          'end' => $node->get('field_schedule')->end_value,
        ];
      }

      if (isset($build['body'][0]['#text'])) {
        $body = $build['body'][0]['#text'];
      }
      $data[] = [
        'id' => $node->id(),
        'title' => $node->label(),
        'body' => $this->formatHtmlField($node, 'body'),
        'short_description' => $node->get('field_short_description')->value ?? NULL,

        'category' => !$node->get('field_category')->isEmpty()
          ? $node->get('field_category')->entity->label()
          : NULL,

        'class_size' => $node->get('field_class_size')->value ?? NULL,
        'level' => $node->get('field_level')->value ?? NULL,
        'location' => $node->get('field_location')->value ?? NULL,
        'price' => $node->get('field_price')->value ?? NULL,
        'sessions' => $node->get('field_sessions')->value ?? NULL,
        'session_time' => $node->get('field_session_time')->value ?? NULL,

        'schedule' => $schedule,
        'image' => $image_url,
      ];
    }

    return new ResourceResponse($data);
  }
}
