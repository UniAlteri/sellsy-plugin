<?php
if (!is_admin()):
	if (isset($options['WPIaff_form']) && 'displayTitle' == $options['WPIaff_form'] && !empty($options['WPInom_form'])) {
		echo '<h3>'.$options['WPInom_form'].'</h3>';
	}

	if (!empty($errors)): ?>
		<div class="formError">
			<span>
				<?php echo __( 'Votre message n\'a pas été envoyé, vérifiez la saisie des champs suivant :', 'wpsellsy' ); ?>
			</span>
			<ul>
				<?php
				foreach ($errors as $error) {
					echo '<li>'.$error.'</li>';
				}
				?>
			</ul>
		</div>
	<?php endif; ?>
	<form method="post" action="" id="wp-sellsy-form">
		<?php foreach ($formFieldsList as $key=>$field) {
			$value = '';
			if (isset($_POST[$key])) {
				$value = $_POST[$key];
			}

			$code = $field->getCode();
			switch ($field->getType()) {
				case 'text':
					echo '<label for="'.$key.'">'.$field->getName();
					echo '<input type="text" name="' . $code . '" id="' . $code . '" value="' . $value . '" />';
					echo '</label>';
					break;
				case 'radio':
					echo '<div>'.$field->getName();
					foreach ($field->getOptions() as $option) {
						echo '<label>'.$option['value'];
						echo '<input type="radio" name="' . $code . '" id="' . $code . '" value="' . $option['id'] . '" />';
						echo '</label>';
					}
					echo '</div>';
					break;
				case 'checkbox':
					echo '<div>'.$field->getName();
					foreach ($field->getOptions() as $option) {
						echo '<label>'.$option['value'];
						echo '<input type="checkbox" name="' . $code . '[]" id="' . $code . '" value="' . $option['id'] . '" />';
						echo '</label>';
					}
					echo '</div>';
					break;
				case 'select':
					echo '<label for="'.$code.'">'.$field->getName();
					echo '<select name="' . $code . '" id="' . $code . '">';
					foreach ($field->getOptions() as $option) {
						echo '<option value="' . $option['id'] . '">'.$option['value'].'</option>';
					}
					echo '</select>';
					echo '</label>';
					break;
			}
		}
		?>
		<div class="submit">
	        <input type="submit" name="send_wp_sellsy" value="<?php _e('Valider', 'wpsellsy') ?>" />
	    </div>
		<?php
		if (function_exists('wp_nonce_field')) {
			wp_nonce_field('slswp_nonce_field', 'slswp_nonce_verify_page');
		}
		?>
	</form>
<?php endif;