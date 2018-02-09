			void api::uniform(uniform_location_t loc, <?= $type ?> value) const 
			{
				<?= 'Uniform' . $suffix; ?>(loc, <?= $pass ?>);
			}
