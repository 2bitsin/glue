<?php

	class CppHelper
	{

		public static function camel_skip_prefix($text)
		{
			$text = Template::camel_case_split($text);
			array_shift($text);
			return implode('', $text);
		}

		public static function build_arguments($_typedefs, $_proto)
		{
			$_output = [];
			foreach($_proto['arguments'] as $_arg)
			{
				$_full_type = CppHelper::rewrite_type($_typedefs, $_arg['full_type']);
				$_output[] = sprintf('%s %s', $_full_type, $_arg['name']);
			}
			return implode($_output, ', ');
		}

		public static function build_argument_types($_typedefs, $_proto)
		{
			$_output = [];
			foreach($_proto['arg_types'] as $_arg)
				$_output[] = CppHelper::rewrite_type($_typedefs, $_arg);
			return implode($_output, ', ');
		}

		public static function rewrite_type($_typedefs, $_full_type)
		{
			$_replace = function ($value) use ($_typedefs)
			{
				if (!isset ($_typedefs[$value[0]])
					||!isset ($_typedefs[$value[0]]['alias']))
					return $value[0];
				return $_typedefs[$value[0]]['alias'];
			};
			return preg_replace_callback('/GL\w+/', $_replace, $_full_type);
		}

		public static function the_namespace($args)
		{
			extract($args, EXTR_OVERWRITE);
			return $profile . '_' . str_replace('.', '_', $version);
		}

		protected static function find_pointer_arg($arguments)
		{
			$i = 0;
			foreach($arguments as $arg)
			{
				if ($arg['is_pointer'])
					return $i;
				++$i;
			}
			return -1;
		}

		const OP_VECTOR_OR_SCALAR_ARRAY = 0;
		const OP_MATRIX_ARRAY = 1;

		protected static function modernize_vector_call($proto)
		{
		}

		public static function modernize($proto)
		{
			$name = $proto['name'];
			$parts = Template::camel_case_split($name);
			array_shift($parts);
			$last =	array_slice($parts, -1)[0];

			$arguments = $proto['arguments'];
			$ptr_index = CppHelper::find_pointer_arg($arguments);

			if ($ptr_index >= 0)
			{
				if (preg_match('/^Matrix((\d)(x(\d))?)(u?i|f|d|u?b|u?s)v$/i', $last, $m))
					return CppHelper::modernize_vector_call($proto, $ptr_index, $m);

			}
		}

	};
