#ifndef GLUE_STRINGS_HPP
#define GLUE_STRINGS_HPP

#include <cstddef>
#include <cstdint>

namespace glue
{
	namespace impl
	{
		const char* str_by_index(std::size_t idx);
	}
}

#endif