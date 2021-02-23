<?php

namespace App\Message\Messenger;

use App\Message\Serializer\Serializer;
use Symfony\Component\Messenger\Bridge\Redis\Transport\Connection;
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisTransport;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class Transport extends RedisTransport
{
    /**
     * Transport constructor.
     * @param Connection|null $connection
     * @param SerializerInterface|null $serializer
     */
    public function __construct(Connection $connection = null, SerializerInterface $serializer = null)
    {
        parent::__construct(
            $connection ?? $this->getConnection(),
            $serializer ?? $this->getSerializer()
        );
    }

    /**
     * @return Connection
     */
    private function getConnection(): Connection
    {
        return Connection::fromDsn(
            $_ENV['REDIS_DSN'] ?? 'localhost:6379',
            [
                'stream' => $_ENV['REDIS_STREAM'] ?? 'default',
                'group' => $_ENV['REDIS_GROUP'] ?? 'default',
                'consumer' => $_ENV['REDIS_CONSUMER'] ?? 'default',
            ]
        );
    }

    /**
     * @return SerializerInterface
     */
    private function getSerializer(): SerializerInterface
    {
        return new Serializer;
    }
}