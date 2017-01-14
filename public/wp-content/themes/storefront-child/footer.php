<?php // Footer ?>

	</div>

	<div class="bottom-info">
		<h2>Værd at vide... </h2>
		<div class="left">
			<div class="binfo-element">
				<span>Ved køb over 1000kr får du fri fragt.</span>
			</div>
			<div class="binfo-element">
				<span>Du kan få varen leveret til nærmeste Postnord Boks. Du kan også få sendt varen direkte til dig eller til din arbejdsplads</span>
			</div>
			<div class="binfo-element">
				<span>Er varen ikke på lager, kan vi typisk få den hurtigt (muligvis fra dag til dag). Det afhænger af leverandøren og varen. Vi kontakter dig med en leveringstid. Du er også velkommen til at <a href="mailto:info@sinus-store.dk">kontakte</a> os.</span>
			</div>
		</div>
		<div class="right">
			<div class="binfo-element">
				<span>Ordrer indgået inden kl 16.00 bliver afsendt samme dag, hvis alle varer er på lager.</span>
			</div>

			<div class="binfo-element">
				<span>Har du spørgsmål til varen, leveringstid eller andet, er du altid velkommen til at kontakte os. Enten på <a href="mailto:info@sinus-store.dk">mail</a>, eller på <a href="tel:+4561458215">telefon: 61 45 82 15</a>.</span>
			</div>
		</div>
	</div>


	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-content">
      <div class="footer-left" itemscope itemtype="http://schema.org/Organization">

        <address class="store-address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
          <h4 itemprop="name">Sinus</h4>
          <p itemprop="name">Headphones & Audio</p>
          <span>TLF:<a href="tel:+4561458215" itemprop="phoneNumber">(+45) 61 45 82 15</a></span>
        </address>
        <a href="mailto:info@sinus-store.dk" itemprop="email"><p>info@sinus-store.dk</p></a><br>

      </div>


      <div class="footer-right">
        <a class="social" href="https://www.facebook.com/sinusstore"><i class="fa fa-facebook"></i> Facebook</a><br>
				<a class="social" href="https://www.instagram.com/sinus_headphones/"><i class="fa fa-instagram"></i> Instagram</a><br>
      	<a class="text" href="/handelsvilkaar/">Handelsvilkår</a><br>
        <a class="text link-last" href="/om-os/">Om os</a><br>

      </div>
		</div>

    <address class="sub" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
      <span itemprop="name">Sinus IVS / </span>
      <!-- <span itemprop="streetAddress">Studiestræde 24, kld. th. / </span> -->
      <!-- <span itemprop="addressRegion">1455 København K / </span> -->
      <span>CVR: 36 97 80 90</span>
    </address>

  </footer>

<?php wp_footer(); ?>

<script>
  var map;
  var latLng = {lat: 55.6784273, lng: 12.5685762};

  var mapStyle = [
    {
        "featureType": "all",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#2b2b2b"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "labels.text",
        "stylers": [
            {
                "color": "#FAFAFA"
            },
            {
                "visibility": "off"
            },
            {
                "lightness": "10"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.land_parcel",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#2b2b2b"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "off"
            },
            {
                "color": "#ff0000"
            }
        ]
    },
    {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "simplified"
            },
						{
                "color": "#2b2b2b"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": -200
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "off"
            },
						{
                "color": "#ABABAB"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "simplified"
            },
            {
                "lightness": "15"
            },
            {
                "weight": "15"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "off"
            },
            {
                "color": "#acb1b0"
            },
            {
                "lightness": "5"
            },
            {
                "weight": "1"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "off"
            },
            {
                "color": "#4fd5ca"
            },
            {
                "lightness": "25"
            },
            {
                "weight": "1"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#4fd5ca"
            },
            {
                "lightness": "25"
            },
            {
                "weight": "1"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#4fd5ca"
            },
            {
                "lightness": "15"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "lightness": "10"
            },
						{
                "color": "#CCCCCC"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "lightness": "10"
            },
            {
                "visibility": "on"
            },
            {
                "hue": "#FFF"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#4fd5ca"
            },
            {
                "visibility": "on"
            }
        ]
    }
];

  // function initMap() {
  //   map = new google.maps.Map(document.getElementById('storemap'), {
  //     center: latLng,
  //     zoom: 16,
  //     styles: mapStyle
  //   });
  //
  //   var marker = new google.maps.Marker({
  //     position: latLng,
  //     map: map,
  //     title: 'Sinus | Headphones & Audio'
  //   });
  //
	// 	var largeMap = document.getElementById('largemap');
  //
	// 	if ( largeMap ) {
	// 		fpMap = new google.maps.Map(document.getElementById('largemap'), {
	//       center: latLng,
	//       zoom: 16,
	//       styles: mapStyle
	//     });
  //
	//     var marker = new google.maps.Marker({
	//       position: latLng,
	//       map: fpMap,
	//       title: 'Sinus | Headphones & Audio'
	//     });
	// 	}
  // }
</script>


<!-- <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBximfg0rd87DHoY81hlIIDwBGefaGPG8I&callback=initMap">
</script> -->

</body>
</html>
