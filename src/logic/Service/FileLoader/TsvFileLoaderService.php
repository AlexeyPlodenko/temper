<?php

namespace App\Service\FileLoader;

use App\Exception\Service\FileLoader\FileNotExistsException;
use App\Exception\Service\FileLoader\FileReadPermissionsViolationException;
use App\Exception\Service\FileLoader\UnsupportedFileExtensionException;
use App\Interface\DataProviderInterface;

class TsvFileLoaderService extends FileLoaderService implements DataProviderInterface
{
    /**
     * @var array
     */
    protected array $dataArray;

    /**
     * @return array
     * @throws FileNotExistsException
     * @throws FileReadPermissionsViolationException
     */
    public function getAll(): array
    {
        if (!isset($this->dataArray)) {
            $this->readFile();

            $this->dataArray = [];

            // It is better to use fgetcsv() in the production code, but I am lazy :P
            // Also in the production code need to ensure that we are not reading large files in one piece...
            // ...and also prevent the same file duplicate reads with the readFile() and getAll() methods.

            $rowTitles = [];
            $rows = explode("\n", $this->data);
            foreach ($rows as $i => $row) {
                // removing leftover "\r"
                $row = rtrim($row, "\r");

                if ($i === 0) {
                    $rowTitles = explode("\t", $row);
                    continue;
                }

                if (!$row) {
                    // skip empty rows
                    continue;
                }

                $rowData = explode("\t", $row);
                $this->dataArray[] = array_combine($rowTitles, $rowData);
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
        if (!preg_match('/\.tsv$/i', $this->filePath)) {
            throw new UnsupportedFileExtensionException();
        }

        parent::validateFilePath();
    }
}
