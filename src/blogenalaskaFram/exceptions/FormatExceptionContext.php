<?php

namespace blog\exceptions;

/**
 * Description of FormatExceptionContext
 *
 * @author constancelaloux
 */
final class FormatExceptionContext
{
    private $data;
    private $path;
    private $lineno;
    private $cursor;
    public function __construct(string $data, string $path, int $lineno, int $cursor)
    {
        $this->data = $data;
        $this->path = $path;
        $this->lineno = $lineno;
        $this->cursor = $cursor;
    }
    public function getPath(): string
    {
        return $this->path;
    }
    public function getLineno(): int
    {
        return $this->lineno;
    }
    public function getDetails(): string
    {
        $before = str_replace("\n", '\n', substr($this->data, max(0, $this->cursor - 20), min(20, $this->cursor)));
        $after = str_replace("\n", '\n', substr($this->data, $this->cursor, 20));
        return '...'.$before.$after."...\n".str_repeat(' ', \strlen($before) + 2).'^ line '.$this->lineno.' offset '.$this->cursor;
    }
}

