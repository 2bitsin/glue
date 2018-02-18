#include <glue/lvl1/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp>
#include <glue/lvl2/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp>
#include "../../common/strings.hpp"
#include <glue/math.hpp>

namespace glue::lvl2
{
	inline namespace <?= CppHelper::the_namespace($feature) ?> 
	{
<?php
	//$this->instantiate_fragment('uniform_api', compact('protos'), ['what'=>'defn']);
?>
	}
}