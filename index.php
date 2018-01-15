<?php
	$url_ogl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/gl.xml";
	$url_glx = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/glx.xml";
	$url_wgl = "https://raw.githubusercontent.com/KhronosGroup/OpenGL-Registry/master/xml/wgl.xml";

	require_once 'template.php';
	require_once 'registry.php';
	require_once 'typedef.php';

	$build_dir =  "./build";
	system("rm -rf ${build_dir}");

	$registry = new Registry($url_ogl);

	$G_typedefs = generate_types_table();
	$common_template = new Template("./templates/common");
	$common_template->instantiate($build_dir, (array)$registry, compact('G_typedefs'));

	$feature_template = new Template("./templates/feature");
	foreach ($registry->features as $_feature)
		$feature_template->instantiate ($build_dir, (array)$registry, compact('G_typedefs'), $_feature);
?>