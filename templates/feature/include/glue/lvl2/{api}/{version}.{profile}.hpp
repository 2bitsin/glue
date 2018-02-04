<?php require_once 'cpphelper.php' ?>
#ifndef LVL2_<?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define LVL2_<?= $name ?>_<?= strtoupper($profile) ?>_HPP

#include "../../lvl1/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp"
#include "../../math.hpp"

namespace glue::lvl2
{
	inline namespace <?= CppHelper::the_namespace($feature) ?> 
	{
		struct api: glue::<?= CppHelper::the_namespace($feature) ?>::api
		{
			api(const api&) = default;
			api& operator = (const api&) = default;
			api() = default;
		public:
		};
	}
}

#endif