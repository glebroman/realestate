<?php



/**
 * Description of Paginator
 *
 * @author Breeze
 */
class Paginator {
    
    protected static $_config = null;
    protected static $_defaultItemCountPerPage = 5;
    protected $_stmt = null;
    protected $_table = null;
    protected $_select = null;
    protected $_where = null;
    protected $_currentItems = null;
    protected $_currentPageNumber = 1;
    protected $_itemCountPerPage = null;
    protected $_pageCount = null;
    protected $_pages = null;
    protected $_view = null;
    
    public function __construct($table, $where=null) {
	$this->_table = $table;
	$this->_where = $this->getWhere($where);
	$this->_select = 'select * from "' . $this->_table . '" as t where 1=1 ' . $this->_where;
	$this->_stmt = $this->getSmtp();	
    }

    public static function getDefaultItemCountPerPage() {
	return self::$_defaultItemCountPerPage;
    }
    
    private function getWhere($where) {
	if ($where) {
	    $this->_where = $where;
	}
	return $this->_where;
    }

    public function getSmtp() {
	$db = Registry::getInstance()->db;
	return sqlsrv_query($db, $this->_select, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
    }

    public static function setDefaultItemCountPerPage($count) {
	self::$_defaultItemCountPerPage = (int) $count;
    }

    private function getItemsTotalCount() {
	return sqlsrv_num_rows($this->_stmt);
    }

    public function getItemCountPerPage() {
	if (empty($this->_itemCountPerPage)) {
	    $this->_itemCountPerPage = self::getDefaultItemCountPerPage();
	}

	return $this->_itemCountPerPage;
    }

    public function setItemCountPerPage($itemCountPerPage) {
	$this->_itemCountPerPage = (integer) $itemCountPerPage;
	if ($this->_itemCountPerPage < 1) {
	    $this->_itemCountPerPage = $this->getItemCountPerPage();
	}
	$this->_pageCount = $this->_calculatePageCount();
	$this->_currentItems = null;
	$this->_currentItemCount = null;

	return $this;
    }

    protected function _calculatePageCount() {
	$pageCount = (integer) ceil($this->getItemsTotalCount() / $this->getItemCountPerPage());
	return $pageCount > 1 ? $pageCount : 1;
    }

    public function count()
    {
        if (!$this->_pageCount) {
            $this->_pageCount = $this->_calculatePageCount();
        }

        return $this->_pageCount;
    }
    public function setCurrentPageNumber($pageNumber)
    {
        $this->_currentPageNumber = (integer) $pageNumber;
        $this->_currentItems      = null;
        $this->_currentItemCount  = null;

        return $this;
    }
    
    public function getPages() {
        if ($this->_pages === null) {
            $this->_pages = $this->_createPages();
        }
        return $this->_pages;
    }

    public function getCurrentPageNumber() {
	$pageNumber = ( $this->_currentPageNumber<1 ) ? 1 : $this->_currentPageNumber;
	$pageCount = $this->count();
	$pageNumber = $pageNumber > $pageCount ? $pageCount : $pageNumber;
        return $pageNumber;
    }

    public function getCurrentItems()
    {
        if ($this->_currentItems === null) {
            $this->_currentItems = $this->getItemsByPage($this->getCurrentPageNumber());
        }
        return $this->_currentItems;
    }

    public function getItemsByPage($pageNumber) {
	
	$db = Registry::getInstance()->db;
	$items = array();
	$start = ($pageNumber - 1) * $this->getItemCountPerPage() + 1;
	$length = $this->getItemCountPerPage();
	$end = $start + $length - 1;
	
	$select = 'select * from (select ROW_NUMBER() OVER (ORDER BY "Line No_") AS rownum, * from "' . $this->_table . '") as t where t.rownum BETWEEN ' . $start . ' AND ' . $end . $this->_where . ' order by Date desc';
	$result = sqlsrv_query($db, $select);
	if ($result) {
	    while ($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {
	       $items[] = new Model_Messages($row); 
	    }
	}
	return $items;
    }
    
    private function getURL() {
	$site = Registry::getInstance()->url;
	$controller = Registry::getInstance()->router->getController();
	$action = Registry::getInstance()->router->getAction();
	return $site . '/'. $controller . '/'. $action;
    }

    protected function _createPages($scrollingStyle = null) {
        $pageCount         = $this->count();
        $currentPageNumber = $this->getCurrentPageNumber();

        $pages = new stdClass();
        $pages->pageCount        = $pageCount;
        $pages->itemCountPerPage = $this->getItemCountPerPage();
        $pages->first            = 1;
        $pages->current          = $currentPageNumber;
        $pages->last             = $pageCount;
	$pages->url		 = $this->getURL();

        if ($currentPageNumber - 1 > 0) {
            $pages->previous = $currentPageNumber - 1;
        }

        if ($currentPageNumber + 1 <= $pageCount) {
            $pages->next = $currentPageNumber + 1;
        }

	$this->getCurrentItems();
        return $pages;
    }
}

?>
