<?php

/**
 * Present latest winners
 */
class WTagAdd extends CWidget
{
    public $tags = null;
    
    public function run()
	{
        $tags = array();
        if ($this->tags) foreach ($this->tags as $tag){ 
            $tags[] = $tag->name;
        }        
        $this->render('tag_add', array('tags' => implode(';', $tags)));
	}
}
