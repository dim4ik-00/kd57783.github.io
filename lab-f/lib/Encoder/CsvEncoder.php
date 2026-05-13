<?php

namespace App\Encoder;

use App\EncoderInterface;

class CsvEncoder implements EncoderInterface
{
    protected string $separator = ",";

    public function supports(string $format): bool
    {
        return $format === 'csv';
    }

    public function decode(string $data): array
    {
        $lines = array_filter(explode("\n", trim($data)));

        $headers = str_getcsv(
            array_shift($lines),
            $this->separator,
            '"',
            '\\'
        );

        $result = [];

        foreach ($lines as $line) {

            $values = str_getcsv(
                $line,
                $this->separator,
                '"',
                '\\'
            );

            $result[] = array_combine($headers, $values);
        }

        return $result;
    }

    public function encode(array $data): string
    {
        if (empty($data)) {
            return '';
        }

        $output = '';

        $headers = array_keys($data[0]);

        $output .= implode($this->separator, $headers) . "\n";

        foreach ($data as $row) {

            $output .= implode($this->separator, $row) . "\n";
        }

        return $output;
    }
}