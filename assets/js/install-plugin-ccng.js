jQuery(document).ready(function($) {
	var pluginSlug = 'xml-sitemap-for-google';
	var installURL = 'plugin-install.php?tab=plugin-information&plugin=' + pluginSlug + '&TB_iframe=true&width=900&height=800';
	$('#open-install-ccng').on('click', function(e) {
		e.preventDefault();
		tb_show('Plugin Installation', installURL);
		$('#TB_window').css({ 'width': '946px', 'max-height': 'calc(100% - 50px)', 'overflow-x': 'auto', 'margin': '34px auto 0 auto', 'top': '0', 'transform': 'translateX(-50%)' });
		$('#TB_iframeContent').css({ 'width': '100%', 'height': 'calc(100vh - 100px)' });
	   
	});
});