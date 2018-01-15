
#ifndef <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define <?= $name ?>_<?= strtoupper($profile) ?>_HPP

#include <glue/common/types.hpp>

namespace glue
{
	inline namespace <?= strtolower($name) ?>_<?= $profile ?>
	{
		struct Interface
		{
		private:
<?php
	foreach($protos as $_proto):
		printf("\t\t\tauto %s (%s) const -> %s;\n",
			Template::camel_skip_prefix($_proto['name']),
			implode($_proto['arg_types'], ', '),
			$_proto['full_type']
		);
	endforeach;
?>
		};
	}
}

#endif