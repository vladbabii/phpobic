<?php

namespace Phpobic;

class Registry
{
  protected $uid;
  protected $data;

  public function __construct($options=array()){
    $this->uid='registry.'.uniqid();
    $this->data=array();
  }

  public function uid(){
    return $this->uid;
  }

  public function register(&$object,$options=array()){
    $this->data[$object->uid()]=$object;
  }

  public function &reference($id){
    if(isset($this->data[$id])){
      return $this->data[$id];
    }
    throw new Exception();
  }

}
