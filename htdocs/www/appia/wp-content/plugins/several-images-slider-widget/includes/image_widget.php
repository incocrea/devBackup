<?php
defined('ABSPATH') or die('No script kiddies please!');
class SISW_Multi_image_slider extends WP_Widget {
        // Main constructor
    public function __construct() {
        // Instantiate the parent object
        parent::__construct(
            'sisw_widget',
            esc_html__( 'Several Images Slider Widget', 'sisw_gwl' ), 
            array( 'description' => esc_html__( 'A Multi Images Slider Widget', 'sisw_gwl' ), ) 
        );
    }
    // The widget form (for the backend )
    public function form( $instance ) {
        // Set widget defaults
        $defaults = array(
            'image_url'    => array(),
            'slider_title'=> 'Slider',
            'nav_option'=> 'true',
            'autoslide_option'=> 'true',
            'slider_pause_option'=> '5',
            'target_tab'=>array(''),
            'image_link'=>array(''),
            'rand_imgs_option' =>'true', //random images
            'items_per_slide' => '1', //Items per slide
            'dot_pagination_option'=> 'false',

        );    
                 
        // Parse current settings with defaults        
        if($instance)
            extract($instance);
        else
            extract($defaults);
        
       
        ?>
        <p class="slider_title"><?php _e('Title');?>: <input type="text" style="width:100%;" name="<?php echo esc_attr( $this->get_field_name( 'slider_title'));?>" value="<?php echo $slider_title; ?>"></p>
        <a class="sisw_upload_image_media" href="javascript:void(0)"><?php _e("Add Images","sisw_gwl");?></a><br/>
        <table class="sisw_multi_image_slider_table_wrapper"> 
            <tbody id="recipeTableBody">
            <?php  
            $targetval =(isset($instance['target_tab']))? $instance['target_tab'] : "";
            $linkval =  (isset($instance['image_link']))? $instance['image_link'] : "";

            
            if(isset($image_url) && count($image_url) > 0){
                $imagelength = array();
                $count=0;
                foreach($image_url as $url)
                { 
                    if(!empty($url))
                    {   $imgurl = wp_get_attachment_image_src( $url,'full' );
                    ?>
                        <tr class="sisw_individual_image_section">
                            <td class="drag-handler">
                                <span class="sisw_drag_Section">&#9776;</span>
                                <a href="<?php if(!empty($imgurl[0])){ echo $imgurl[0]; } ?>" target="_blank" ><img class="sisw_admin_image_preview active" src="<?php if(!empty($imgurl[0])){ echo $imgurl[0]; } ?>"></a>
                            </td>

                            <td class="image_td_fields">
                                <input class="" name="<?php echo esc_attr( $this->get_field_name( 'image_url'));?>[]" type="hidden" value="<?php echo $url; ?>" /> 
                                <input class="sisw_image_input_field" name="<?php echo esc_attr( $this->get_field_name( 'image_link'));?>[]" type="text" value="<?php echo esc_url($linkval[$count]); ?>" placeholder="Link (optional)" />
                                <span class="sisw_image_new_tab_label"><?php _e("Open link in a new tab","sisw_gwl");?></span>  <select name="<?php echo esc_attr( $this->get_field_name( 'target_tab'));?>[]" class="sisw_opentab" style="display:none;">
                                    <option <?php selected("",$targetval[$count]);?> value =""><?php _e("Select","sisw_gwl");?></option>
                                    <option <?php selected("newtab",$targetval[$count]);?> value="newtab" ><?php _e("New Window","sisw_gwl");?></option>
                                </select>
                                <input type="checkbox" name="ssiw_checkurl" <?php checked("newtab",$targetval[$count]);?> value="newtab" class="ssiw_checkurl">
                            </td>
                            <td class="recipe-table__cell">
                                <a class="sisw_remove_field_upload_media_widget" title="Delete" href="javascript:void(0)">&times;</a>
                            </td>
                        </tr>    
                    <?php 
                    }
                    $imagelength[]= $count;
                    $count++;
                }
            }
            ?>
             <tr class="sisw_no_images" <?php if( isset($image_url) && count($image_url)>=1){?> style="display:none;" <?php }?> >
                            <td colspan="3">
                                <?php _e("No images selected");?>
                            </td>
            </tr>
            </tbody>
        </table>
        <input type="hidden" class="sisw_temp_image_name" value="<?php echo esc_attr( $this->get_field_name( 'image_url'));?>[]" />
        <input type="hidden" class="sisw_temp_image_link" value="<?php echo esc_attr( $this->get_field_name( 'image_link'));?>[]" />
        <input type="hidden" class="sisw_temp_image_tab" value="<?php echo esc_attr( $this->get_field_name( 'target_tab'));?>[]" />
        <input type="hidden" class="sisw_temp_text_val" value="" />
        <div class="sisw_multi_image_slider_setting" <?php if(isset($image_url) && count($image_url)<=1){?> style="display:none;" <?php }?> >
            <h4><?php _e('Slider Settings',"sisw_gwl");?></h4>

            <!-- Slider Navigation -->
            <div class="sisw_slider_options_section"> 
                  <label><?php _e('Slider Navigation',"sisw_gwl");?>: </label>     
                  <input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'nav_option'));?>" <?php if($nav_option=='true'){ ?> checked="checked" <?php } ?>  value="true"><?php _e("Enable","sisw_gwl");?>
                  <input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'nav_option'));?>" <?php if($nav_option=='false'){ ?> checked="checked" <?php } ?> value="false" ><?php _e("Disable","sisw_gwl");?>
            </div>

            <!-- Autoslide -->
            <div class="sisw_slider_options_section"> 
                  <label><?php _e('Autoslide',"sisw_gwl");?>: </label>     
                  <input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'autoslide_option'));?>" <?php if($autoslide_option=='true'){ ?> checked="checked" <?php } ?> checked="checked" value="true"><?php _e("Enable","sisw_gwl");?>
                  <input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'autoslide_option'));?>" <?php if($autoslide_option=='false'){ ?> checked="checked" <?php } ?> value="false" ><?php _e("Disable","sisw_gwl");?>
            </div>
            
            <!-- Dot Pagination -->
            <div class="sisw_slider_options_section"> 
                  <label><?php _e('Pagination',"sisw_gwl");?>: </label>     
                  <input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'dot_pagination_option'));?>" <?php if($dot_pagination_option=='true'){ ?> checked="checked" <?php } ?> value="true"><?php _e("Enable","sisw_gwl");?>
            </div>

            <!-- Random Images FrontEnd -->
            <div class="sisw_slider_options_section"> 
                  <label><?php _e('Random Images',"sisw_gwl");?>: </label>     
                  <input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'rand_imgs_option'));?>" <?php if($rand_imgs_option=='true'){ ?> checked="checked" <?php } ?> value="true"><?php _e("Enable","sisw_gwl");?>
            </div>

            <!-- Pause Interval -->
            <div class="sisw_slider_options_section"> 
                  <label><?php _e('Pause(In second)',"sisw_gwl");?>: </label>     
                  <select name="<?php echo esc_attr( $this->get_field_name( 'slider_pause_option'));?>">
                      <?php
                        for ($i=1; $i <=10 ; $i++) 
                        { 
                        ?>    
                            <option <?php if($slider_pause_option==$i){ ?> selected="selected" <?php } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>    
                        <?php
                        }
                        ?>
                  </select>
            </div>
            
            <!-- Items per slide -->
            <div class="sisw_slider_options_section"> 
                  <label><?php _e('Items(Per Slide)',"sisw_gwl");?>: </label>     
                  <select name="<?php echo esc_attr( $this->get_field_name( 'items_per_slide'));?>">
                      <?php
                        for ($itm=1; $itm <=5 ; $itm++) 
                        { 
                        ?>    
                            <option <?php if($items_per_slide==$itm){ ?> selected="selected" <?php } ?> value="<?php echo $itm; ?>"><?php echo $itm; ?></option>    
                        <?php
                        }
                        ?>
                  </select>
            </div>

        </div>
    <?php }

    // Update widget settings
    public function update( $new_instance, $old_instance ){
        $instance = $old_instance;
        $instance['image_url']    =  $new_instance['image_url'];
        $instance['slider_title'] =  $new_instance['slider_title'];
        $instance['nav_option']    =  $new_instance['nav_option'];
        $instance['autoslide_option'] =  $new_instance['autoslide_option'];
        $instance['slider_pause_option'] =  $new_instance['slider_pause_option'];
        $instance['target_tab'] =  $new_instance['target_tab'];
        $instance['rand_imgs_option'] =  $new_instance['rand_imgs_option']; //random images
        $instance['items_per_slide'] =  $new_instance['items_per_slide']; // items per slide
        $instance['dot_pagination_option'] =  $new_instance['dot_pagination_option']; //dot pagination
        $instance['image_link']=array();

        if($new_instance['image_link'])
        {
            foreach ($new_instance['image_link'] as $temp_link) {
                $temp_link=esc_url($temp_link);
                
                $urlstring =    parse_url($temp_link, PHP_URL_HOST);
                
                if(wp_http_validate_url($temp_link) && strpos($urlstring, ".") !== false)
                {
                $instance['image_link'][] =  $temp_link;
                }
                else
                {
                 $instance['image_link'][] = "";   
                }
            }
        }
        else
        {
            $instance['image_link'] =  $new_instance['image_link'];
        }
        return $instance;
    }
    // Display the widget on frontend
    public function widget( $args, $instance ) {
        extract($instance);
        $count_images = 0;
          
        if (!empty($image_url)) {
            foreach ($image_url as $available_image_url) {
                if(!empty($available_image_url)){
                    $count_images++;
                }
            }
        }
        echo $args['before_widget'];
        if(isset($slider_title))
        {
        echo $args['before_title'];
        echo $slider_title;
        echo $args['after_title'];
        }

        $targetval =(isset($instance['target_tab']))? $instance['target_tab'] : "";

        $linkval =  (isset($instance['image_link']))? $instance['image_link'] : "";
        
        $count = 0;
        if($count_images >1){  ?>
             
            <div class="sisw_multi_image_slider_wrapper <?php echo $args['widget_id']; ?> owl-Carousel owl-theme">
            <?php 
                foreach ($image_url as $image_src) { 
                 $alt_text = get_post_meta( $image_src,"_wp_attachment_image_alt",true);
                 $imgurl = wp_get_attachment_image_src( $image_src,'full' );
                 

                    if (!empty($image_src)) { ?>
                        <div class="item">
                       <?php  if(!empty($linkval[$count])) {?>
                            <a href="<?php if(!empty($linkval[$count])){echo esc_url($linkval[$count]);}?>" <?php if($targetval[$count] == 'newtab'){echo "target='_blank'";}?> title="<?php _e("Click here");?>" >
                                <img src="<?php if(!empty($imgurl[0])){echo $imgurl[0];} ?>" alt="<?php echo $alt_text;?>" />
                            </a>
                         <?php }
                          else
                        {?>
                            <img src="<?php if(!empty($imgurl[0])){echo $imgurl[0];} ?>" alt="<?php echo $alt_text;?>" />

                <?php   }?>
                        </div>    
                    <?php 
                    }
                    $count++;
                }
                $slider_nav_option = $instance['nav_option'];
            ?>
            </div>

            <?php 
                //Items per slide
                if(!empty($instance['items_per_slide']) && $instance['items_per_slide']>1) {
                        $items_per_slide_val = $instance['items_per_slide'];
                } else {
                    $items_per_slide_val  = 1;
                } 

                //Dot paginatoin
                if(!empty($instance['dot_pagination_option']) && $instance['dot_pagination_option']==true) {
                        $dot_pagination_option = $instance['dot_pagination_option'];
                } else {
                    $dot_pagination_option  = 'false';
                }
            ?>

            <script>
                jQuery(document).ready(function($){
                    
                    var nav_option = <?php echo $slider_nav_option;  ?>; 
                    var autoplay_option = <?php echo $instance['autoslide_option']; ?>; 
                    var pause_option = <?php echo $instance['slider_pause_option']."000"; ?>; 
                    var items_per_slide_val = <?php echo $items_per_slide_val; ?>;
                    var dot_pagination_option = <?php echo $dot_pagination_option; ?>;
                     
                    var owl = $('.sisw_multi_image_slider_wrapper.<?php echo $args['widget_id']; ?>');
                    <?php if(!empty($instance['rand_imgs_option'])) { ?>
                    owl.owlCarousel({
                        loop: true,
                        autoplay:autoplay_option,
                        autoplayTimeout:pause_option,
                        dots:dot_pagination_option,
                        nav:nav_option,
                        autoplayHoverPause: true,
                        margin:7,
                        responsiveClass:true,
                        responsive:{
                            0:{
                                items:1
                            },
                            600:{
                                items: '<?php if($items_per_slide_val>1){ echo "2";}else{echo "1";} ?>'
                            },
                            768:{
                                items:items_per_slide_val
                            }
                        },
                        /*random image*/                        
                        onInitialize : function(element){
                            owl.children().sort(function(){
                                return Math.round(Math.random()) - 0.5;
                            }).each(function(){
                                $(this).appendTo(owl);
                            });
                        },                  
                    });
                    <?php } else { ?>
                        owl.owlCarousel({
                            loop: true,
                            autoplay:autoplay_option,
                            autoplayTimeout:pause_option,
                            dots:dot_pagination_option,
                            nav:nav_option,
                            autoplayHoverPause: true,
                            margin:7,
                            responsiveClass:true,
                            responsive:{
                                0:{
                                    items:1,
                                },
                                600:{
                                    items: '<?php if($items_per_slide_val>1){ echo "2";}else{echo "1";} ?>',
                                    nav:true
                                },
                                768:{
                                    items:items_per_slide_val,
                                    nav:true
                                }
                            },                                            
                        });                        

                    <?php } ?>
                });
            </script>
        <?php
        }
        elseif ($count_images==1) 
        { 
            $temp_img_id=$image_url[0];
            $alt_text = get_post_meta( $temp_img_id,"_wp_attachment_image_alt",true);
            $imgurl = wp_get_attachment_image_src( $temp_img_id,'full' );
        ?>
            <div id="sisw_single_image_wrapper">

            <?php if(isset($linkval[0])&&trim($linkval[0])!="")
            {?>
              <a href="<?php echo esc_url($linkval[0]);?>" <?php if($targetval[$count] == 'newtab'){echo "target='_blank'";}else{echo "";}?> title="<?php _e("Click here");?>" >
                <img src="<?php if(!empty($imgurl[0])){echo $imgurl[0];}?>" alt="<?php if(isset($alt_text)) echo $alt_text;?>" />
            </a>
             <?php
            }
            else
            {
            ?>
            <img src="<?php if(!empty($imgurl[0])){echo $imgurl[0];}?>" alt="<?php if(isset($alt_text)) echo $alt_text;?>" />
            <?php
            }
            ?>
            </div> 
        <?php
        }
        echo $args['after_widget'];
    }
}
function sisw_register_multi_image_slider_widget(){
	register_widget( 'SISW_Multi_image_slider' );
}
add_action( 'widgets_init', 'sisw_register_multi_image_slider_widget' );