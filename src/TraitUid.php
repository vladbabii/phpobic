<?php
namespace Phpobic;

trait TraitUid {
  protected $uid=null;

  public function uid(){
  	return $this->uid;
  }

  protected function eventAfterConstructUid(){
  	if(is_null($this->uid)){
  		$this->uid=strtolower(get_class($this)).'.'.uniqid();
  	}
  }
}
