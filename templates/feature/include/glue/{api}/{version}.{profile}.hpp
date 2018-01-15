<?php require_once 'cpphelper.php' ?>
#ifndef <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define <?= $name ?>_<?= strtoupper($profile) ?>_HPP

#include <glue/common/types.hpp>

namespace glue
{
	inline namespace <?= strtolower($name) ?>_<?= $profile ?> 
	{
		struct Interface
		{
<?php
	foreach($protos as $_proto):
		printf("\t\t\tdetail::fptr_t<%s(%s)> %s;\n",
			CppHelper::rewrite_type($G_typedefs, $_proto['full_type']),
			CppHelper::build_arguments($G_typedefs, $_proto),
			CppHelper::camel_skip_prefix($_proto['name'])
		);
	endforeach;
?>
		};
	}
}

#endif