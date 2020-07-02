<?php

require_once 'TagName.php';
require_once 'TagAttributes.php';

class Tag
{

    private $name;
    private $attributes;
    private $body;

    public function __construct(string $name)
    {
        $this->name = new TagName($name);
        $this->attributes = new TagAttributes();
    }

    //region NAME METHODS
    public function name()
    {
        return $this->name;
    }

    function isSelfClosing() {
        return $this->name()->isSelfClosing();
    }
    //endregion

    //region BODY METHODS
    public function getBody()
    {
        if ( $this->isSelfClosing() )
            return '';

        return $this->body;
    }

    private function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    function appendBody($value) {
        return $this->setBody( $this->getBody() . $value );
    }

    function prependBody($value) {
        return $this->setBody( $value . $this->getBody() );
    }
    //endregion

    //region ATTRIBUTES METHODS
    function attributes() {
        return $this->attributes;
    }

    function setAttribute(string $key, $value) {
        $this->attributes()->$key = $value;
        return $this;
    }

    function getAttribute(string $key) {
        return $this->attributes()->$key ?? null;
    }

    function appendAttribute(string $key, $value) {
        $this->attributes()->append($key, $value);
        return $this;
    }

    function prependAttribute(string $key, $value) {
        $this->attributes()->prepend($key, $value);
        return $this;
    }
    //endregion

    //region GENERATING METHODS
    function start(): string {

        $str = "<{$this->name()}{$this->attributes()}";

        if ( $this->isSelfClosing() )
            $str .= " /";

        return "$str>";
    }

    function end(): string {

        if ( $this->isSelfClosing() )
            return '';

        return "</{$this->name()}>";
    }

    function classExists(string $className): bool{
        return strpos($this->attributes->get("class"), $className);
    }
    
    function addClass(string $className){
        if(!$this->classExists($className)){
            if($this->attributes->get("class") != null)
                $this->attributes->append("class", ' ' . $className);
            else
                $this->attributes->append("class", $className);
        }
    }

    function removeClass($className){
        if(($this->attributes->get("class") != null) && $this->classExists($className)){
            $this->attributes->set("class",
                str_replace($className, "", $this->attributes->get("class")));
            if($this->attributes->get("class")[0] == ' ')
            {
                $this->attributes->set("class",
                    substr(
                        $this->attributes->get("class"),
                        2,
                        strlen($this->attributes->get("class"))
                    ));
            }
            else if($this->attributes->get("class")[strlen($this->attributes->get("class")) - 1] == ' ')
                $this->attributes->set("class",
                    substr(
                        $this->attributes->get("class"),
                        0,
                        strlen($this->attributes->get("class")) - 1));
        }
    }

    function __toString(): string {
        return $this->start() . $this->getBody() . $this->end();
    }

    function __get($name)
    {
        return $this->getAttribute($name);
    }

    function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }
    //endregion

}
