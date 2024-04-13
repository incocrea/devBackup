jQuery(document).ready(function($){  //Open media window for select image
  var mediaUploader;
  jQuery('body').on("click",'.sisw_upload_image_media',function(e) {
    e.preventDefault();
    siswtempthis=$(this);
      
      
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
      }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Select Slider Images',
      button: {
      text: 'Add'
    }, multiple: true });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      attachments = mediaUploader.state().get('selection').toJSON();
      //console.log(attachments.length);

      for (i in attachments) {
                attachment= attachments[i];
        jQuery('.sisw_image_input_field.active_image_section ').val(attachment.url);
        jQuery('img.sisw_admin_image_preview.active_admin_preview').addClass('active').attr('src',attachment.url);
       // jQuery('.active_widget_form .widget-control-actions input[type="submit"]').removeAttr('disabled');
        var current_input_name = siswtempthis.parents(".widget").find(".sisw_temp_image_name").val();
        var current_input_link = siswtempthis.parents(".widget").find(".sisw_temp_image_link").val();
        var current_input_tab = siswtempthis.parents(".widget").find(".sisw_temp_image_tab").val();
        
          siswtempthis.parents(".widget").find('.sisw_temp_text_val').trigger("change");
        if (attachment.url.match(/.(jpg|jpeg|png|gif)$/i))
        {
        var new_element = `<tr class='sisw_individual_image_section'>
        <td class="drag-handler"><span class="sisw_drag_Section">☰</span> <a href=`+attachment.url+` target="_blank"><img src='`+attachment.url+`' class='sisw_admin_image_preview'></a></td>
        <td class="image_td_fields"><input class='' name='`+current_input_name+`' value=`+attachment.id+` type='hidden'>
        <input class="sisw_image_input_field" name='`+current_input_link+`' type='text' value='' placeholder='Link (optional)'><span class="sisw_image_new_tab_label">`+sisw_admindata.newtab_string+`</span> <select name='`+current_input_tab+`' class='sisw_opentab' style="display: none;">
                                        <option value="">`+sisw_admindata.sametab_value+`</option>
                                        <option value="newtab">`+sisw_admindata.newtab_value+`</option>
                                </select>
                                <input type="checkbox" name="ssiw_checkurl" value="newtab" class="ssiw_checkurl">
        </td><td class="recipe-table__cell"><a class="sisw_remove_field_upload_media_widget" title="Delete" href="javascript:void(0)">&times;</a></td></tr>`;

          siswtempthis.parents(".widget").find('.sisw_multi_image_slider_table_wrapper tbody').append(new_element);
          }

          var current_imag_length = siswtempthis.parents(".widget").find('.sisw_multi_image_slider_table_wrapper .sisw_individual_image_section').length;
          if(current_imag_length >1){
            siswtempthis.parents(".widget").find('.sisw_multi_image_slider_setting').show();
          }
          else{
            siswtempthis.parents(".widget").find('.sisw_multi_image_slider_setting').hide();       
          }
          if(current_imag_length>0){
            siswtempthis.parents(".widget").find('.sisw_no_images').hide();
          }
          else
          {
            siswtempthis.parents(".widget").find('.sisw_no_images').show();
          }
      }
      
    });
    // Open the uploader dialog
    mediaUploader.open();




  });

});


jQuery(document).ready(function($){ // Remove the image section
    jQuery('body').on("click",'a.sisw_remove_field_upload_media_widget',function(){
    jQuery(this).parents(".widget").find('input[type="submit"]').removeAttr('disabled');
    jQuery(this).parents(".widget").find('.sisw_temp_text_val').trigger("change");
    jQuery(this).parents('table').addClass('countrows');
    var temppobj=jQuery(this).parents(".widget");
     var current_imag_length = temppobj.find(".sisw_multi_image_slider_table_wrapper .sisw_individual_image_section").length;
    if(current_imag_length ==1)
    {
      var resultsisw = confirm(sisw_admindata.confirm_message);
      if (resultsisw) {
      jQuery(this).parents('tr').remove();
      }
    }
    else
    {
      jQuery(this).parents('tr').remove();
    }
    current_imag_length = temppobj.find(".sisw_multi_image_slider_table_wrapper .sisw_individual_image_section").length;
        if(current_imag_length >1)
        {
         temppobj.find('.sisw_multi_image_slider_setting').show();
         }
        else
        {
          temppobj.find('.sisw_multi_image_slider_setting').hide();
         }
        if(current_imag_length>0){
            temppobj.find('.sisw_no_images').hide();
          }
          else
          {
            temppobj.find('.sisw_no_images').show();
          }

  });
 // 
        $('.sisw_temp_text_val').change(function(){
          $(".sisw_temp_text_val").val("abc");
        })

        
      $(document).on('click', '.ssiw_reset', function () {
          //$( this ).prevAll( ".sisw_image_input_field" ).val('');

      });

       $(document).on('click', '.ssiw_checkurl', function () {
       
        if($(this).is(':checked'))
        {
            $( this ).prev( ".sisw_opentab" ).val('newtab');
        }
        else
        {
            $( this ).prev( ".sisw_opentab" ).val('');
        }
          
          

      });
 
});


jQuery(document).ready(function($){
	setTimeout(function(){
		$('#recipeTableBody').sortable({
			helper: '.drag-handler',
			zIndex: 999999,
			update : function() {
				jQuery(this).parents('.widget').find('.sisw_temp_text_val').trigger("change");
				jQuery('button.components-button.is-primary').removeAttr('disabled');
			}
		}).disableSelection();
	}, 1000);
});