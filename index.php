<?php
	$url_ogl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/gl.xml";
	$url_glx = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/glx.xml";
	$url_wgl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/wgl.xml";

	require_once 'template.php';
	require_once 'registry.php';

	$build_dir =  "./build";
	system("rm -rf ${build_dir}");

	$registry = new Registry($url_ogl);

	$common_template = new Template("./templates/common");
	$common_template->instantiate((array)$registry, $build_dir);

	$feature_template = new Template("./templates/feature");
	foreach ($registry->features as $feature)
	{
		extract($feature, EXTR_OVERWRITE);
		$_args = compact('registry', 'feature', 'api', 'profile', 'version');
		$feature_template->instantiate($_args, $build_dir);
	}
?>