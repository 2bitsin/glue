#ifndef GLUE_FUNCTOR
#define GLUE_FUNCTOR

#include "types.hpp"

namespace glue
{
	namespace detail
	{
		template <typename _Return, typename... _Arguments>
		struct function_type
		{
			using type = _Return (GLUE_APIENTRY *)(_Arguments...);
		};

		template <typename _Function>
		struct function;

		template <typename _Return, typename... _Arguments>
		struct function<_Return (_Arguments...)>:
			public detail::function_type<_Return, _Arguments...>
		{};
	}

	template <typename _Function>
	using function = typename detail::function<_Function>::type;

}

#endif