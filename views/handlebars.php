<?php
require_once dirname(dirname(__FILE__)) . DS . 'vendors' . DS . 'autoload.php';

class HandlebarsView extends View {
	
	/**
	 * Script mime type for HBS
	 * @var string
	 */
	const MIMETYPE = 'text/x-handlebars-template';
	
	/**
	 * undocumented variable
	 *
	 * @var \Handlebars\Handlebars
	 * @access private
	 */
	private $__Handlebars;
	
	/**
	 * Supported Extensions
	 *
	 * @var array
	 * @access private
	 */
	private $__extensions = array(
		'.hbs', 
		'.handlebars', 
	);
	
	
	/**
	 * Supported Extensions
	 *
	 * @var array
	 * @access private
	 */
	private $__renderSwitchParam = 'template';
	
	/**
	 * Constructor
	 *
	 * @param Controller $controller A controller object to pull View::__passedArgs from.
	 * @param boolean $register Should the View instance be registered in the ClassRegistry
	 * @return View
	 */
	function __construct(&$controller, $register = true) {
		$this->__Handlebars = new \Handlebars\Handlebars();
		parent::__construct($controller, $register);
	}
	
	/**
	 * Renders and returns output for given view filename with its array of data.
	 * Will only use Handlebars if the viewFn has a valid extension.
	 *
	 * @see HandlebarsView::$__extensions 
	 * @param string $___viewFn Filename of the view
	 * @param array $___dataForView Data to include in rendered view
	 * @param boolean $loadHelpers Boolean to indicate that helpers should be loaded.
	 * @param boolean $cached Whether or not to trigger the creation of a cache file.
	 * @return string Rendered output
	 * @access protected
	 */
	function _render($___viewFn, $___dataForView, $loadHelpers = true, $cached = false) {
		$ext = array_pop(explode('.', $___viewFn));
		if (in_array('.'.$ext, $this->__extensions)) {
			$template = file_get_contents($___viewFn);
			$templateId = $this->_filePathToId($___viewFn);
			$this->addScript($templateId, $this->templateTag($templateId, $template));
			return $this->__Handlebars->render($template, $___dataForView);
		}
		return parent::_render($___viewFn, $___dataForView, $loadHelpers, $cached);
	}
	
	/**
	 * Get the extensions that view files can use.
	 *
	 * @return array Array of extensions view files use.
	 * @access protected
	 */
	function _getExtensions() {
		$exts = $this->__extensions;
		array_push($exts, '.ctp');
		return $exts;
	}
	
	/**
	 * Convert full template filepath to a dom-id. 
	 * It will use the parent folder and filename to create 
	 * a dashed string, without extension
	 *
	 * Examples:
	 *  - layouts-default
	 *  - elements-post_item
	 *  - posts-edit
	 *
	 * @param string $___viewFn 
	 * @return string
	 * @access protected
	 */
	function _filePathToId($___viewFn) {
		
		$ext = '.'.array_pop(explode('.', $___viewFn));
		$path = explode(DS, $___viewFn);
		
		$templatePath = array_slice($path, count($path)-2, 2);
		$templateId = str_replace($ext, '', join('-', $templatePath));
		
		return $templateId;
	}
	
	/**
	 * Build handlebars template script tag 
	 *
	 * @param string $id DOM ID
	 * @param string $template Content
	 * @return string <script/>
	 */
	function templateTag($id, $template) {
		return '<script type="'.self::MIMETYPE.'" id="'.$id.'">'.$template.'</script>';
	}
	
}