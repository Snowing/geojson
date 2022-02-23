<?php

namespace GeoJson\CoordinateReferenceSystem;

use GeoJson\Exception\UnserializationException;
use GeoJson\JsonUnserializable;

/**
 * Coordinate reference system object.
 *
 * @see http://www.geojson.org/geojson-spec.html#coordinate-reference-system-objects
 * @since 1.0
 */
abstract class CoordinateReferenceSystem implements \JsonSerializable, JsonUnserializable
{
    protected array $properties = [];

    protected string $type;

    /**
     * Return the properties for this CRS object.
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Return the type for this CRS object.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): mixed
    {
        return [
            'type'       => $this->type,
            'properties' => $this->properties,
        ];
    }

    final public static function jsonUnserialize(mixed $json): mixed
    {
        if (!is_array($json) && !is_object($json)) {
            throw UnserializationException::invalidValue('CRS', $json, 'array or object');
        }

        $json = new \ArrayObject($json);

        if (!$json->offsetExists('type')) {
            throw UnserializationException::missingProperty('CRS', 'type', 'string');
        }

        if (!$json->offsetExists('properties')) {
            throw UnserializationException::missingProperty('CRS', 'properties', 'array or object');
        }

        $type       = (string)$json['type'];
        $properties = $json['properties'];

        switch ($type) {
            case 'link':
                return Linked::jsonUnserializeFromProperties($properties);

            case 'name':
                return Named::jsonUnserializeFromProperties($properties);
        }

        throw UnserializationException::unsupportedType('CRS', $type);
    }

    /**
     * Factory method for creating a CRS object from properties.
     *
     * This method must be overridden in a child class.
     *
     * @param  array|object  $properties
     * @return CoordinateReferenceSystem
     * @throws \BadMethodCallException
     * @see CoordinateReferenceSystem::jsonUnserialize()
     */
    protected static function jsonUnserializeFromProperties($properties)
    {
        throw new \BadMethodCallException(sprintf('%s must be overridden in a child class', __METHOD__));
    }
}
