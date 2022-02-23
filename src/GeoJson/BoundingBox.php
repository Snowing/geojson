<?php

namespace GeoJson;

use GeoJson\Exception\UnserializationException;

/**
 * BoundingBox object.
 *
 * @see http://www.geojson.org/geojson-spec.html#bounding-boxes
 * @since 1.0
 */
class BoundingBox implements \JsonSerializable, JsonUnserializable
{
    protected array $bounds;

    /**
     * Constructor.
     *
     * @param  float[]  $bounds
     */
    public function __construct(array $bounds)
    {
        $count = count($bounds);

        if ($count < 4) {
            throw new \InvalidArgumentException('BoundingBox requires at least four values');
        }

        if ($count % 2) {
            throw new \InvalidArgumentException('BoundingBox requires an even number of values');
        }

        foreach ($bounds as $value) {
            if (!is_int($value) && !is_float($value)) {
                throw new \InvalidArgumentException('BoundingBox values must be integers or floats');
            }
        }

        for ($i = 0; $i < ($count / 2); $i++) {
            if ($bounds[$i] > $bounds[$i + ($count / 2)]) {
                throw new \InvalidArgumentException('BoundingBox min values must precede max values');
            }
        }

        $this->bounds = $bounds;
    }

    /**
     * Return the bounds for this BoundingBox object.
     *
     * @return float[]
     */
    public function getBounds()
    {
        return $this->bounds;
    }

    /**
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        return $this->bounds;
    }

    final public static function jsonUnserialize(mixed $json): mixed
    {
        if (!is_array($json)) {
            throw UnserializationException::invalidValue('BoundingBox', $json, 'array');
        }

        return new self($json);
    }
}
