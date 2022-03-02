<?php

namespace Drupal\onlyoffice_connector\Controller;

use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\Component\Uuid\Uuid;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Returns responses for ONLYOFFICE Connector routes.
 */
class OnlyofficeDownloadController extends ControllerBase {

  /**
   * The entity repository.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   *
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   * The entity repository.
   */
  public function __construct(EntityRepositoryInterface $entity_repository) {
    $this->entityRepository = $entity_repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.repository')
    );
  }

  public function download($uuid, Request $request) {
    if (!$uuid || !Uuid::isValid($uuid)) {
      throw new BadRequestHttpException();
    }

    $media = $this->entityRepository->loadEntityByUuid('media', $uuid);

    if (!$media) {
      throw new BadRequestHttpException("The targeted media resource with UUID `{$uuid}` does not exist.");
    }

    $fid = $media->toArray()["field_media_document"][0]["target_id"];
    $file = File::load($fid);

    return new BinaryFileResponse($file->getFileUri(), 200);
  }

}
