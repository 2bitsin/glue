		void api::ProgramUniform(program_name_t id, uniform_location_t loc, <?= $count ? 'std::int32_t count, ' : '' ?><?= $type ?> value) const 
		{
			<?= 'ProgramUniform' . $suffix; ?>(id, loc, <?= $count ? 'count, ' : '' ?><?= $pass ?>);
		}
