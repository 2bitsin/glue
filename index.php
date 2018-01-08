<?php
	require_once 'template.php';
	require_once 'registry.php';

	system("rm -rf build");

	$url_ogl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/gl.xml";
	$url_glx = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/glx.xml";
	$url_wgl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/wgl.xml";

	$build_dir =  "./build";

	$registry = new Registry($url_ogl);

	$common_template = new Template("./templates/common");
	foreach ($registry->types as $api => $types)
	{
		$common_template->instantiate(compact('types', 'api', 'registry'), $build_dir);
	}

	$feature_template = new Template("./templates/feature");
	foreach ($registry->features as $feature)
	{
		$api = $feature['api'];
		$profile = $feature['profile'];
		$version = $feature['version'];
		$d = compact('registry', 'feature', 'api', 'profile', 'version');
		$feature_template->instantiate($d, $build_dir);
	}
?>