<?php
	require_once 'template.php';
	require_once 'registry.php';

	system("rm -rf build");

	$url_ogl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/gl.xml";
	$url_glx = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/glx.xml";
	$url_wgl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/wgl.xml";

	$registry = new Registry($url_ogl);
	//$feature_template = new Template("./templates/feature");
	//foreach ($registry->features as $feature)
	//	$feature_template->instantiate($feature, "./build");
	foreach($registry->features as $feat)
	{
		printf("%21s : %20s / protos(%5d) / enums(%5d) / types(%5d)\n", $feat['name'], $feat['profile'], count($feat['protos']), count($feat['enums']), count($feat['types']));
	}
?>