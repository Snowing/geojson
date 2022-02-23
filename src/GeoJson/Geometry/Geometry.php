<?php

namespace GeoJson\Geometry;

use GeoJson\GeoJson;

/**
 * Base geometry object.
 *
 * @see http://www.geojson.org/geojson-spec.html#geometry-objects
 * @since 1.0
 */
abstract class Geometry extends GeoJson
{
    protected array $coordinates = [];

    /**
     * Return the coordinates for this Geometry object.
     */
    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): mixed
    {
        $json = parent::jsonSerialize();

        if ($this->coordinates) {
            $json['coordinates'] = $this->coordinates;
        }

        return $json;
    }
}
