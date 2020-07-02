<?php


class TagName
{

    private $name;

    private const SELF_CLOSING_TAGS = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param',
        'source', 'track', 'wbr', 'command', 'keygen', 'menuitem'
    ];

    public function __construct(string $name)
    {
        $this->set($name);
    }

    public function set(string $name) {
        $this->name = $name;
    }

    public function get(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->get();
    }

    function isSelfClosing() {
        return in_array( $this->get(), self::SELF_CLOSING_TAGS );
    }

}
