<?php
namespace Phpobic;

trait TraitEvents {
	
	protected function eventRunAfterConstruct(){
		$list=get_class_methods($this);
		foreach($list as $index=>$name){
			if(substr($name,0,strlen('eventAfterConstruct'))=='eventAfterConstruct'){
				$this->{$name}();
			}
		}
	}

}