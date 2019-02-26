<?php
  //hook in filter to remove unwanted fields as data will be generated through geolocation
  //postal infomation is kept if user location is different from billing details
  

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
function custom_override_checkout_fields( $fields ) {
    
    unset($fields['billing']['billing_address_1']);
  
    
    return $fields;
}

/**
* Add the field to the checkout
**/
//retrive vaules from URL  
add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');

function my_custom_checkout_field($checkout) {
$lat = (isset($_GET['lat']))?$_GET['lat']:"failed";
$lon = (isset($_GET['long']))?$_GET['long']:"failed";
$distance = (isset($_GET['distance']))?$_GET['distance']:"failed";
$addressone = (isset($_GET['add1']))?$_GET['add1']:"failed";
$addresstwo = (isset($_GET['add2']))?$_GET['add2']:"failed";
$addressthree = (isset($_GET['add3']))?$_GET['add3']:"failed";

//geolocation javascript and map display
  
echo '<div id="map"><h2>'.__('Map').'</h2>';
echo '<div id="mapcontent">';

echo '
<html>
<body onload = getLocation()>
<p id = "demo"><label>Your Current Location</label></p>



<div id="mapholder"></div>

<script src="https://maps.google.com/maps/api/js?sensor=false"></script>

<script>

var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    latlon = new google.maps.LatLng(lat, lon)
    mapholder = document.getElementById("mapholder")
    mapholder.style.height = "350px";
    mapholder.style.width = "490px";
    //x.innerHTML = "cordinates are" + lat+ "   " + lon;
    var myOptions = {
    center:latlon,zoom:14,
    mapTypeId:google.maps.MapTypeId.ROADMAP,
    mapTypeControl:false,
    navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
  
    }
    
    var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
    var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
    }

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}

  </script>




</html>';

echo '</div>';
echo '</div>';

echo '<div id="my_custom_checkout_field" style="display: none;"><h2>'.__('Coordinates').'</h2>';


//set the retrived values into the fields
woocommerce_form_field( 'latitude', array(
'type'          => 'text',
'class'         => array('my-field-class form-row-wide'),
'label'         => __('latitude'),
'placeholder'       => __('Latitude will appear'),
'default'            => ($lat), 
), $checkout->get_value( 'latitude' ));

  
woocommerce_form_field( 'longitude', array(
'type'          => 'text',
'class'         => array('my-field-class form-row-wide'),
'label'         => __('longitude'),
'placeholder'       => __('Longitude will appear here'),
'default'  => ($lon),
), $checkout->get_value( 'longitude' ));

woocommerce_form_field( 'distance', array(
'type'          => 'text',
'class'         => array('my-field-class form-row-wide'),
'label'         => __('distance'),
'placeholder'       => __('distance will appear here'),
'default'  => ($distance),
), $checkout->get_value( 'distance' ));
  

woocommerce_form_field( 'delivery_status', array(
'type'          => 'text',
'class'         => array('my-field-class form-row-wide'),
'label'         => __('delivery status'),
'placeholder'       => __('status will appear here'),
'default'  => ('pending'),
), $checkout->get_value( 'delivery_status' ));

woocommerce_form_field( 'addressone', array(
'type'          => 'text',
'class'         => array('my-field-class form-row-wide'),
'label'         => __('addressone'),
'placeholder'       => __('address will appear here'),
'default'  => ($addressone),
), $checkout->get_value( 'addressone' ));

woocommerce_form_field( 'addresstwo', array(
'type'          => 'text',
'class'         => array('my-field-class form-row-wide'),
'label'         => __('addresstwo'),
'placeholder'       => __('address will appear here'),
'default'  => ($addresstwo),
), $checkout->get_value( 'addresstwo' ));  
  
woocommerce_form_field( 'addressthree', array(
'type'          => 'text',
'class'         => array('my-field-class form-row-wide'),
'label'         => __('addressthree'),
'placeholder'       => __('address will appear here'),
'default'  => ($addressthree),
), $checkout->get_value( 'addressthree' ));
  
echo '</div>';


}

/**
* Process the checkout
**/
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');


/**
* Update the order meta with field value
**/
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');


function my_custom_checkout_field_update_order_meta( $order_id ) {
if ($_POST['latitude']) update_post_meta( $order_id, 'latitude', esc_attr($_POST['latitude']));

if ($_POST['longitude']) update_post_meta( $order_id, 'longitude', esc_attr($_POST['longitude']));

if ($_POST['delivery_status']) update_post_meta( $order_id, 'delivery_status', esc_attr($_POST['delivery_status']));

if ($_POST['distance']) update_post_meta( $order_id, 'distance', esc_attr($_POST['distance']));

if ($_POST['addressone']) update_post_meta( $order_id, 'addressone', esc_attr($_POST['addressone']));

if ($_POST['addresstwo']) update_post_meta( $order_id, 'addresstwo', esc_attr($_POST['addresstwo']));

if ($_POST['addressthree']) update_post_meta( $order_id, 'addressthree', esc_attr($_POST['addressthree']));

}
  
//hook in filters
  
add_filter('woocommerce_get_checkout_url', 'geolocator_redirect_checkout');

function geolocator_redirect_checkout() {
     return 'https://www.kioski.co/customer-locator/'; // change to the link you want
}
  
//create custom password field for customer locator mobile application
/**
 * Add new register fields for WooCommerce registration.
 *
 * @return string Register fields HTML.
 */
function wooc_extra_register_fields() {
  ?>

  <p class="form-row form-row-first">
  <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
  <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
  </p>

  <p class="form-row form-row-last">
  <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
  <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
  </p>

  <div class="clear"></div>

  <p class="form-row form-row-wide">
  <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?> <span class="required">*</span></label>
  <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
  </p>

  <?php
}

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

?>