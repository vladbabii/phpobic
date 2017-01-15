<?php

namespace Phpobic;

class Factory
{
  protected $uid;
  protected $registry;
  protected $alias;

  public function __construct($options=array()){
    $this->registry=array();
    $this->uid='factory.'.uniqid();
  }

  public function uid(){
    return $this->uid;
  }

  public function alias($name,$class=null){
    if(is_null($class)){
      unset($this->alias[$name]);
    }
    $this->alias[$name]=$class;
  }

  public function &create($class,$options=array()){
    $alias=null;
    $namespace=null;
    if (isset($this->alias[$class])){
      $alias=$class;
      $class=$this->alias[$alias];
    }

    if (!class_exists($class)) {
      throw new Exception('no such class '.$class);
    }
    if(stripos($class,'\\')!==false){
      $namespace=trim($class,'\\');
      $pos=strrpos($namespace,'\\');
      if($pos!==false){
        $class=substr($namespace,$pos+1);
        $namespace=substr($namespace,0,$pos);
      }
    }
    if($namespace==null){
      $reflection = new \ReflectionClass($class);
    }else{
      $reflection = new \ReflectionClass('\\'.$namespace.'\\'.$class);
    }
    if (!isset($options['constructor'])) {
      $options['constructor']=null;
    }
    if (!is_null($options['constructor'])) {
      $object = $reflection->newInstance($options['constructor']);
    } else {
      $object = $reflection->newInstance();
    }
    $this->eventAfter($object);

    $no=array('class'=>$class);
    if(!is_null($alias)){ $no['alias']=$alias; }

    if(method_exists($object,'uid')){
      $this->registryNotify($object,$no);
    }
    return $object;
  }

  protected function eventAfter(&$object){ }

  public function addRegistry(&$registry,$options=array()){
    if (method_exists($registry,'uid')){
      $id=$registry->uid();
      $this->registry[$id]=&$registry;
    }else{
      $this->registry[]=&$registry;
    }
  }

  protected function registryNotify(&$object,$options=array()){
    foreach($this->registry as $ruid=>&$registry){
      if(method_exists($registry,'register')){
        $registry->register($object,$options);
      }
    }
  }

}
