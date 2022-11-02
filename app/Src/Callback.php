<?php

namespace App\Src;

class Callback
{
    private $json;

    public function httpStatus($code): Callback
    {
        $this->json['code'] = (int)$code;
        return $this;
    }

    public function success($data = null): string
    {
        $this->checkHttpStatus(200);
        $this->json['data'] = $data;
        return $this->toJson();
    }

    public function error($errors = null): string
    {
        $this->checkHttpStatus(400);
        if (isset($this->json['data'])) {
            unset($this->json['data']);
        }
        $this->json['data']['errors'] = !empty($errors) ? $errors : [
            (!empty($this->json['message']) ? $this->json['message'] : 'Unspecified error')
        ];
        return $this->toJson();
    }

    public function add(string $param, $value = ''): Callback
    {
        $this->json[$param] = $value;
        return $this;
    }


    //
    // PRIVATES
    //

    private function toJson()
    {
        return json_encode($this->json);
    }

    private function checkHttpStatus($default)
    {
        if (empty($this->json['code'])) {
            $this->json['code'] = $default;
        }
    }

    private function response(?string $message = null): Callback
    {
        $this->json['message'] = $message;
        return $this;
    }

    //
    // MAGICS
    //

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'response':
                return $this->response(...$arguments);
                break;
        }
    }

    public static function __callStatic($name, $arguments)
    {
        switch ($name) {
            case 'response':
                return (new Callback())->response(...$arguments);
                break;
        }
    }

    public function __toString(): string
    {
        return json_encode($this->json);
    }
}
