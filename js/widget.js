//
// Scrolling for Twitter widget
//

(function($) {
	$(document).ready( function() {
		var tweetposition = 0;
		$('.tapi-scroll a').on('click', function(e){
			e.preventDefault();
			var h, l;
			l = $(this);
			h = $('.tapi-tweets');
			if( l.attr('id') == 'tapi-next' ) {
				tweeth = $('.tapi-tweet').eq(tweetposition).height() + 25;
				if ( h.height() - Math.abs(parseInt(h.css('top'))) > 300 ) {
					console.log(tweeth);
					h.animate({
						top: '-=' + tweeth,
					}, 200);
					tweetposition += 1;
				}
			}
			if( l.attr('id') == 'tapi-prev' && tweetposition > 0 ) {
				tweeth = $('.tapi-tweet').eq(tweetposition-1).height() + 25;
				console.log(tweeth);
				h.animate({
					top: '+=' + tweeth,
				}, 200);
				tweetposition -= 1;
			}
		});
	});
})(jQuery);