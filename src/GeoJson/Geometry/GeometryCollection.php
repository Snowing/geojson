<?php

namespace GeoJson\Geometry;

/**
 * Collection of Geometry objects.
 *
 * @see http://www.geojson.org/geojson-spec.html#geometry-collection
 * @since 1.0
 */
class GeometryCollection extends Geometry implements \Countable, \IteratorAggregate
{
    protected string $type = 'GeometryCollection';

    protected array $geometries = [];

    /**
     * Constructor.
     *
     * @param  Geometry[]  $geometries
     * @param  CoordinateResolutionSystem|BoundingBox  $arg,...
     */
    public function __construct(array $geometries)
    {
        foreach ($geometries as $geometry) {
            if (!$geometry instanceof Geometry) {
                throw new \InvalidArgumentException('GeometryCollection may only contain Geometry objects');
            }
        }

        $this->geometries = array_values($geometries);

        if (func_num_args() > 1) {
            $this->setOptionalConstructorArgs(array_slice(func_get_args(), 1));
        }
    }

    /**
     * @see http://php.net/manual/en/countable.count.php
     */
    public function count(): int
    {
        return count($this->geometries);
    }

    /**
     * Return the Geometry objects in this collection.
     *
     * @return Geometry[]
     */
    public function getGeometries(): array
    {
        return $this->geometries;
    }

    /**
     * @see http://php.net/manual/en/iteratoraggregate.getiterator.php
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->geometries);
    }

    /**
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): mixed
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'geometries' => array_map(
                    function (Geometry $geometry) {
                        return $geometry->jsonSerialize();
                    },
                    $this->geometries
                )
            ]
        );
    }
}
