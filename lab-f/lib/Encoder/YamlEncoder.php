<?php

namespace App\Encoder;

use App\EncoderInterface;

class YamlEncoder implements EncoderInterface
{
    public function supports(string $format): bool
    {
        return $format === 'yaml';
    }

    public function decode(string $data): array
    {
        $lines = array_filter(explode("\n", trim($data)));

        $result = [];

        foreach ($lines as $line) {

            $parts = explode(':', $line, 2);

            if (count($parts) === 2) {

                $key = trim($parts[0]);
                $value = trim($parts[1]);

                $result[] = [
                    'key' => $key,
                    'value' => $value
                ];
            }
        }

        return $result;
    }

    public function encode(array $data): string
    {
        $output = '';

        foreach ($data as $row) {

            foreach ($row as $key => $value) {

                $output .= "$key: $value\n";
            }
        }

        return $output;
    }
}