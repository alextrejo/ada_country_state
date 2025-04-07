<?php
/**
 * Plugin Name: ADA Country
 * Description: Countries and States for Canada & USA
 * Author: Alexander Trejo
 * Version: 1.0
 */

 class adaCountry{
   public static function init(){
     //Ajax Handler
     add_action("wp_ajax_ada_country_states", array(__CLASS__, 'country_states'));
     add_action("wp_ajax_nopriv_ada_country_states", array(__CLASS__, 'icountry_states'));
   }


   public static function get_countries(){
     //Load Javascript
     wp_enqueue_script( 'ada-country', WP_PLUGIN_URL . '/ada_country/js/ada_country.js', array('jquery'), '1.0.12', true );
     wp_localize_script( 'ada-country', 'ajaxurl', array( 'url' => admin_url( 'admin-ajax.php' )));

     //Return Countries
     require(dirname(__FILE__) . '/includes/countries.php');
     return $countries;
   }

   public static function get_states($country = ''){
     if(!$country) return;
   
     require(dirname(__FILE__) . '/includes/states.php');
     $key = $country == 'CA' || $country == 'Canada' ? 'canada': 'usa';
     return $states[$key];
   }

   public static function get_loading(){
     return '<img src="'. WP_PLUGIN_URL .'/ada_country/images/loading.gif" alt="Loading" id="img-loading" class="hidden v-middle">';
   }

   public static function country_states(){
     require(dirname(__FILE__) . '/includes/states.php');

     $key = $_GET['data'] == 'CA' ? 'canada': 'usa';
     $data = array();
     foreach($states[$key] as $k => $v){
       $data[] = array('code' => $k, 'state' => $v);
     }

     header("Content-type:application/json");
     echo json_encode($data);
     wp_die();
   }
 }

 adaCountry::init();
