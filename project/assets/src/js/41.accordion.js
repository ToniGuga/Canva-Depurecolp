(function ($) {

	var allPanels = $('._accordion');
	var allNotActivePanels = $('._accordion:not(._active)');

	$(allNotActivePanels).each(function(){
		$(this).find('._accordion-content').slideUp();
	});

	$(allPanels).click(function () {

		$this = $(this);

		if($this.hasClass('_active')){
			// do nothing
		}else{
			allPanels.removeClass('_active').find('._accordion-content').slideUp();
			$this.addClass('_active').find('._accordion-content').slideDown();
		}

		return false;

	});

})(jQuery);
