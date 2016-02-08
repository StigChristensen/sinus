<?php ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer-bar"></div>
    <div class="footer-content">
      <div class="footer-left" itemscope itemtype="http://schema.org/Organization">
        <address class="store-address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
          <h4 itemprop="name">Sinus</h4>
          <p itemprop="name">Headphones & Audio</p>
          <span itemprop="streetAddress">Studiestræde 24, Kld.</span><br>
          <span itemprop="addressRegion">DK-1455 København</span><br>
          <span itemprop="phoneNumber">TLF:</span>
        </address>
        <a href="mailto:info@sinus-store.dk" itemprop="email"><p>info@sinus-store.dk</p></a><br>

      </div>
      <div class="footer-right">
        <a href="/handelsvilkaar/">Handelsvilkår</a><br>
        <a href="/om-os/">Om os</a><br>
      </div>
    </div>

    <div class="map" id="storemap"></div>

    <address class="sub" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
      <span itemprop="name">Sinus IVS / </span>
      <span itemprop="streetAddress">Nygårdsvej 51B / </span>
      <span itemprop="addressRegion">2100 København Ø / </span>
      <span itemprop="cvr">CVR: 36 97 80 90</span>
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
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#222222"
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
                "color": "#222222"
            },
            {
                "visibility": "off"
            },
            {
                "lightness": "0"
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
                "color": "#f2f2f2"
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
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "on"
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
                "lightness": "10"
            },
            {
                "weight": "0.69"
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
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
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
                "weight": "1.02"
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
                "lightness": "20"
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
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "lightness": "1"
            },
            {
                "visibility": "on"
            },
            {
                "hue": "#0094ff"
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

  function initMap() {
    map = new google.maps.Map(document.getElementById('storemap'), {
      center: latLng,
      zoom: 15,
      styles: mapStyle
    });

    var marker = new google.maps.Marker({
      position: latLng,
      map: map,
      title: 'Sinus | Headphones & Audio'
    });
  }
</script>


<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBximfg0rd87DHoY81hlIIDwBGefaGPG8I&callback=initMap">
</script>

</body>
</html>
