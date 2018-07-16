cmake_minimum_required (VERSION 3.10)
project (glue CXX)
add_definitions(-D_SCL_SECURE_NO_WARNINGS)
if (${CMAKE_SIZEOF_VOID_P} EQUAL "8")
    set (PROJECTNAME_ARCHITECTURE "x64")
else ()
    set (PROJECTNAME_ARCHITECTURE "x86")
endif ()

find_package(SDL2 REQUIRED)

find_path(SDL2_INCLUDE_DIR SDL2/SDL.h)
find_library(SDL2_LIBRARY SDL2)

include_directories ("${CMAKE_CURRENT_SOURCE_DIR}/include")
include_directories ("${SDL2_INCLUDE_DIR}")

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

add_library(glue <?= implode(' ', $libfiles) ?> ${SDL2_INCLUDE_DIR})
add_executable(glue_tests <?= implode(' ', $testfiles) ?>)
target_link_libraries(glue_tests glue ${SDL2_LIBRARY})

install(TARGETS glue glue_tests EXPORT glue 
  RUNTIME DESTINATION "${CMAKE_CURRENT_SOURCE_DIR}/install/bin/${PROJECTNAME_ARCHITECTURE}"
  LIBRARY DESTINATION "${CMAKE_CURRENT_SOURCE_DIR}/install/lib/${PROJECTNAME_ARCHITECTURE}"
  ARCHIVE DESTINATION "${CMAKE_CURRENT_SOURCE_DIR}/install/lib/${PROJECTNAME_ARCHITECTURE}"
  INCLUDES DESTINATION "${CMAKE_CURRENT_SOURCE_DIR}/install/includes")
