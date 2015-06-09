<!doctype html>
<html class="no-js" lang="">
  <head>
  <title></title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
        $("#departement").change(function() {
        $("select#departement option:selected").each(function() {
            if($(this).val() != 0) {
                var request = $.ajax({
                  url: "includes/function.php",
                  method: "POST",
                  data: { val_dep_ajax : $(this).val(), val_dep_function_ajax: 'moteur_de_recherche_ville' },
                  dataType: "html"
                });   
               request.done(function(msg) {
                  $("select#ville").html(msg);
                });
            }
          else {
                $("select#ville").html("<option value='0'>Séclionnez en premier lieu un département</option>");
            }
        });
        });
        })
        </script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.
      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
      function initialize() {
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
        /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
        { types: ['geocode'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
        fillInAddress();
        });
      }

      // [START region_fillform]
      function fillInAddress() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();

      for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
        }
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById(addressType).value = val;
          }
        }
      }
      // [END region_fillform]

      // [START region_geolocation]
      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = new google.maps.LatLng(
                position.coords.latitude, position.coords.longitude);
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
      // [END region_geolocation]
    </script>
    <style>
      #locationField, #controls {
        position: relative;
        width: 480px;
      }
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }
      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
      }
      #address {
        border: 1px solid #000090;
        background-color: #f0f0ff;
        width: 480px;
        padding-right: 2px;
      }
      #address td {
        font-size: 10pt;
      }
      .field {
        width: 99%;
      }
      .slimField {
        width: 80px;
      }
      .wideField {
        width: 200px;
      }
      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
    </style>
  </head>
  <body onload="initialize()">
    <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->        
    <form action="recherche.php" method="post" id="moteur">
      <div id="locationField">
        <input id="autocomplete" name="question" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
      </div>
      <table id="address">
        <tr>
          <td class="label">Street address</td>
          <td class="slimField">
            <input class="field" name="address_number" id="street_number" disabled="true"></input>
          </td>
          <td class="wideField" colspan="2">
            <input class="field" id="route" name="address_street" disabled="true"></input>
          </td>
        </tr>
        <tr>
          <td class="label">City</td>
          <td class="wideField" colspan="3">
            <input class="field" id="locality" name="address_city" disabled="true"></input>
          </td>
        </tr>
        <tr>
          <td class="label">State</td>
          <td class="slimField">
            <input class="field" id="administrative_area_level_1" disabled="true"></input>
          </td>
          <td class="label">Zip code</td>
          <td class="wideField">
            <input class="field" name="address_postal_code" id="postal_code" disabled="true"></input>
          </td>
        </tr>
        <tr>
          <td class="label">Country</td>
          <td class="wideField" colspan="3">
            <input class="field" id="country" disabled="true"></input>
          </td>
        </tr>
      </table>
      <input type="submit" id="recherche" name="envoi" value="ok"/>
    </form>
    
    <?php include ('includes/function.php');?>
    <?php include ('includes/form_departement.php');?>
		<?php include('liste.php');?>
    <p>Derniers avis de la Communauté :</p>
    <?php include('last_comment.php');?>

		
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='https://www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X','auto');ga('send','pageview');
    </script>
  </body>
</html>
