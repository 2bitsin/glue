<?php require_once 'cpphelper.php' ?>
#ifndef <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#include "../function.hpp"
#include "../types.hpp"

namespace glue
{
	inline namespace <?= strtolower($name) ?>_<?= $profile ?> 
	{
		struct Interface
		{
<?php
	foreach($protos as $_proto):
		printf("\t\t\t\tfunction<%s(%s)> %s = nullptr;\n",
			CppHelper::rewrite_type($G_typedefs, $_proto['full_type']),
			CppHelper::build_argument_types($G_typedefs, $_proto),
			CppHelper::camel_skip_prefix($_proto['name'])
		);
	endforeach;
?>
		public:
			Interface() {}
		};
	}
}

#endif