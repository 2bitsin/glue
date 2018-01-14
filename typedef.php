<?php

	function add_type_definition(&$target, $name, $alias, $requires)
	{
		$target[$name] = ['name' => $name, 'alias' => $alias, 'requires' => $requires];
	}

	function generate_types_table()
	{
		$G_types_table = [];
		add_type_definition($G_types_table, 'GLeglClientBufferEXT', null,												['{types.hpp}']);
		add_type_definition($G_types_table, 'GLeglImageEOS', 				null,												['{types.hpp}']);
		add_type_definition($G_types_table, 'GLenum', 							'std::uint32_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLboolean', 						'std::uint8_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLbitfield', 					'std::uint32_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLbyte', 							'std::int8_t', 							['<cstdint>']);
		add_type_definition($G_types_table, 'GLshort', 							'std::int16_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLint', 								'std::int32_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLubyte', 							'std::uint8_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLushort', 						'std::uint16_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLuint',	 							'std::uint32_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLsizei', 							'std::int32_t', 						['<cstdint>']);
		add_type_definition($G_types_table, 'GLfloat', 							'float32_t', 								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLclampf', 						'float32_t', 								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLdouble', 						'float64_t', 								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLclampd', 						'float64_t', 								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLchar', 							'char',											[]);
		add_type_definition($G_types_table, 'GLcharARB',  					'char',											[]);
		add_type_definition($G_types_table, 'GLhandleARB', 					null,												['{types.hpp}']);
		add_type_definition($G_types_table, 'GLhalf', 							'float16_t',								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLhalfARB', 						'float16_t',								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLhalfNV', 						'float16_t',								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLfixed', 							'std::int32_t',							['<cstdint>']);
		add_type_definition($G_types_table, 'GLintptr', 						'std::ptrdiff_t',						['<cstddef>']);
		add_type_definition($G_types_table, 'GLsizeiptr', 					'std::ptrdiff_t',						['<cstddef>']);
		add_type_definition($G_types_table, 'GLint64', 							'std::int64_t',							['<cstdint>']);
		add_type_definition($G_types_table, 'GLuint64', 						'std::uint64_t',						['<cstdint>']);
		add_type_definition($G_types_table, 'GLintptrARB', 					'std::ptrdiff_t',						['<cstddef>']);
		add_type_definition($G_types_table, 'GLsizeiptrARB',				'std::ptrdiff_t',						['<cstddef>']);
		add_type_definition($G_types_table, 'GLint64ARB', 					'std::int64_t',							['<cstdint>']);
		add_type_definition($G_types_table, 'GLuint64ARB',					'std::uint64_t',						['<cstdint>']);
		add_type_definition($G_types_table, 'GLsync', 							null,												['{types.hpp}']);
		add_type_definition($G_types_table, 'struct _cl_context', 	'_cl_context',							['{types.hpp}']);
		add_type_definition($G_types_table, 'struct _cl_event', 		'_cl_event',								['{types.hpp}']);
		add_type_definition($G_types_table, 'GLDEBUGPROC', 					'debug_proc_t',							['{types.hpp}']);
		add_type_definition($G_types_table, 'GLDEBUGPROCARB', 			'debug_proc_t',							['{types.hpp}']);
		add_type_definition($G_types_table, 'GLDEBUGPROCKHR', 			'debug_proc_t',							['{types.hpp}']);
		add_type_definition($G_types_table, 'GLDEBUGPROCAMD', 			'amd_debug_proc_t', 				['{types.hpp}']);
		add_type_definition($G_types_table, 'GLVULKANPROCNV', 			'nv_vulkan_proc_t',					['{types.hpp}']);
		add_type_definition($G_types_table, 'GLvdpauSurfaceNV', 		null, 											['{types.hpp}']);
		add_type_definition($G_types_table, 'GLvoid',								'void',											[]);
		//add_type_definition($G_types_table, '', '',	[]);
		return $G_types_table;
	}