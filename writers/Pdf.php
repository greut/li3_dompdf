<?php

namespace li3_dompdf\writers;

class Pdf extends \lithium\core\Object
{
	protected $_classes = array(
		'view' => 'lithium\\template\\View',
		'message' => 'lithium\\g11n\\Message'
	);

	protected $_autoConfig = array('classes' => 'merge');

	/**
	 * Request data
	 */
	public $data = null;

	public function __construct(array $config = array()) {
		$defaults = array('view' => 'index');
		parent::__construct($config + $defaults);
	}

	public function render(array $options=array())
	{
		$class = get_class($this);
		$name = preg_replace('/Pdf$/', '', substr($class, strrpos($class, '\\') + 1));
		$name = strtolower($name);

		if (isset($options['data'])) {
			$this->data = $options['data'];
			unset($options['data']);
		} else {
			$this->data = $options;
			$options = array();
		}

		$data = $this->{$this->_config['view']}() ?: array();
		$data += $this->data;

		$options += array(
			'controller' => $name,
			'template' => $this->_config['view'],
			'layout' => 'default',
			'type' => 'pdf'
		);

		$view = $this->_view();
		return $view->render('all', $data, $options);
	}


	protected function _view()
	{
		$view = $this->_classes['view'];
		$message = $this->_classes['message'];

		return new $view(array(
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
				'layout' => '{:library}/views/layouts/{:layout}.{:type}.php'
			),
			'outputFilters' => $message::aliases()
		));
	}
}