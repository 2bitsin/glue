#include <glue/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp>
#include "../common/strings.hpp"

namespace glue
{
	namespace 
	{
		template <typename T, typename P>
		void assign(T& target, P fptr)
		{ target = (T)fptr; }
	}
	inline namespace <?= strtolower($name) ?>_<?= $profile ?> 
 	{
		void load(Interface& target, std::function<void*(const char*)> lfn)
		{
<?php 
	foreach($protos as $_proto):
		$this->instantiate_fragment('assign_statement', compact('registry', 'G_typedefs', '_proto'));
	endforeach;
?>
		}
 	}
}