<?php

namespace Phpobic;

class Storage {
    protected $storage;
    public function __set($key,$value){
        $this->storage[$key]=$value;
    }
    public function __get($key){
        if(isset($this->storage[$key])){
            return $this->storage[$key];
        }
        return null;
    }
    public function __isset($key){
        if(isset($this->storage[$key])){
            return true;
        }
        return false;
    }
    public function __unset($key){
        unset($this->storage[$key]);
    }
}