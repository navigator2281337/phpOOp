<?php


class TagAttributes
{

    private $attributes = [];

    function set(string $key, $value) {
        $this->attributes[$key] = $value;
    }

    function get(string $key) {
        return $this->attributes[$key] ?? null;
    }

    function prepend(string $key, $value) {
    $this->$key = $value . $this->$key;
}

    function append(string $key, $value) {
        $this->$key .= $value;
    }

    function __get($name)
    {
        return $this->get($name);
    }

    function __set($name, $value)
    {
        $this->set($name, $value);
    }

    function keys() {
        return array_keys($this->attributes);
    }

    function __toString(): string
    {
        $result = '';

        foreach ( $this->keys() as $key )
            $result .= " $key=\"{$this->$key}\"";

        return $result;
    }

}
