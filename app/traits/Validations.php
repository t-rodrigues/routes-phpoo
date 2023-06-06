<?php

namespace app\traits;

use app\core\Request;
use app\support\Flash;

trait Validations
{
    public function unique(string $field, string $param): string|null
    {
        $data = Request::input($field);
        $model = new $param;
        $model->setFields('id');
        $registerFound = $model->findBy($field, $data);

        if ($registerFound) {
            Flash::set($field, "O valor {$data} já está registrado");
            return null;
        }
        return strip_tags($data);
    }

    public function email(string $field): string|null
    {
        if (!filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL)) {
            Flash::set($field, "E-mail fornecido não é válido");
            return null;
        }
        return strip_tags(Request::input($field));
    }

    public function required(string $field): string|null
    {
        $data = Request::input($field);

        if (empty($data)) {
            Flash::set($field, "Esse campo é obrigatório");
            return null;
        }
        return strip_tags($data, '<p><b><span><em><ul>');
    }

    public function minLen(string $field, int $size): string|null
    {
        $data = Request::input($field);

        if (mb_strlen($data) < $size) {
            Flash::set($field, "Esse campo deve ter no mínimo {$size} caracteres");
            return null;
        }
        return strip_tags($data, '<p><b><span><em><ul>');
    }
}
