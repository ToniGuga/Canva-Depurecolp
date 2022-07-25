jQuery(document).ready(function() {

    // jQuery("#categorychecklist-pop input, #categorychecklist input, .cat-checklist input").each(function() { this.type = "radio" });

    // jQuery('#the-list td.Progress').each(function() {

    //     if (jQuery(this).html() == 'Status-0') {

    //         jQuery(this).parent('tr').css('background-color', '#ffcdd2');

    //     } else if (jQuery(this).html() == 'Status-25') {

    //         jQuery(this).parent('tr').css('background-color', '#ffecb3');

    //     } else if (jQuery(this).html() == 'Status-50') {

    //         jQuery(this).parent('tr').css('background-color', '#ffecb3');

    //     } else if (jQuery(this).html() == 'Status-75') {

    //         jQuery(this).parent('tr').css('background-color', '#c8e6c9');

    //     } else if (jQuery(this).html() == 'Status-100') {

    //         jQuery(this).parent('tr').css('background-color', '#fff');

    //     }

    // });

    jQuery('#the-list td.Progress').each(function() {

        jQuery(this).html('<div class="status-bar"><div>25%</div><div>50%</div><div>75%</div><div>100%</div></div>');

    });

});