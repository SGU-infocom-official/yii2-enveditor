<?php namespace sguinfocom\enveditor\helpers;

use sguinfocom\enveditor\interfaces\DotenvFormatter as DotenvFormatterInterface;
use sguinfocom\enveditor\interfaces\DotenvWriter as DotenvWriterInterface;
use sguinfocom\enveditor\exceptions\UnableWriteToFileException;

/**
 * The DotenvWriter writer.
 *
 * @package app\components\dotenveditor
 * @author Jackie Do <anhvudo@gmail.com>
 */
class DotenvWriter implements DotenvWriterInterface
{

    protected $buffer;


    protected $formatter;


    public function __construct(DotenvFormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }


    protected function ensureFileIsWritable($filePath)
    {
        if ((is_file((string) $filePath) && !is_writable((string) $filePath)) || (!is_file((string) $filePath) && !is_writable(dirname((string) $filePath)))) {
            throw new UnableWriteToFileException(sprintf('Unable to write to the file at %s.', $filePath));
        }
    }


    #[\Override]
    public function setBuffer($content)
    {
        $this->buffer = $content;
        return $this;
    }


    #[\Override]
    public function getBuffer()
    {
        return $this->buffer;
    }


    protected function appendLine($text = null)
    {
        $this->buffer .= $text . PHP_EOL;
        return $this;
    }


    #[\Override]
    public function appendEmptyLine()
    {
        return $this->appendLine();
    }


    #[\Override]
    public function appendCommentLine($comment)
    {
        return $this->appendLine('# ' . $comment);
    }


    #[\Override]
    public function appendSetter($key, $value = null, $comment = null, $export = false)
    {
        $line = $this->formatter->formatSetterLine($key, $value, $comment, $export);

        return $this->appendLine($line);
    }


    #[\Override]
    public function updateSetter($key, $value = null, $comment = null, $export = false)
    {
        $pattern = "/^(export\h)?\h*{$key}=.*/m";
        $line = $this->formatter->formatSetterLine($key, $value, $comment, $export);
        $this->buffer = preg_replace($pattern, $line, $this->buffer);

        return $this;
    }


    #[\Override]
    public function deleteSetter($key)
    {
        $pattern = "/^(export\h)?\h*{$key}=.*\n/m";
        $this->buffer = preg_replace($pattern, '', $this->buffer);

        return $this;
    }


    #[\Override]
    public function save($filePath)
    {
        $this->ensureFileIsWritable($filePath);
        file_put_contents($filePath, $this->buffer);

        return $this;
    }
}
