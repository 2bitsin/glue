		void api::uniform(uniform_location_t loc, <?= $count ? 'std::int32_t count, ' : '' ?><?= $type ?> value) const 
		{
			<?= 'Uniform' . $suffix; ?>(loc, <?= $count ? 'count, ' : '' ?><?= $pass ?>);
		}
