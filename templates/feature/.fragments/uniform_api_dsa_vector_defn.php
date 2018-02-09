			void api::program_uniform(program_name_t id, uniform_location_t loc, <?= $type ?> value) const 
			{
				<?= 'ProgramUniform' . $suffix; ?>(id, loc, <?= $pass ?>);
			}
