<?php

namespace GeoJson\CoordinateReferenceSystem;

use GeoJson\Exception\UnserializationException;

/**
 * Linked coordinate reference system object.
 *
 * @see http://www.geojson.org/geojson-spec.html#linked-crs
 * @since 1.0
 */
class Linked extends CoordinateReferenceSystem
{
    protected string $type = 'link';

    /**
     * Constructor.
     */
    public function __construct(string $href, ?string $type = null)
    {
        $this->properties = ['href' => $href];

        if ($type) {
            $this->properties['type'] = $type;
        }
    }

    /**
     * Factory method for creating a Linked CRS object from properties.
     *
     * @param  array|object  $properties
     * @return Linked
     * @throws UnserializationException
     * @see CoordinateReferenceSystem::jsonUnserialize()
     */
    protected static function jsonUnserializeFromProperties($properties)
    {
        if (!is_array($properties) && !is_object($properties)) {
            throw UnserializationException::invalidProperty('Linked CRS', 'properties', $properties, 'array or object');
        }

        $properties = new \ArrayObject($properties);

        if (!$properties->offsetExists('href')) {
            throw UnserializationException::missingProperty('Linked CRS', 'properties.href', 'string');
        }

        $href = (string)$properties['href'];
        $type = isset($properties['type']) ? (string)$properties['type'] : null;

        return new self($href, $type);
    }
}
