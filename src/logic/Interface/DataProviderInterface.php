<?php

namespace App\Interface;

interface DataProviderInterface extends AbstractInterface
{
    /**
     * @return array
     */
    public function getAll(): array;
}
