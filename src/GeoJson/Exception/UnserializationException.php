<?php

namespace GeoJson\Exception;

class UnserializationException extends \RuntimeException implements Exception
{
    /**
     * Creates an UnserializationException for a value with an invalid type.
     *
     * @return UnserializationException
     */
    public static function invalidValue(string $context, mixed $value, string $expectedType)
    {
        return new self(
            sprintf(
                '%s expected value of type %s, %s given',
                $context,
                $expectedType,
                is_object($value) ? get_class($value) : gettype($value)
            )
        );
    }

    /**
     * Creates an UnserializationException for a property with an invalid type.
     *
     *
     * @return UnserializationException
     */
    public static function invalidProperty(string $context, string $property, mixed $value, string $expectedType)
    {
        return new self(
            sprintf(
                '%s expected "%s" property of type %s, %s given',
                $context,
                $property,
                $expectedType,
                is_object($value) ? get_class($value) : gettype($value)
            )
        );
    }

    /**
     * Creates an UnserializationException for a missing property.
     *
     * @return UnserializationException
     */
    public static function missingProperty(string $context, string $property, string $expectedType)
    {
        return new self(
            sprintf(
                '%s expected "%s" property of type %s, none given',
                $context,
                $property,
                $expectedType
            )
        );
    }

    /**
     * Creates an UnserializationException for an unsupported "type" property.
     *
     * @return UnserializationException
     */
    public static function unsupportedType(string $context, string $value)
    {
        return new self(sprintf('Invalid %s type "%s"', $context, $value));
    }
}
