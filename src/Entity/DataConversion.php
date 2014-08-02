<?php


namespace Todo\Entity;


trait DataConversion
{
    public function toArray()
    {
        $properties = get_class_vars(__CLASS__);
        $array = array();

        foreach ($properties as $prop => $null) {
            $method = 'get' . ucfirst($prop);
            if (method_exists($this, $method)) {
                $array[$prop] = $this->$method();
            }
        }

        return $array;
    }

    public function fromArray($array)
    {
        foreach ($array as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function fromJson($json)
    {
        $array = json_decode($json, true);
        $this->fromArray($array);
    }
}
