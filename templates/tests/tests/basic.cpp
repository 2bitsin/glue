#include <glue/gl/4.6.core.hpp>
#include <glue/meta.hpp>
#include <iostream>

int main()
{
	glue::Interface ifc;

	glue::load(ifc, [](auto c) {return (void*)nullptr;});

	const auto* p = glue::enum_to_string(0x2);
	while (*p) std::cout << *(p++) <<"\n";

	std::cout << "Hello world!";
	return 0;
}