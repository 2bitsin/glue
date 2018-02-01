<?php require_once 'cpphelper.php' ?>
#ifndef <?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define <?= $name ?>_<?= strtoupper($profile) ?>_HPP

#include "../lvl1/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp"

namespace glue::lvl2
{
	inline namespace <?= strtolower($name) ?>_<?= $profile ?> 
	{
		struct Interface: glue::<?= strtolower($name) ?>_<?= $profile ?>::Interface
		{
			Interface(const Interface&) = default;
			Interface& operator = (const Interface&) = default;
			Interface() = default;
		public:
		};
	}
}

#endif