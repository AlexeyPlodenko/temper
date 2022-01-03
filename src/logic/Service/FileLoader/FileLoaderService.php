<?php

namespace App\Service\FileLoader;

use App\Exception\Service\FileLoader\FileNotExistsException;
use App\Exception\Service\FileLoader\FileReadPermissionsViolationException;
use App\Service\AbstractService;

class FileLoaderService extends AbstractService
{
    /**
     * @var string
     */
    protected string $data;

    /**
     * @param string $filePath
     */
    public function __construct(protected string $filePath)
    {
    }

    /**
     * @return string
     * @throws FileNotExistsException
     * @throws FileReadPermissionsViolationException
     */
    public function readFile(): string
    {
        if (!isset($this->data)) {
            $this->validateFilePath();

            $this->data = $this->load();
        }

        return $this->data;
    }

    /**
     * @return string
     */
    protected function load(): string
    {
        return file_get_contents($this->filePath);
    }

    /**
     * @return void
     * @throws FileNotExistsException
     * @throws FileReadPermissionsViolationException
     */
    protected function validateFilePath(): void
    {
        // @TODO SECURITY: Ensure that the file path is inside the web root dir.
        $fileExists = is_file($this->filePath);
        if (!$fileExists) {
            throw new FileNotExistsException();
        }

        $filePermissionsOk = is_readable($this->filePath);
        if (!$filePermissionsOk) {
            throw new FileReadPermissionsViolationException();
        }
    }
}
