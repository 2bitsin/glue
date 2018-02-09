#include <glue/lvl1/gl/4.5.core.hpp>
#include <glue/lvl2/gl/4.5.core.hpp>
#include <glue/lvl1/gl/4.6.core.hpp>
#include <glue/lvl2/gl/4.6.core.hpp>
#include <glue/meta.hpp>
#include <iostream>

int main()
{
	glue::lvl2::core_4_6::api ifc0;
	glue::lvl2::core_4_5::api ifc1;

	glue::lvl1::load(ifc0, [] (auto c) -> void* {return nullptr;});
	glue::lvl1::load(ifc1, [] (auto c) -> void* {return nullptr;});

	return 0;
}