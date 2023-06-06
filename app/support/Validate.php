<?php

namespace app\support;

use app\traits\Validations;
use Exception;

class Validate
{
    use Validations;

    private array $inputsValidation = [];

    public function validate(array $validationFields)
    {
        foreach ($validationFields as $field => $validation) {
            $havePipes = str_contains($validation, '|');
            if (!$havePipes) {
                [$validation, $param] = $this->getParam($validation);
                $this->validationExists($validation);

                $this->inputsValidation[$field] = $this->$validation($field, $param);
            }

            if ($havePipes) {
                $validations = explode('|', $validation);
                foreach ($validations as $validation) {
                    [$validation, $param] = $this->getParam($validation);
                    $this->validationExists($validation);

                    $this->inputsValidation[$field] = $this->$validation($field, $param);

                    if ($this->inputsValidation[$field] === null) {
                        break;
                    }
                }
            }
        }

        return $this->returnValidation($this->inputsValidation, $field);
    }

    private function getParam(string $validation, string $param = '')
    {
        if (str_contains($validation, ':')) {
            [$validation, $param] = explode(':', $validation);
        }
        return [$validation, $param];
    }

    private function validationExists(string $validation): void
    {
        if (!method_exists($this, $validation)) {
            throw new Exception("Invalid validation {$validation}");
        }
    }

    private function returnValidation(array $inputsValidation): array|null
    {
        Csrf::validateToken();

        if (in_array(null, $inputsValidation, true)) {
            return null;
        }

        return $inputsValidation;
    }
}
