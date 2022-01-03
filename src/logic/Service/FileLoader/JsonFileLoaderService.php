<?php

namespace App\Service\FileLoader;

use App\Exception\Service\FileLoader\FileNotExistsException;
use App\Exception\Service\FileLoader\FileReadPermissionsViolationException;
use App\Exception\Service\FileLoader\UnsupportedFileExtensionException;
use App\Exception\Service\FileLoader\UnsupportedFileStructureException;
use App\Interface\DataProviderInterface;
use JsonException;

class JsonFileLoaderService extends FileLoaderService implements DataProviderInterface
{
    /**
     * @var array
     */
    protected array $dataArray;

    /**
     * @return array
     * @throws FileNotExistsException
     * @throws FileReadPermissionsViolationException
     * @throws UnsupportedFileStructureException
     */
    public function getAll(): array
    {
        if (!isset($this->dataArray)) {
            $this->readFile();

            try {
                $this->dataArray = json_decode(json: $this->data, associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException $ex) {
                // casting a generic JSON exception to our known exception
                throw new UnsupportedFileStructureException($ex->getMessage());
            }

            unset($this->data);
        }

        return $this->dataArray;
    }

    /**
     * @return void
     * @throws UnsupportedFileExtensionException
     * @throws FileNotExistsException
     * @throws FileReadPermissionsViolationException
     */
    protected function validateFilePath(): void
    {
        if (!preg_match('/\.json$/i', $this->filePath)) {
            throw new UnsupportedFileExtensionException();
        }

        parent::validateFilePath();
    }
}
