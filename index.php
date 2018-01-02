<?php
	require_once 'template.php';

	$url_ogl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/gl.xml";
	$url_glx = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/glx.xml";
	$url_wgl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/wgl.xml";

	class Registry
	{
		function __construct($url)
		{
			$root = new SimpleXMLElement(file_get_contents($url));
			$this->features = [];
			foreach ($root->xpath('/registry/feature') as $feature_node)
			{

			}
		}

		public $features;
	}

	system("rm -rf build");

	$registry = new Registry($url_ogl);
	$feature_template = new Template("./templates/feature");
	foreach ($registry->features as $feature)
		$feature_template->instantiate($feature, "./build");
	print_r($registry);
?>