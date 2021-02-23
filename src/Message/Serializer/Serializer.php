<?php

namespace App\Message\Serializer;

use App\Message\MessageRedis;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

class Serializer implements SerializerInterface
{
    private SymfonySerializer $symfonySerializer;

    /**
     * Serializer constructor.
     */
    public function __construct()
    {
        $this->symfonySerializer = new SymfonySerializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @inheritDoc
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        return new Envelope(
            new MessageRedis(
                $this->symfonySerializer->decode(
                    $encodedEnvelope['body'],
                    JsonEncoder::FORMAT
                )
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function encode(Envelope $envelope): array
    {
        return [
            'body' => $this->symfonySerializer->encode(
                $envelope->getMessage()->getData(),
                JsonEncoder::FORMAT
            ),
            'headers' => [],
        ];
    }
}