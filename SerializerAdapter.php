<?php

namespace ArturDoruch\SimpleRestBundle;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;

/**
 * A wrapper for JMS\Serializer.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class SerializerAdapter
{
    /**
     * @var Serializer
     */
    private static $serializer;

    /**
     * @param Serializer $serializer
     */
    public static function setSerializer(Serializer $serializer)
    {
        self::$serializer = $serializer;
    }

    /**
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        if (!self::$serializer) {
            throw new \LogicException('To serialize or normalize data install the "jms/serializer-bundle" composer package.');
        }

        return self::$serializer;
    }

    /**
     * Serializes data into JSON format.
     *
     * @param mixed $data
     * @param SerializationContext $context
     * @param string $format
     *
     * @return string
     */
    public static function serialize($data, SerializationContext $context = null, string $format = 'json'): string
    {
        if (!$context) {
            $context = self::createSerializationContext();
        }

        return self::getSerializer()->serialize($data, $format, $context);
    }

    /**
     * Converts object into array.
     *
     * @param object $object
     * @param SerializationContext|null $context
     *
     * @return array
     */
    public static function normalize($object, SerializationContext $context = null): array
    {
        if (!$context) {
            $context = self::createSerializationContext();
        }

        return self::getSerializer()->toArray($object, $context);
    }


    private static function createSerializationContext()
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        $context->enableMaxDepthChecks();

        return $context;
    }
}
