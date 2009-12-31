// Auto set on page load...
jQuery(document).ready(function() {
    // Uniform
    jQuery('form.uniForm').uniform();

    // Hide all hidden elements
    jQuery('.ctrlHidden').hide();

    // Bind a custom event
    jQuery('.ctrlHolder')
    .live('show', function () {
       var $this = jQuery(this) ;
       var slug = jQuery.trim($this.attr('class').replace('ctrlHolder', '').replace('ctrlHidden', '').replace('multipleInput', ''));

       jQuery ('div.' + slug + ':visible').each(function () {
           $this.find('option[value="' + jQuery(this).find('select').val() + '"]').remove();
       });

       if (jQuery('div.' + slug + ':hidden').length == 1) {
           $this.find('img.rolo_add_ctrl').hide();
       }
    })
    .live('hide', function () {
       var $this = jQuery(this) ;
       var slug = jQuery.trim($this.attr('class').replace('ctrlHolder', '').replace('ctrlHidden', '').replace('multipleInput', ''));

       if (jQuery ('div.' + slug + ':visible').length > 0) {
           jQuery ('div.' + slug + ':visible:last').find('img.rolo_add_ctrl').show();
       }
    });

    // when the add button is clicked
    jQuery('img.rolo_add_ctrl').live('click', function () {
       var $this = jQuery(this) ;
       var slug = jQuery.trim($this.parent('div.ctrlHolder').attr('class').replace('ctrlHolder', '').replace('ctrlHidden', '').replace('multipleInput', ''));

       $this.hide().parents('form.uniForm').find('div.' + slug + ':hidden:first').trigger('show').show();
    });

    // when the delete button is clicked
    jQuery('img.rolo_delete_ctrl').live('click', function () {
       var $this = jQuery(this) ;
       $this.parent('.ctrlHolder').hide().trigger('hide');
    });

    //on focus tricks
    jQuery('div.ctrlHolder input[name="rolo_contact_city"], div.ctrlHolder input[name="rolo_company_city"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'City') {
            $this.val('');
        }
    });

    jQuery('div.ctrlHolder input[name="rolo_contact_state"], div.ctrlHolder input[name="rolo_company_state"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'State') {
            $this.val('');
        }
    });

    jQuery('div.ctrlHolder input[name="rolo_contact_zip"], div.ctrlHolder input[name="rolo_company_zip"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'Zip') {
            $this.val('');
        }
    });

    jQuery('div.ctrlHolder input[name="rolo_contact_country"], div.ctrlHolder input[name="rolo_company_country"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'Country') {
            $this.val('');
        }
    });

    jQuery('input.company').suggest(wpurl + "/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=company", {multiple:false});

    // Edit in place for contacts
    jQuery('#rolo_contact_title,#rolo_contact_address, #rolo_contact_email, #rolo_contact_phone_Mobile, #rolo_contact_phone_Home, #rolo_contact_phone_Work, #rolo_contact_phone_Other, #rolo_contact_phone_Fax, #rolo_contact_im_Yahoo, #rolo_contact_im_MSN, #rolo_contact_im_AOL, #rolo_contact_im_GTalk, #rolo_contact_im_Skype, #rolo_contact_twitter, #rolo_contact_website').eip(ajax_url, {
        action: 'rolo_edit_contact',
        id_field: 'rolo_post_id'
    });

    // Edit in place for address
    jQuery('#city, #state, #zip, #country').eip(ajax_url, {
        action: 'rolo_edit_address',
        id_field: 'rolo_post_id'
    });

    // Edit in place for company
    jQuery('#rolo_company_name,#rolo_company_address, #rolo_company_city, #rolo_company_state, #rolo_company_zip, #rolo_company_country, #rolo_company_email, #rolo_company_phone_Mobile, #rolo_company_phone_Home, #rolo_company_phone_Work, #rolo_company_phone_Other, #rolo_company_phone_Fax, #rolo_company_im_Yahoo, #rolo_company_im_MSN, #rolo_company_im_AOL, #rolo_company_im_GTalk, #rolo_company_im_Skype, #rolo_company_twitter, #rolo_company_website').eip(ajax_url, {
        action: 'rolo_edit_company',
        id_field: 'rolo_post_id'
    });

    // Edit in place for notes

    jQuery('div.note p').eip(ajax_url, {
        action: 'rolo_edit_note'
//        id_field: 'rolo_company_id'
    });


});