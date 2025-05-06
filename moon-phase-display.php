<?php
/*
Plugin Name: Moon Phase Display
Description: Displays current moon phase with visual representation
Version: 1.0
Author: Your Name
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Moon_Phase_Display {
    private $plugin_path;
    private $plugin_url;

    public function __construct() {
        $this->plugin_path = plugin_dir_path(__FILE__);
        $this->plugin_url = plugin_dir_url(__FILE__);
        
        // Register shortcode
        add_shortcode('moon_phase', array($this, 'moon_phase_shortcode'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    public function enqueue_assets() {
        // Register styles
        wp_enqueue_style(
            'moon-phase-style',
            $this->plugin_url . 'css/moon-phase.css',
            array(),
            '1.0'
        );
    }

    public function moon_phase_shortcode($atts) {
        // Get current date and convert to GMT
        $current_date = new DateTime('now', new DateTimeZone('GMT'));
        
        // Blue moon date (February 3, 1996, 16:15:00 GMT)
        $blue_moon_date = new DateTime('1996-02-03 16:15:00', new DateTimeZone('GMT'));
        
        // Lunar period in seconds
        $lunar_period = 29 * (24 * 3600) + 12 * (3600) + 44.05 * (60);
        
        // Calculate moon phase
        $time_diff = $current_date->getTimestamp() - $blue_moon_date->getTimestamp();
        $moon_phase_time = $time_diff % $lunar_period;
        
        // Compute percentages
        $percent_raw = $moon_phase_time / $lunar_period;
        $percent = round(100 * $percent_raw) / 100;
        $percent_by_2 = round(200 * $percent_raw);
        
        // Determine images
        $black_img = $this->plugin_url . 'images/black.gif';
        $white_img = $this->plugin_url . 'images/white.gif';
        $left = ($percent_raw >= 0.5) ? $black_img : $white_img;
        $right = ($percent_raw >= 0.5) ? $white_img : $black_img;
        
        // Size of moon display
        $size = 40;
        
        if ($percent_by_2 > 100) {
            $percent_by_2 = $percent_by_2 - 100;
        }
        
        // Generate output
        $output = '<div class="moon-phase-container"><center>';
        
        for ($i = -($size-1); $i < $size; $i++) {
            $wid = 2 * floatval(sqrt(($size * $size) - ($i * $i)));
            
            if ($percent_by_2 != 100) {
                $output .= '<img src="' . esc_url($left) . '" height="1" width="' . ($wid * ((100 - $percent_by_2) / 100)) . '">';
            }
            if ($percent_by_2 != 0) {
                $output .= '<img src="' . esc_url($right) . '" height="1" width="' . ($wid * ($percent_by_2 / 100)) . '">';
            }
            $output .= '<br>';
        }
        
        // Calculate days until next full moon
        $days_until_full = round(($lunar_period - $moon_phase_time) / (24 * 3600));
        
        $output .= '</center>';
        $output .= '<div class="moon-phase-text">';
        $output .= 'Next full moon is in about ' . $days_until_full . ' day' . ($days_until_full != 1 ? 's' : '');
        $output .= '</div></div>';
        
        return $output;
    }
}

// Initialize plugin
new Moon_Phase_Display();