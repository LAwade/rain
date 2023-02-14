<?php

namespace app\shared;

use Exception;

class FieldsValidator
{

    // $field = [
    //     'id_client' => ['value' => 'hello', 'type' => 'string', 'min' => 20, 'max' => 200, 'nullable' => false, 'default' => 'hello world'];
    // ];
    // $f = new Validator($field);

    private string $fieldname;
    private ?string $type = null;
    private ?int $min = 0;
    private ?int $max = 0;
    private bool $nullable = false;
    private $value;
    private $data = [];

    function __construct(array $fields = null)
    {
        if ($fields) {
            $this->fields($fields);
        }
    }

    function string(): void
    {
        $this->is_nullable($this->value);
        if (strlen($this->value) < $this->min) {
            throw new Exception("[$this->fieldname] is short, must be $this->min to $this->max caracteres!");
        }

        if ($this->max && strlen($this->value) > $this->max) {
            throw new Exception("[$this->fieldname] is long, must be $this->min to $this->max caracteres!");
        }

        $this->min = 0;
        $this->max = 0;
    }

    function int(): void
    {
        $this->is_nullable($this->value);
    }

    function password(): void
    {
        $this->string();
        $this->value = password_hash($this->value, PASSWORD_DEFAULT);
    }

    ################################################
    ##                 CONVERTION                 ##
    ################################################

    function to_object($obj)
    {
        foreach ($this->data as $k => $v) {
            $obj->$k = $v;
        }
        return $obj;
    }

    function to_array(): array{
        if(!$this->data){
            throw new Exception("Complete the fields!");
        }
        return filter_data($this->data);
    }

    ################################################
    ##                                            ##
    ################################################

    function fields($fields)
    {
        foreach ($fields as $n => $vl) {
            if (is_string($n) === false) {
                throw new Exception("The field [name] is invalid!");
            }

            $this->fieldname = $n;
            foreach ($vl as $k => $v) {
                if (array_key_exists('value', $vl) === false) {
                    throw new Exception("[$this->fieldname] the field [value] doesn't exist!");
                }
                $this->$k = $v;
            }

            if ($this->type == null) {
                throw new Exception("[$this->fieldname] the field [type] can't be null!");
            }
            call_user_func_array(array(__CLASS__, $this->type), []);
            $this->data[$this->fieldname] = $this->value;
        }
        return $this->data;
    }

    private function is_nullable($value = null)
    {
        if ($value == null && $this->nullable == false) {
            throw new Exception("[$this->fieldname] can't be null!");
        }
        return $value;
    }
}
