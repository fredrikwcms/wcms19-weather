
<?php

/**
 * Adds WeatherWidget widget.
 */

class WeatherWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'weatherwidget', // Base ID
			'WCMS19 Weather', // Name
			[
				'description' => __('A Widget for fetching weather data from OpenWeatherMap', 'weatherwidget'),
			] // Args
		);
    }
    
    /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		// Start widget
		echo $before_widget;

		// title
		if (!empty($title))	{
			echo $before_title . $title . $after_title;
		}

		// get city and country for this widget
		$city = $instance['city'];
		$country = $instance['country'];

		// get weather conditions for the specified city and country
		$current_weather = owm_get_current_weather($city, $country);

		// display weather conditions for specified city and country
		// echo "In <strong>" . $city . "</strong> the weather is like this: <br>";
		// echo "Temparature: " . $current_weather['temparature'] . "&deg; C<br>";
		// echo "Humidity: " . $current_weather['humidity'] . "%<br>";
		// echo "Conditions: " . $current_weather['conditions'] . "<br>";
		?>
			<div class="current-weather">
				<div class="weather-conditions">
					<h3>Current weather in <?php echo $city; ?></h3>

					<?php
						foreach($current_weather['conditions'] as $condition) {
							?>
								<img
									src="http://openweathermap.org/img/w/<?php echo $condition->icon; ?>.png"
									title="<?php echo $condition->description; ?>"
									alt="<?php echo $condition->main; ?>"
								>
							<?php
						}
					?>
				</div>
				
				<dl>
					<dt>Tempatature</dt>
					<dd><?php echo $current_weather['temparature']; ?></dd>	

					<dt>Humidity</dt>
					<dd><?php echo $current_weather['humidity']; ?></dd>
				</dl>
				
			</div>
		<?php 
		// close widget
		echo $after_widget;
    }

    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
        if (isset($instance['title'])) {
			$title = $instance['title'];
		}	else {
			$title = __('Weather Trivia', 'weatherwidget');
		}

		$city = isset($instance['city']) ? $instance['city'] : 'Malmoe';
		$country =  isset($instance['country']) ?  $instance['country'] : 'SE';

		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>"
			/>
		</p>
		<!-- /title -->

		<!-- city -->
		<p>
			<label
				for="<?php echo $this->get_field_name('city'); ?>"
			>
				<?php _e('City:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('city'); ?>"
				name="<?php echo $this->get_field_name('city'); ?>"
				type="text"
				value="<?php echo esc_attr($city); ?>"
			/>
		</p>
		<!-- /city -->

		<!-- country -->
		<p>
			<label
				for="<?php echo $this->get_field_name('country'); ?>"
			>
				<?php _e('Country:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('country'); ?>"
				name="<?php echo $this->get_field_name('country'); ?>"
				type="text"
				value="<?php echo esc_attr($country); ?>"
			/>
		</p>
		<!-- /country -->
		<?php
    }

    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];
		
		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';
		
		$instance['city'] = (!empty($new_instance['city']))
			? strip_tags($new_instance['city'])
			: '';

		$instance['country'] = (!empty($new_instance['country']))
			? strip_tags($new_instance['country'])
			: '';
		return $instance;
    }
} // Class WeatherWidget