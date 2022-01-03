<?php

namespace App\Model;

class ResponseModel extends AbstractModel
{
    /**
     * @var int
     */
    protected int $code = 200;

    /**
     * @param int|null $code
     * @return int|void
     */
    public function code(int $code = null)
    {
        if (!$code) {
            return $this->code;
        }

        assert($code >= 100 & $code < 600);
        $this->code = $code;
    }

    public function send()
    {
        http_response_code($this->code);
    }

//    /**
//     * @param string $name
//     * @param mixed $default
//     * @return mixed
//     */
//    public function input(string $name, $default = null)
//    {
//        return $_REQUEST[$name] ?? $default;
//    }
}
