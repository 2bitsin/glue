<?php
	$G_unform_defs =
	[
		['type' => 'float32_t'		 , 'suffix' => '1f',  'pass' => 'value'],
		['type' => 'std::int32_t'	 , 'suffix' => '1i',  'pass' => 'value'],
		['type' => 'std::uint32_t' , 'suffix' => '1ui', 'pass' => 'value'],
		['type' => 'const vec2&'	 , 'suffix' => '2f',  'pass' => 'value.x, value.y'],
		['type' => 'const ivec2&'  , 'suffix' => '2i',  'pass' => 'value.x, value.y'],
		['type' => 'const uvec2&'  , 'suffix' => '2ui', 'pass' => 'value.x, value.y'],
		['type' => 'const vec3&'	 , 'suffix' => '3f',  'pass' => 'value.x, value.y, value.z'],
		['type' => 'const ivec3&'  , 'suffix' => '3i',  'pass' => 'value.x, value.y, value.z'],
		['type' => 'const uvec3&'  , 'suffix' => '3ui', 'pass' => 'value.x, value.y, value.z'],
		['type' => 'const vec4&'	 , 'suffix' => '4f',  'pass' => 'value.x, value.y, value.z, value.w'],
		['type' => 'const ivec4&'  , 'suffix' => '4i',  'pass' => 'value.x, value.y, value.z, value.w'],
		['type' => 'const uvec4&'  , 'suffix' => '4ui', 'pass' => 'value.x, value.y, value.z, value.w']
	];
	if (!isset($what))
		$what = 'decl';
	foreach($G_unform_defs as $_args)
	{
		extract($_args, EXTR_OVERWRITE);
		$api = 'glUniform' . $suffix;
		if (!isset($protos[$api]))
			continue;
		$this->instantiate_fragment('uniform_api_vector_' . $what, $_args);
	}
	foreach($G_unform_defs as $_args)
	{
		extract($_args, EXTR_OVERWRITE);
		$api = 'glProgramUniform' . $suffix;
		if (!isset($protos[$api]))
			continue;
		$this->instantiate_fragment('uniform_api_dsa_vector_' . $what, $_args);
	}