/* Avoid "CSS flash" effect on Tabber tabs */
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
/**/

/* Cookie Functions
 ********************************************************************/

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
	return null;
}

function killCookie(name) {
	document.cookie = name+"=1;expires="+c.toGMTString()+";"+";";
}


/* Misc
 ********************************************************************/

function mailto (qui,ou,quoi) {
	if (qui == undefined) {qui = "ozh"};
	if (ou == undefined && qui == "ozh") {ou = "planetozh.com"};
	if (quoi == undefined) {quoi = ""};
	location.target="_top";
	location.href="mailto:"+qui+"@"+ou+"?subject="+quoi;
}

function create_hotspots(div) {
	$(div).style.cursor='pointer';
	$(div).onclick = function() {
		document.location='http://planetozh.com/blog/';
	}
	$(div).title = "Back to the roots ! -> http://planetozh.com/blog/";
}


/* Paypalification of links with class="donation"
 ********************************************************************/

function paypalification_init() {
	elements = document.getElementsByClassName('donation');
	$A(elements).each(function(el){
		if (el.nodeName == 'A') {
			el.onclick=function(){paypalification(el);return false;};
		}
	});
	elements = document.getElementsByTagName('a');
	$A(elements).each(function(el){
		if ( ( /planetozh.com\/download/.test(el.href) || /downloads.wordpress.org\/plugin\//.test(el.href) ) && ! el.hasClassName('nopaypal')) {
                        el.onclick=function(){paypalification(el);return false;};
                }
        });
}

function paypalification(el) {
	ppbutton = '<div style="background:#ffd;border:1px solid #ff6;padding:0.3em 1em"><p><strong><em>Is it worth one or two dollars ?</em> Any donation is appreciated and keeps me motivated ! Thank you for your support!</strong></p>'+
	'<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_xclick" />'+
	'<input type="hidden" name="business" value="ozh@planetozh.com" />'+
	'<input type="hidden" name="item_name" value="PlanetOzh Wordpress Plugins and Stuff" />'+
	'<input type="hidden" name="no_note" value="1" />'+
	'<input type="hidden" name="currency_code" value="USD" />'+
	'<input type="hidden" name="tax" value="0" />'+
	'<input type="hidden" name="bn" value="PP-DonationsBF" />'+
	'<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" border="0" name="submit" alt="Donation via PayPal : fast, simple and secure!"/>'+
	'</form></div>';
	if (!arguments.callee.stopBegging) {
	        new Insertion.After(el.parentNode.lastChild, ppbutton);
		arguments.callee.stopBegging = true;
		//alert("Thanks for downloading my stuff. Please consider a donation if you find this open-source software useful!");
	}
	var newWindow = window.open(el.getAttribute('href'), '_blank');
	newWindow.focus();
	return false;
}

/* Gallery Ajaxizification
 ********************************************************************/

function galajax_start() {
	if (!$('galleryctrl')) return;
	$('galleryctrl').innerHTML += '<span id="reloadpics" title="Load another set of random pictures">Another 4 images!</span>';
	$('reloadpics').onclick = function() {
		galajax_call();
	}
}

function galajax_call() {
	/* pretty loading icon for everyone */
	for (var x = 1; x <=4; x++) {
		img0 = $('galimg'+x).getElementsByTagName('img')[0];
		img1 = $('galimg'+x).getElementsByTagName('img')[1];
		loader = '#E4F2FD url('+planetozh_path+'/images/ajax-flower.gif) center center no-repeat';
		img0.style.background = loader;
		img1.style.background = loader;
	};
	
	/* make ajax request to get 4 new image data set */
	new Ajax.Request(
		'/gallery/4images-ajax.php',
		{onSuccess: function(transport){
      eval( 'images = (' + transport.responseText + ')' );
      galajax_parse(images);
    }});
}

function galajax_parse(images) {
	/* parse data set. Yeah, I think I didn't totally understood JSON :P */
	preload = [];
	for (var x = 0; x <= 3; x++) {
		preload[x] = new Image(); 
		preload[x].src = images.Images[x].src;
		preload[x]['title'] = images.Images[x].title;
		preload[x]['link'] = images.Images[x].href;
		preload[x]['idx'] = x;
		preload[x].onload = function() {
			/* don't update right now the image : if the file hasnt been downloaded completely, it will show
			an empty image for a few seconds. So we're waiting for the src onload before ! Now that's cool ! */
			galajax_update(this.idx,this.src,this.title,this.link);
		};
	}
}

function galajax_update(i,src,title,href) {
	y = i + 1;
	link = $('galimg'+y).getElementsByTagName('a')[0];
	img0 = $('galimg'+y).getElementsByTagName('img')[0];
	img1 = $('galimg'+y).getElementsByTagName('img')[1];
	img0.style.background = 'url('+src+') repeat scroll 50% 50%';
	img1.style.background = 'url('+src+') repeat scroll 50% 50%';
	img0.alt = title;
	img1.alt = title;
	link.href=href;
	link.title = title;
}


/* Load & Unload
 ********************************************************************/

Event.observe(window, 'load', function() {
	setTimeout(function(){galajax_start();}, 1000);
	create_hotspots('extradiv1');
	create_hotspots('extradiv2');
	paypalification_init();
});

