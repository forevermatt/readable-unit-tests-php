<?php
namespace ReadableUnitTests;

class TestFile
{
    /**
     * @param string $path
     * @throws MissingTestFileException
     */
    protected static function assertTestFileExists(string $path)
    {
        if (! file_exists($path)) {
            throw new MissingTestFileException(sprintf(
                'Missing file "%s"',
                $path
            ));
        }
    }
}
