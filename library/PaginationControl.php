<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaginationControl
 *
 * @author Admin
 */
class PaginationControl {
    
    private $template;
    private $paginator;
    private $pages;
    public $items;


    public function __construct(Paginator $paginator = null, $template = null) {
	$this->template = $template;
	$this->pages = $paginator->getPages();
	$this->items = $paginator->getCurrentItems();
	$this->paginator = $paginator;
    }
    
    public function render() {
	ob_start();
        include (APPLICATION_PATH . 'views/' . $this->template);
        $content = ob_get_clean();
	return $content;
    }
}

?>
