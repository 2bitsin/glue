#include <glue/gl/4.6.core.hpp>

#include <iostream>

int main()
{
	glue::Interface ifc;

	glue::load(ifc, [](auto c) {return (void*)nullptr;});

	std::cout << "Hello world!";
	return 0;
}