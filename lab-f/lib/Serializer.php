<?php

namespace App;

class Serializer
{
    private array $encoders = [];

    public function __construct(array $encoders)
    {
        $this->encoders = $encoders;
    }

    private function getEncoder(string $format): EncoderInterface
    {
        foreach ($this->encoders as $encoder) {

            if ($encoder->supports($format)) {
                return $encoder;
            }
        }

        throw new \Exception("Unsupported format");
    }

    public function convert(
        string $input,
        string $inputFormat,
        string $outputFormat
    ): string {

        $decoder = $this->getEncoder($inputFormat);
        $encoder = $this->getEncoder($outputFormat);

        $array = $decoder->decode($input);

        return $encoder->encode($array);
    }
}