<?php require_once 'cpphelper.php' ?>
#ifndef <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#include "../../function.hpp"
#include "../../types.hpp"
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
			Interface(const Interface&) = default;
			Interface& operator = (const Interface&) = default;
			Interface() = default;
		public:
		};
		void load(Interface&, std::function<void*(const char*)>);
	}
}

#endif