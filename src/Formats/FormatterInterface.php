<?php


namespace Hogus\Tencent\Tim\Formats;


interface FormatterInterface
{
    public function formatter(array $attributes = []): Formatter;
}
