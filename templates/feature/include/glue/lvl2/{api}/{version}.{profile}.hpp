<?php require_once 'cpphelper.php' ?>
#ifndef LVL2_<?= $name ?>_<?= strtoupper($profile) ?>_HPP
#define LVL2_<?= $name ?>_<?= strtoupper($profile) ?>_HPP

#include "../../lvl1/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp"

namespace glue::lvl2
{
	inline namespace <?= strtolower($name) ?>_<?= $profile ?> 
	{
		struct Interface: glue::<?= strtolower($name) ?>_<?= $profile ?>::Interface
		{
<?php
	foreach($protos as $_key => $_proto)
	{
		//if (preg_match($_key)
	}
?>
			Interface(const Interface&) = default;
			Interface& operator = (const Interface&) = default;
			Interface() = default;
		public:
		};
	}
}

#endif