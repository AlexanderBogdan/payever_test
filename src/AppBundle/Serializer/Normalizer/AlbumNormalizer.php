<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Album;
use AppBundle\Entity\Image;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;


class AlbumNormalizer extends SerializerAwareNormalizer implements NormalizerInterface {
  /**
   * Normalizes an object into a set of arrays/scalars.
   *
   * @param object $object object to normalize
   * @param string $format format the normalization result will be encoded as
   * @param array $context Context options for the normalizer
   *
   * @return array|string|bool|int|float|null
   */
  public function normalize($object, $format = NULL, array $context = array()) {

    $collection = $object->getImages();
    $start = 0;
    $length = 10;
    if (!empty($context['pager'])) {
      $start = ($context['pager']['current'] - 1) * $length;
    }
    $images = $collection->slice($start, $length);

    return [
      'id'     => $object->getId(),
      'title'   => $object->getTitle(),
      'description' => $object->getDescription(),
      'images' => array_map(
        function (Image $image) use ($format, $context) {

            return $this->serializer->normalize($image, $format, $context);
        },
        $images
      )
    ];

  }

  /**
   * Checks whether the given class is supported for normalization by this normalizer.
   *
   * @param mixed $data Data to normalize.
   * @param string $format The format being (de-)serialized from or into.
   *
   * @return bool
   */
  public function supportsNormalization($data, $format = NULL) {
    return $data instanceof Album;
  }
}