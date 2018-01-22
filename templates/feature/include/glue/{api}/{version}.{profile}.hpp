<?php require_once 'cpphelper.php' ?>
#ifndef <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#include "../function.hpp"
#include "../types.hpp"
#include <functional>

namespace glue
{
	inline namespace <?= strtolower($name) ?>_<?= $profile ?> 
	{
		struct Interface
		{
			/* 	=============
					constants
					============= */
		public:
<?php
	foreach($enums as $name => $_enum):
		printf("\t\t\tstatic constexpr auto %s = %s;\n", $name, $_enum['value'] . $_enum['type']);
	endforeach;
?>
			/*	=============
					functions
					============= */
		public:
<?php
	foreach($protos as $_proto):
		printf("\t\t\tfunction<%s(%s)> %s = nullptr;\n",
			CppHelper::rewrite_type($G_typedefs, $_proto['full_type']),
			CppHelper::build_argument_types($G_typedefs, $_proto),
			CppHelper::camel_skip_prefix($_proto['name'])
		);
	endforeach;
?>
		public:
			Interface(const Interface&) = default;
			Interface& operator = (const Interface&) = default;
			Interface() = default;
		public:
			friend void load(Interface&, std::function<void*(const char*)>);
		};
	}
}

#endif