<?php

namespace GeoJson\CoordinateReferenceSystem;

use GeoJson\Exception\UnserializationException;

/**
 * Named coordinate reference system object.
 *
 * @see http://www.geojson.org/geojson-spec.html#named-crs
 * @since 1.0
 */
class Named extends CoordinateReferenceSystem
{
    protected string $type = 'name';

    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        $this->properties = ['name' => $name];
    }

    /**
     * Factory method for creating a Named CRS object from properties.
     *
     * @param  array|object  $properties
     * @return Named
     * @throws UnserializationException
     * @see CoordinateReferenceSystem::jsonUnserialize()
     */
    protected static function jsonUnserializeFromProperties($properties)
    {
        if (!is_array($properties) && !is_object($properties)) {
            throw UnserializationException::invalidProperty('Named CRS', 'properties', $properties, 'array or object');
        }

        $properties = new \ArrayObject($properties);

        if (!$properties->offsetExists('name')) {
            throw UnserializationException::missingProperty('Named CRS', 'properties.name', 'string');
        }

        $name = (string)$properties['name'];

        return new self($name);
    }
}
