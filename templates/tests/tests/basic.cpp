#include <glue/lvl2/gl/4.6.core.hpp>
#include <glue/meta.hpp>
#include <iostream>

namespace glue
{
	using glue::lvl1::load;
	using glue::lvl2::core_4_6::api;	
}

#define SDL_MAIN_HANDLED
#include <SDL2/SDL.h>

int main(int, char**)
{
	SDL_Init(SDL_INIT_EVERYTHING);

	SDL_GL_SetAttribute(SDL_GL_CONTEXT_MAJOR_VERSION, 4);
	SDL_GL_SetAttribute(SDL_GL_CONTEXT_MINOR_VERSION, 6);
	SDL_GL_SetAttribute(SDL_GL_CONTEXT_PROFILE_MASK, SDL_GL_CONTEXT_PROFILE_CORE);
	SDL_GL_SetAttribute(SDL_GL_CONTEXT_FLAGS, SDL_GL_CONTEXT_DEBUG_FLAG);

	const auto w = SDL_WINDOWPOS_CENTERED;
	auto window_ = SDL_CreateWindow(nullptr, w, w, 1280u, 720u, SDL_WINDOW_OPENGL);
	auto opengl_ = SDL_GL_CreateContext(window_);

	glue::api gl;
	glue::load(gl, SDL_GL_GetProcAddress);

	SDL_Event event_;
	while (!SDL_QuitRequested())
	{
		if (SDL_PollEvent (&event_))
		{
			continue;
		}
		gl.ClearColor(1.0f, 0.0f, 1.0f, 1.0f);
		gl.Clear(gl.GL_COLOR_BUFFER_BIT);
		SDL_GL_SwapWindow(window_);
	}

	SDL_GL_DeleteContext(opengl_);
	SDL_DestroyWindow(window_);
	SDL_Quit();
	return 0;
}