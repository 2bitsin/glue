#pragma once

namespace glue
{
	<?php foreach($types as $name => $type): ?> 
	<?= $type['definition'] ?> 
	<?php endforeach; ?> 

}