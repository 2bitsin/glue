#include <glue/lvl1/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp>
#include "../../common/strings.hpp"

namespace glue
{
	namespace 
	{
		template <typename T, typename P>
		void assign(T& target, P fptr)
		{ target = (T)fptr; }
	}
	inline namespace <?= CppHelper::the_namespace($feature) ?> 
 	{
		void load(api& target, std::function<void*(const char*)> lfn)
		{
<?php 
	foreach($protos as $_proto):
		$this->instantiate_fragment('assign_statement', compact('registry', 'G_typedefs', '_proto'));
	endforeach;
?>
		}
 	}
}