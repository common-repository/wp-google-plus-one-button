<?php 
/*
 * Plugin Name: WP Google Plus One Button
 * Plugin URI: http://vivacityinfotech.net
 * Description: A simple Google Plus Like and Share Button plugin for your posts/pages or Home page in your own language.
 * Version: 1.6
 * Author: Vivacity Infotech Pvt. Ltd.
 * Author URI: http://vivacityinfotech.net
 * License: GPL2
 * Text Domain: wp-google-plus-one-button
 * Domain Path: /languages/
*/
/*
Copyright 2014  Vivacity InfoTech Pvt. Ltd. (email : support@vivacityinfotech.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('ABSPATH')) exit(); // Exit if accessed directly
 add_action('init', 'wgpob_load_googleplus');
  function wgpob_load_googleplus()
   {
       load_plugin_textdomain('wp-google-plus-one-button', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
   }

$enable_plugin = 0;
$placing_loc = "above";
$icon_size = 'medium';
$language = 'en';
$width= 150;
$data_ann = 'inline';
$asyn = '';
$btn_with = 'both';

if(isset($_REQUEST['save_settings'])) {	
		global $enable_plugin, $placing_loc,$icon_size,$language,$width,$data_ann,$asyn,$btn_with;
		if(isset($_REQUEST['enable_google']))
		{
				$enable_plugin = 1;
				update_option('wp_google_plus_enable', 1);
		}
		else
		{
				$enable_plugin = 0;
				update_option('wp_google_plus_enable', 0);
		}	
	if($_REQUEST['select_custom_post_type'] !='')
	{
		 $get =$_REQUEST['select_custom_post_type'];
 	 	 $getva = implode(',',$_REQUEST['select_custom_post_type']);
 		 update_option('select_custom_post_type', $getva);
	}	
		$placing_loc = $_REQUEST['btn_pos'];
		update_option('wp_google_plus_location', $placing_loc);
		
		$icon_size = $_REQUEST['btn_size'];
		update_option('wp_google_plus_icon_size', $icon_size);
		
		$language = $_REQUEST['lang'];
		update_option('wp_google_plus_language', $language);
		
		$saprate_by_id_exclude = $_REQUEST['saprate_by_id_exclude'];
		update_option('saprate_by_id_exclude', $saprate_by_id_exclude);
		if(!empty($_REQUEST['width']))
		{
			$width= $_REQUEST['width'];
			update_option('wp_google_plus_width', $width);
		}
			
		$data_ann = $_REQUEST['dann'];
		update_option('wp_google_plus_ann',$data_ann);
		
		if(!empty($_REQUEST['asynchronus']))
		{
		$asyn = $_REQUEST['asynchronus'];
		update_option('wp_google_plus_asynchronus', $asyn);
		}
		
		$btn_with = $_REQUEST['btn_with'];
		update_option('wp_google_plus_btn_with', $btn_with);
		
		//add_filter('the_content','wp_google_plus_script');	
		
}
else
{
		global $enable_plugin, $placing_loc,$icon_size,$language,$width,$data_ann,$asyn,$btn_with,$saprate_by_id_exclude;
		$enable_plugin =  get_option('wp_google_plus_enable');
		$placing_loc = get_option('wp_google_plus_location');
		$icon_size = get_option('wp_google_plus_icon_size');
		$language = get_option('wp_google_plus_language');
		$width= get_option('wp_google_plus_width');
		$data_ann = get_option('wp_google_plus_ann');	
		$asyn = get_option('wp_google_plus_asynchronus');		
		$btn_with = get_option('wp_google_plus_btn_with');
		$saprate_by_id_exclude = get_option('saprate_by_id_exclude');
}

add_filter('the_excerpt','wgpob_add_button_to_excerpt');
function wgpob_add_button_to_excerpt($content){
	global $enable_plugin, $placing_loc,$icon_size,$language,$width,$data_ann,$asyn,$btn_with,$saprate_by_id_exclude;
		//echo $enable_plugin.$placing_loc.$icon_size.$language.$width.$data_ann;	 exit;
		$newdata='';
	  $post = get_the_ID();
		$post_type = get_post_type( $post );
		if( $btn_with == 'excerpt' ) {
			if($enable_plugin == 1)
			{	//return $enable_plugin." in";			
				if($asyn =='asyn') {
					$script = '<!-- Place this tag where you want the +1 button to render. -->
						<div class="g-plusone" data-size="'.$icon_size.'" data-annotation="'.$data_ann.'" data-width="'.$width.'"></div>
				
						<!-- Place this tag after the last +1 button tag. -->
				
				
						<script type="text/javascript">
						window.___gcfg = {lang: \''.$language.'\'};
					  	(function() {
							var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
							po.src = \'https://apis.google.com/js/platform.js\';
							var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
					  	})();
						</script>';	
				}
				else {				
					$script = '<!-- Place this tag where you want the +1 button to render. -->
						<div class="g-plusone" data-size="'.$icon_size.'" data-annotation="'.$data_ann.'" data-width="'.$width.'"></div>
				
						<!-- Place this tag after the last +1 button tag. -->
				
				
						<script type="text/javascript" src="https://apis.google.com/js/platform.js">
  							{lang:  \''.$language.'\'}
						</script>';
				}		
			
				if($placing_loc == 'below') {
					if($btn_with == 'excerpt') 
							$newdata = $content."<br/>".$script;
					else {
						$newdata = $content;
					}
				}
				else if($placing_loc == 'above') {
					if($btn_with == 'excerpt') 
						$newdata = $script."<br/>".$content;
					else 
						$newdata = $content;
				}
				else {
					if($btn_with == 'excerpt') {	
						$newdata = $script."<br/>".$content."<br/>".$script;
					}
					else 
						$newdata = $content;
				}
			return $newdata;
		}
		else
			//return $enable_plugin." out";
			return $content = get_the_content();
		}
	else 
		return $content = get_the_content();		
}

add_filter('the_content','wgpob_add_button_to_content');
function wgpob_add_button_to_content($content){
	global $enable_plugin, $placing_loc,$icon_size,$language,$width,$data_ann,$asyn,$btn_with,$saprate_by_id_exclude;		
		$newdata='';		
		$post = get_the_ID();
		$post_type = get_post_type( $post );
		
			$custom = get_option('select_custom_post_type');
				$exdata =explode(',', $custom );	
		  $totallenhth = count($exdata);
			$get_exclude_id = explode(',', $saprate_by_id_exclude); 
	 $get_total_id = count($get_exclude_id); 
		if( $btn_with != 'excerpt' ) {
			if($enable_plugin == 1)
			{	 
			 for($i=0;$i <= $totallenhth;$i++)
 		    {  	 
 			if(get_post_type($post->ID)  ==  $exdata[$i] )  {	
 		  for($j=0;$j<= $get_total_id;$j++)
 				{	
					 if($post ==   $get_exclude_id[$j] )  {
 						return $newdata = get_the_content();
 						}
 				}
				if($asyn =='asyn') {
					$script = '<!-- Place this tag where you want the +1 button to render. -->
						<div class="g-plusone" data-size="'.$icon_size.'" data-annotation="'.$data_ann.'" data-width="'.$width.'"></div>				
						<!-- Place this tag after the last +1 button tag. -->
				
						<script type="text/javascript">
						window.___gcfg = {lang: \''.$language.'\'};
					  	(function() {
							var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
							po.src = \'https://apis.google.com/js/platform.js\';
							var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
					  	})();
						</script>';	
				}
				else {				
					$script = '<!-- Place this tag where you want the +1 button to render. -->
						<div class="g-plusone" data-size="'.$icon_size.'" data-annotation="'.$data_ann.'" data-width="'.$width.'"></div>				
						<!-- Place this tag after the last +1 button tag. -->
				
						<script type="text/javascript" src="https://apis.google.com/js/platform.js">
  							{lang:  \''.$language.'\'}
						</script>';
				}		
			
				if($placing_loc == 'below') {
					if($btn_with == 'page') {
						if( $post_type	== 'page') {
							$newdata = $content."<br/>".$script;
						}
						else 
							$newdata = $content;
					}
					else if($btn_with == 'post') {
						if( $post_type	== 'post')	{
							$newdata = $content."<br/>".$script;
						}
						else 
							$newdata = $content;
					}
					else {
						$newdata = $content."<br/>".$script;
					}
				}
				else if($placing_loc == 'above') {
					if($btn_with == 'page') {
						if( $post_type == 'page') {		
							$newdata = $script."<br/>".$content;
						}
						else 
							$newdata = $content;
					}
					else if($btn_with == 'post') {
						if( $post_type	== 'post')	{
							$newdata = $script."<br/>".$content;
						}
						else 
							$newdata = $content;
					}
					else {
						$newdata = $script."<br/>".$content;
					}
					
				}
				else {
					if($btn_with == 'page') {
						if( $post_type == 'page') {		
							$newdata = $script."<br/>".$content."<br/>".$script;
						}
						else 
							$newdata = $content;
					}
					else if($btn_with == 'post') {
						if( $post_type	== 'post')	{
							$newdata = $script."<br/>".$content."<br/>".$script;
						}
						else 
							$newdata = $content;
					}
					else {
						$newdata = $script."<br/>".$content."<br/>".$script;
					}
				}
			 
			 return $newdata;		 
		} 
		else {
			 
			  $newdata = get_the_content();
			}

		
		}
		 
		 return $newdata;
 		 
		
		}
		else
		{
			
			return $content = get_the_content();
		}	
			
	}
	else 
		return $content = get_the_content();
		
}

add_action('admin_menu', 'wgpob_init_call');
function wgpob_init_call(){
		add_submenu_page(
						'options-general.php', // the slud name of the parent menu
						__('WP Google Plus One Button', 'wp-google-plus-one-button' ), // menu title of the plugin
						__('WP Google Plus One Button', 'wp-google-plus-one-button' ), // menu text to be displayed on the menu option
						'administrator', // capabilities of the menu
						'wp-google-plus-one-button', // menu slud
						'wgpob_create_google_gui'	 // function to be called.
					);
					
	add_action('admin_enqueue_scripts', 'wgpob_admin_styles');				
					
	}
	
	function wgpob_admin_styles() {
    /*
     * It will be called only on your plugin admin page, enqueue our stylesheet here
     */
    wp_register_style('viva_googleplusStyle', plugins_url('css/googlestyle.css', __FILE__));
    wp_enqueue_style('viva_googleplusStyle');
    wp_register_script( 'viva_googleplus_script', plugins_url('js/custom.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'viva_googleplus_script' );
}
	

function wgpob_create_google_gui(){
		global $enable_plugin, $placing_loc,$icon_size,$language,$width,$data_ann,$asyn,$btn_with,$saprate_by_id_exclude;
		
		$above='';$below='';$abovebelow='';$small=''; $medium=''; $standard=''; $tall=''; $post=''; $page=''; $both='';$excerpt='';
		$af= ''; $am= ''; $ar = ''; $eq=''; $bn= ''; $bg= ''; $ca= ''; $zhHK = '';$zhCN= ''; $zhTW= ''; $hr= '';
		$cs= ''; $da= ''; $ni= ''; $enGB = ''; $en = '';  $et= ''; $fil= ''; $fi= ''; $frCA= ''; $fr = ''; 
		$gl= '';	$de = ''; $el= ''; $gu= ''; $iw= ''; $hi = ''; $hu= ''; $is= ''; $id= ''; $it = ''; $ja= ''; $kn= '';
		$ko = ''; $lv= ''; $lt= ''; $ms= ''; $ml= ''; $mr= ''; $no= ''; $fa= ''; $pl= ''; $ptPR= ''; $ptPT = '';
		$ro= ''; $ru = ''; $sr= ''; $sk= ''; $sl= ''; $es419= ''; $es = ''; $sw= ''; $sv= ''; $ta= ''; $te= '';
		$th= ''; $tr= ''; $uk = ''; $ur= ''; $vi= ''; $zu= '';


		if($enable_plugin == true)
			$check = ' checked=checked';
		else
			$check = '';
			
		if($asyn == true)
			$check1 =' checked=checked';
		else
			$check1 = '';
		
		
		if($placing_loc == 'above') 
			$above = ' selected=selected'; 
		else if($placing_loc == 'below') {
			$below = ' selected=selected'; 
		}
		else 
			$abovebelow = ' selected=selected'; 
			
		if($btn_with == 'post') 
			$post = ' selected=selected'; 
		else if($btn_with == 'page')
			$page = ' selected=selected'; 
		else if($btn_with == 'both')
			$both = ' selected=selected'; 
		else 
			$excerpt = ' selected=selected'; 
		
		if($icon_size == 'small')
			$small = ' selected=selected'; 
		else if($icon_size == 'medium')
			$medium = ' selected=selected'; 
		else if($icon_size == 'standard')
			$standard = ' selected=selected'; 
		else if($icon_size == 'tall')
			$tall = ' selected=selected'; 
			
			
		switch($language) {
			       case 'af' :
                $af = ' selected=selected'; 
                break;
                case 'am' :
                $am = ' selected=selected'; 
                break;
                case 'ar' :
                $ar = ' selected=selected'; 
                break;
                case 'eq' :
                $eq = ' selected=selected'; 
                break;
                case 'bn' :
                $bn = ' selected=selected'; 
                break;
                case 'bg' :
                $bg = ' selected=selected'; 
                break;
                case 'ca' :
                $ca = ' selected=selected'; 
                break;
                case 'zh-HK' :
                $zhHK = ' selected=selected'; 
                break;
                case 'zh-CN' :
                $zhCN = ' selected=selected'; 
                break;
                case 'zh-TW' :
                $zhTW = ' selected=selected'; 
                break;
                case 'hr' :
                $hr = ' selected=selected'; 
                break;
                case 'cs' :
                $cs = ' selected=selected'; 
                break;
                case 'da' :
                $da = ' selected=selected'; 
                break;
                case 'ni' :
                $ni = ' selected=selected'; 
                break;
                case 'en-GB' :
                $enGB = ' selected=selected'; 
                break;
                case 'en' :
                $en = ' selected=selected'; 
                break;
                case 'et' :
                $et = ' selected=selected'; 
                break;
                case 'fil' :
                $fil = ' selected=selected'; 
                break;
                case 'fi' :
                $fi = ' selected=selected'; 
                break;
                case 'fr-CA' :
                $frCA = ' selected=selected'; 
                break;
                case 'fr' :
                $fr = ' selected=selected'; 
                break;
                case 'gl' :
                $gl = ' selected=selected'; 
                break;
                case 'de' :
                $de = ' selected=selected'; 
                break;
                case 'el' :
                $el = ' selected=selected'; 
                break;
                case 'gu' :
                $gu = ' selected=selected'; 
                break;
                case 'iw' :
                $iw = ' selected=selected'; 
                break;
                case 'hi' :
                $hi = ' selected=selected'; 
                break;
                case 'hu' :
                $hu = ' selected=selected'; 
                break;
                case 'is' :
                $is = ' selected=selected'; 
                break;
                case 'id' :
                $id = ' selected=selected'; 
                break;
                case 'it' :
                $it = ' selected=selected'; 
                break;
                case 'ja' :
                $ja = ' selected=selected'; 
                break;
                case 'kn' :
                $kn = ' selected=selected'; 
                break;
                case 'ko' :
                $ko = ' selected=selected'; 
                break;
                case 'lv' :
                $lv = ' selected=selected'; 
                break;
                case 'lt' :
                $lt = ' selected=selected'; 
                break;
                case 'ms' :
                $ms = ' selected=selected'; 
                break;
                case 'ml' :
                $ml = ' selected=selected'; 
                break;
                case 'mr' :
                $mr = ' selected=selected'; 
                break;
                case 'no' :
                $no = ' selected=selected'; 
                break;
                case 'fa' :
                $fa = ' selected=selected'; 
                break;
                case 'pl' :
                $pl = ' selected=selected'; 
                break;
                case 'pt-PR' :
                $ptPR = ' selected=selected'; 
                break;
                case 'pt-PT' :
                $ptPT = ' selected=selected'; 
                break;
                case 'ro' :
                $ro = ' selected=selected'; 
                break;
                case 'ru' :
                $ru = ' selected=selected'; 
                break;
                case 'sr' :
                $sr = ' selected=selected'; 
                break;
                case 'sk' :
                $sk = ' selected=selected'; 
                break;
                case 'sl' :
                $sl = ' selected=selected'; 
                break;
                case 'es419' :
                $es419 = ' selected=selected'; 
                break;
                case 'es' :
                $es = ' selected=selected'; 
                break;
                case 'sw' :
                $sw = ' selected=selected'; 
                break;
                case 'sv' :
                $sv = ' selected=selected'; 
                break;
                case 'ta' :
                $ta = ' selected=selected'; 
                break;
                case 'te' :
                $te = ' selected=selected'; 
                break;
                case 'th' :
                $th = ' selected=selected'; 
                break;
                case 'tr' :
                $tr = ' selected=selected'; 
                break;
                case 'uk' :
                $uk = ' selected=selected'; 
                break;
                case 'ur' :
                $ur = ' selected=selected'; 
                break;
                case 'vi' :
                $vi = ' selected=selected'; 
                break;
                case 'zu' :
                $zu = ' selected=selected'; 
                break;
                 default :
                break;
                
		}	


					
		$inline=''; $bubble=''; $none='';
		if($data_ann == 'inline')
			$inline = ' selected=selected'; 
		else if($data_ann == 'bubble')
			$bubble = ' selected=selected'; 
		else if($data_ann == 'none')
			$none = ' selected=selected'; 
			
		$plugin_url = plugin_dir_url(__FILE__);
		$form_url = '';
		
		?>
		<script type="text/javascript">var msg1 = "<?php __('The width should be in between 120 to 450', 'wp-google-plus-one-button' ) ?>";</script>
 <script type="text/javascript">var msg2 = "<?php __('Width should be a number', 'wp-google-plus-one-button' ) ?>";</script>
		<?php 
		
		$msg='';
		 if(isset($_REQUEST['save_settings']))
			{	
				$msgtxt =  __('Plugin Setting Has Saved', 'wp-google-plus-one-button' );
				$msg = '<div id="message" class="updated notice is-dismissible">
<p>
'.$msgtxt.'.
</p>
<button class="notice-dismiss" type="button">
<span class="screen-reader-text">Dismiss this notice.</span>
</button>
</div>';				
			}
		$data='';
		$data .= '<div id="google_container" class="wrap">
		
		<div class="wgpob_top">
  <h3>'. __( "WP Google Plus One Button", "wp-google-plus-one-button" ) .'<small> '. __("by","wp-google-plus-one-button") .' <a class="wgpob_a" href="http://www.vivacityinfotech.com" target="_blank">Vivacity Infotech Pvt. Ltd.</a>
  </h3>
    </div> <!-- ------End of top-----------  -->
		
					<div class="wgpob_inner_wrap">'
					.$msg.
						
			 '<div class="wgpob_left">	
					<form action="'.$form_url.'" method="post" >
					<h3 class="title" id="wgpob_mainsettings">'. __("Main Settings","wp-google-plus-one-button").'</h3>
						<div class="google_settings">
							<table class="form-table wgpob_admintbl"> 
								<tr>
									<th>'.__('Enable Google Plus Like and Share', 'wp-google-plus-one-button' ).'</th>
									<td><input type="checkbox" name="enable_google" '.$check.'/> </td>
								</tr>
								<tr>
									<th>'.__('Select Post Type', 'wp-google-plus-one-button' ).'</th><td>';
									
  $args = array(
   'public'   => true,
   '_builtin' => false
);
$output = 'names'; // names or objects, note names is the default
$operator = 'and'; // 'and' or 'or'
 $post_types = get_post_types( $args, $output, $operator ); 
 $k=0;
    $getdata = get_option('select_custom_post_type');
    $exdata =explode(',', $getdata );
   $total =count($exdata);
	$data .='<input type="checkbox" value="page"';
for($a=0;$a<=$total;$a++)
  {
  	 if($exdata[$a]== page){   
  	 $data .='checked="checked"';
  	   }} 
 	$data .='name="select_custom_post_type[]">Page<br>							
<input type="checkbox" value="post"';

for($a=0;$a<=$total;$a++)
  {
  	 if($exdata[$a]== post){   
  	 $data .='checked="checked"';
  	   }} 

	$data .='name="select_custom_post_type[]">Post <br>';   
   
     foreach ( $post_types as $post_type ) {
 
$data.='<input type="checkbox"';
 
   for($a=0;$a<=$total;$a++)
  {
  	 if($exdata[$a]== $post_type){  
 	 $data.='checked="checked"';
 
 	   } }
 	 $data.='name="select_custom_post_type[]" value="'.$post_type.'" />'.$post_type.'<br>';
  
$k++;
}
	 $data .='</td></tr>
	 
									<tr>
									<th>'.__('Page / Post id to exclude:', 'wp-google-plus-one-button' ).'</th>
									<td>
										 <input type="text" name="saprate_by_id_exclude" id="saprate_by_id_exclude" class="input_type" value="'.$saprate_by_id_exclude.'" placeholder="Eg: 1,2,12"> 
									</td>
									</tr>
									
									<tr>
									<th>'.__('Place Google Plus Like at', 'wp-google-plus-one-button' ).'</th>
									<td>
										<select name="btn_pos">
											<option value="above" '.$above.'>'.__('Above the content', 'wp-google-plus-one-button' ).'</option>
											<option value="below" '.$below.'>'.__('Below the content', 'wp-google-plus-one-button' ).'</option>
											<option value="abovebelow" '.$abovebelow.'>'.__('Both Above And Below the content', 'wp-google-plus-one-button' ).'</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>'.__('Place Google Plus Like With', 'wp-google-plus-one-button' ).'</th>
									<td>
										<select name="btn_with">
											<option value="post" '.$post.'>'.__('With The Post', 'wp-google-plus-one-button' ).'</option>
											<option value="page" '.$page.'>'.__('With The Page', 'wp-google-plus-one-button' ).'</option>
											<option value="both" '.$both.'>'.__('Both Page And Post', 'wp-google-plus-one-button' ).'</option>
											<option value="excerpt" '.$excerpt.'>'.__('With The Excerpt', 'wp-google-plus-one-button' ).'</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>'.__('Size', 'wp-google-plus-one-button' ).'</th>
									<td>
										<select name="btn_size">
											<option value="small" '.$small.'>'.__('Small', 'wp-google-plus-one-button' ).'</option>
											<option value="medium" '.$medium.'>'.__('Medium', 'wp-google-plus-one-button' ).'</option>
											<option value="standard" '.$standard.'>'.__('Standard', 'wp-google-plus-one-button' ).'</option>
											<option value="tall" '.$tall.'>'.__('Tall', 'wp-google-plus-one-button' ).'</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>'.__('Language settings', 'wp-google-plus-one-button' ).'</th>
									<td>
										<select name="lang">
											<option value="af" '.$af.'>'.__('Afrikaans', 'wp-google-plus-one-button' ).'</option>
											<option value="am" '.$am.'>'.__('Amharic - ‪አማርኛ‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ar" '.$ar.'>'.__('Arabic - ‫العربية‬', 'wp-google-plus-one-button' ).'</option>
											<option value="eq" '.$eq.'>'.__('Basque - ‪euskara‬', 'wp-google-plus-one-button' ).'</option>
											<option value="bn" '.$bn.'>'.__('Bengali - ‪বাংলা‬', 'wp-google-plus-one-button' ).'</option>
											<option value="bg" '.$bg.'>'.__('Bulgarian - ‪български‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ca" '.$ca.'>'.__('Catalan - ‪català‬', 'wp-google-plus-one-button' ).'</option>
											<option value="zh-HK" '.$zhHK.'>'.__('Chinese (Hong Kong) - ‪中文（香港）‬', 'wp-google-plus-one-button' ).'</option>
											<option value="zh-CN" '.$zhCN.'>'.__('Chinese (Simplified) - ‪简体中文‬', 'wp-google-plus-one-button' ).'</option>
											<option value="zh-TW" '.$zhTW.'>'.__('Chinese (Traditional) - ‪繁體中文‬', 'wp-google-plus-one-button' ).'</option>
											<option value="hr" '.$hr.'>'.__('Croatian - ‪Hrvatski‬', 'wp-google-plus-one-button' ).'</option>
											<option value="cs" '.$cs.'>'.__('Czech - ‪Čeština‬', 'wp-google-plus-one-button' ).'</option>
											<option value="da" '.$da.'>'.__('Danish - ‪Dansk‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ni" '.$ni.'>'.__('Dutch - ‪Nederlands‬', 'wp-google-plus-one-button' ).'</option>
											<option value="en-GB" '.$enGB.'>'.__('English (United Kingdom)', 'wp-google-plus-one-button' ).'</option>
											<option value="en" '.$en.'>'.__('English (USA)', 'wp-google-plus-one-button' ).'</option>
											<option value="et" '.$et.'>'.__('Estonian - ‪eesti‬', 'wp-google-plus-one-button' ).'</option>
											<option value="fil" '.$fil.'>'.__('Filipino', 'wp-google-plus-one-button' ).'</option>
											<option value="fi" '.$fi.'>'.__('Finnish - ‪Suomi‬', 'wp-google-plus-one-button' ).'</option>
											<option value="fr-CA" '.$frCA.'>'.__('French (Canada) - ‪Français (Canada)‬', 'wp-google-plus-one-button' ).'</option>
											<option value="fr" '.$fr.'>'.__('French (France) - ‪Français (France)', 'wp-google-plus-one-button' ).'</option>
											<option value="gl" '.$gl.'>'.__('Galician - ‪galego‬', 'wp-google-plus-one-button' ).'</option>
											<option value="de" '.$de.'>'.__('German -Deutsch', 'wp-google-plus-one-button' ).'</option>
											<option value="el" '.$el.'>'.__('Greek - ‪Ελληνικά‬', 'wp-google-plus-one-button' ).'</option>
											<option value="gu" '.$gu.'>'.__('Gujarati - ‪ગુજરાતી‬', 'wp-google-plus-one-button' ).'</option>
											<option value="iw" '.$iw.'>'.__('Hebrew - ‫עברית‬', 'wp-google-plus-one-button' ).'</option>
											<option value="hi" '.$hi.'>'.__('Hindi - ‪हिन्दी', 'wp-google-plus-one-button' ).'</option>
											<option value="hu" '.$hu.'>'.__('Hungarian - ‪magyar‬', 'wp-google-plus-one-button' ).'</option>
											<option value="is" '.$is.'>'.__('Icelandic - ‪íslenska‬', 'wp-google-plus-one-button' ).'</option>
											<option value="id" '.$id.'>'.__('Indonesian - ‪Bahasa Indonesia‬', 'wp-google-plus-one-button' ).'</option>
											<option value="it" '.$it.'>'.__('Italian - ‪Italiano', 'wp-google-plus-one-button' ).'</option>
											<option value="ja" '.$ja.'>'.__('Japanese - ‪日本語‬', 'wp-google-plus-one-button' ).'</option>
											<option value="kn" '.$kn.'>'.__('Kannada - ‪ಕನ್ನಡ‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ko" '.$ko.'>'.__('Korean - ‪한국어', 'wp-google-plus-one-button' ).'</option>
											<option value="lv" '.$lv.'>'.__('Latvian - ‪latviešu‬', 'wp-google-plus-one-button' ).'</option>
											<option value="lt" '.$lt.'>'.__('Lithuanian - ‪lietuvių‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ms" '.$ms.'>'.__('Malay - ‪Bahasa Melayu‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ml" '.$ml.'>'.__('Malayalam - ‪മലയാളം‬‬', 'wp-google-plus-one-button' ).'</option>
											<option value="mr" '.$mr.'>'.__('Marathi - ‪मराठी‬‬', 'wp-google-plus-one-button' ).'</option>
											<option value="no" '.$no.'>'.__('Norwegian - ‪norsk‬', 'wp-google-plus-one-button' ).'</option>
											<option value="fa" '.$fa.'>'.__('Persian - ‫فارسی‬‬', 'wp-google-plus-one-button' ).'</option>
											<option value="pl" '.$pl.'>'.__('Polish - ‪polski‬‬', 'wp-google-plus-one-button' ).'</option>
											<option value="pt-PR" '.$ptPR.'>'.__('Portuguese (Brazil) - ‪Português (Brasil)‬‬‬', 'wp-google-plus-one-button' ).'</option>
											<option value="pt-PT" '.$ptPT.'>'.__('Portuguese (Portugal) - ‪Português (Portugal)', 'wp-google-plus-one-button' ).'</option>
											<option value="ro" '.$ro.'>'.__('Romanian - ‪română‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ru" '.$ru.'>'.__('Russian - ‪Русский‬', 'wp-google-plus-one-button' ).'</option>
											<option value="sr" '.$sr.'>'.__('Serbian - ‪Српски‬', 'wp-google-plus-one-button' ).'</option>
											<option value="sk" '.$sk.'>'.__('Slovak - ‪Slovenčina‬‬', 'wp-google-plus-one-button' ).'</option>
											<option value="sl" '.$sl.'>'.__('Slovenian - ‪slovenščina‬‬', 'wp-google-plus-one-button' ).'</option>
											<option value="es-419" '.$es419.'>'.__('Spanish (Latin America) - ‪Español (Latinoamérica)‬', 'wp-google-plus-one-button' ).'</option>
											<option value="es" '.$es.'>'.__('Spanish (Spain) - ‪Español (España)', 'wp-google-plus-one-button' ).'</option>
											<option value="sw" '.$sw.'>'.__('Swahili - ‪Kiswahili‬', 'wp-google-plus-one-button' ).'</option>
											<option value="sv" '.$sv.'>'.__('Swedish - ‪Svenska‬', 'wp-google-plus-one-button' ).'</option>
											<option value="ta" '.$ta.'>'.__('Tamil - ‪தமிழ்‬', 'wp-google-plus-one-button' ).'</option>
											<option value="te" '.$te.'>'.__('Telugu - ‪తెలుగు‬', 'wp-google-plus-one-button' ).'</option>
											<option value="th" '.$th.'>'.__('Thai - ‪ไทย‬', 'wp-google-plus-one-button' ).'</option>
											<option value="tr" '.$tr.'>'.__('Turkish - ‪Türkçe', 'wp-google-plus-one-button' ).'</option>
											<option value="uk" '.$uk.'>'.__('Ukrainian - ‪Українська', 'wp-google-plus-one-button' ).'</option>
											<option value="ur" '.$ur.'>'.__('Urdu - ‫اردو‬', 'wp-google-plus-one-button' ).'</option>
											<option value="vi" '.$vi.'>'.__('Vietnamese - ‪Tiếng Việt‬', 'wp-google-plus-one-button' ).'</option>
											<option value="zu" '.$zu.'>'.__('Zulu - ‪isiZulu‬', 'wp-google-plus-one-button' ).'</option>

										</select>
									</td>
								</tr>
								<tr>
									<th>'.__('Width', 'wp-google-plus-one-button' ).'</th>
									<td><input type="text" name="width" value="'.$width.'" id="google_width" /></td>
								</tr>
								<tr>
									<th>'.__('Data Annotation', 'wp-google-plus-one-button' ).'</th>
									<td>
										<select name="dann">
											<option value="inline" '.$inline.'>'.__('Inline', 'wp-google-plus-one-button' ).'</option>
											<option value="bubble" '.$bubble.'>'.__('Bubble', 'wp-google-plus-one-button' ).'</option>
											<option value="none" '.$none.'>'.__('None', 'wp-google-plus-one-button' ).'</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>'.__('Asynchronous', 'wp-google-plus-one-button' ).'</th>
									<td> <input type="checkbox" name="asynchronus"  '.$check1.' value="asyn"> </td>
									</td>								
								</tr>
								<tr>
									
									<td><input class="googlesavebtn" type="submit" name="save_settings" value="'.__('Save', 'wp-google-plus-one-button' ).'" id="wgpob_save_settings" /> </td>
								</tr>
							</table>
						</div>
						
					</form>
					 </div> <!-- --------End of left div--------- -->
					  <div class="wgpob_right">
	<center>
<div class="wgpob_bottom">
           <h3 id="wgpob_download-comments" class="title">'. __('Download Free Plugins', 'wp-google-plus-one-button').'</h3>
                                        <div id="wgpob_downloadtbl-comments" class="togglediv">  
                                            <h3 class="company">
                                                <p>'. __('Vivacity InfoTech Pvt. Ltd. is an ISO 9001:2015 Certified Company is a Global IT Services company with expertise in outsourced product development and custom software development with focusing on software development, IT consulting, customized development.We have 200+ satisfied clients worldwide.', 'wp-google-plus-one-button') .' </p>	
                                                '. __('Our Free Plugins', 'wp-google-plus-one-button').':
                                            </h3>
                                            <ul class="">
                                                <li><a target="_blank" href="https://wordpress.org/plugins/wp-twitter-feeds/">'. __("WP twitter feeds").'</a></li>
                                                <li><a target="_blank" href="https://wordpress.org/plugins/facebook-comment-by-vivacity/">'. __("Facebook Comments by Vivacity").'</a></li>
                                                <li><a target="_blank" href="https://wordpress.org/plugins/wp-fb-share-like-button/">'. __("WP Facebook Like Button").'</a></li>
                                                <li><a target="_blank" href="https://wordpress.org/plugins/vi-random-posts-widget/">'. __("Vi Random Post Widget").'</a></li>
                                                <li><a target="_blank" href="https://wordpress.org/plugins/wp-infinite-scroll-posts/">'. __("WP EasyScroll Posts").'</a></li>
                                            </ul>
                                        </div> 
                                    </div>		
                                    <div class="wgpob_bottom">
                                        <h3 id="wgpob_donatehere-comments" class="title">'. __('Donate Here', 'wp-google-plus-one-button').'</h3>
               <div id="wgpob_donateheretbl-comments" class="togglediv">  
                    <p>'. __('If you want to donate, please click on below image.', 'wp-google-plus-one-button').'</p>
                    <a href="http://vivacityinfotech.net/paypal-donation/" target="_blank"><img class="donate" src="'. plugins_url('images/paypal.gif', __FILE__).'" width="150" height="50" title="'. __('Donate Here', 'wp-google-plus-one-button').'"></a>		
                                        </div>
                                    </div>	
                                    <div class="wgpob_bottom">
                                        <h3 id="wgpob_wfpm-comments" class="title">'. __('Woocommerce Frontend Plugin', 'wp-google-plus-one-button').'</h3>
                                        <div id="wgpob_wfpmtbl-comments" class="togglediv">  
                                            <p>'. __('If you want to purchase , please click on below image.', 'wp-google-plus-one-button').'</p>
                                            <a href="http://bit.ly/1HZGRBg" target="_blank"><img class="donate" src="'. plugins_url('images/woo_frontend_banner.png', __FILE__).'" width="336" height="280" title="'. __('Woocommerce Frontend Plugin', 'wp-google-plus-one-button').'"></a>		
                                        </div> 
                                    </div>
                                    <div class="wgpob_bottom">
                                        <h3 id="wgpob_bflog-comments" class="title">'. __('Blue Frog Template', 'wp-google-plus-one-button').'</h3>
                                        <div id="wgpob_bflogtbl-comments" class="togglediv">  
                                            <p>'. __('If you want to purchase , please click on below image.', 'wp-google-plus-one-button').'</p>
                                            <a href="http://bit.ly/1Gwp4Vv" target="_blank"><img class="donate" src="'. plugins_url('images/blue_frog_banner.png', __FILE__).'" width="336" height="280" title="'. __('Blue Frog Template', 'wp-google-plus-one-button').'"></a>		
                                        </div> 
                                    </div>

	</center>
 </div><!-- --------End of right div--------- -->
					</div><!-- --------End of inner_wrap--------- -->
					<div style="clear:both;"></div>
				</div>';
		echo $data;
	}
?>
