<?php

namespace App\Message;

/**
 * Class Message
 * @package App\Message
 */
class MessageRedis
{
    private array $data;

    /**
     * Message constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}