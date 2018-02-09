<?php require_once 'cpphelper.php' ?>
#ifndef LVL1_<?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define LVL1_<?= $name ?>_<?= strtoupper($profile) ?>_HPP
#include "../../function.hpp"
#include "../../types.hpp"
#include <functional>

namespace glue::lvl1
{
	inline namespace <?= CppHelper::the_namespace($feature) ?> 
	{
		struct api
		{
			/* 	=============
					constants
					============= */
		public:
<?php
	foreach($enums as $name => $_enum):
		$this->instantiate_fragment('member_constant', compact('name', '_enum'));
	endforeach;
?>
			/*	=============
					functions
					============= */
		public:
<?php
	foreach($protos as $_proto):
		$this->instantiate_fragment('member_function_pointer', compact('G_typedefs', '_proto'));
	endforeach;
?>
		public:
			api(const api&) = default;
			api& operator = (const api&) = default;
			api() = default;
		public:
		};
		void load(api&, std::function<void*(const char*)>);
	}
}

#endif