// ONTHOUD VORIGE WAARDES
let missieOldText = document.getElementById('missie').innerHTML;
let visieOldText = document.getElementById('visie').innerHTML;
let strategieOldText = document.getElementById('strategie').innerHTML;

// AJAX MISSIE
function loadMissie() {
    document.getElementById("btnMissie").style.display = "none";
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("missie").innerHTML = this.responseText;
    }
    xhttp.open("GET", "site/ajax_missie.html", true);
    xhttp.send();
    document.getElementById("btnMissieBack").style.display = "block";
}

function unloadMissie() {
    document.getElementById("btnMissieBack").style.display = "none";
    document.getElementById("missie").innerHTML = missieOldText;
    document.getElementById("btnMissie").style.display = "block";
}

// AJAX VISIE
function loadVisie() {
    document.getElementById("btnVisie").style.display = "none";
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("visie").innerHTML = this.responseText;
    }
    xhttp.open("GET", "site/ajax_visie.html", true);
    xhttp.send();
    document.getElementById("btnVisieBack").style.display = "block";
}

function unloadVisie() {
    document.getElementById("btnVisieBack").style.display = "none";
    document.getElementById("visie").innerHTML = visieOldText;
    document.getElementById("btnVisie").style.display = "block";
}

// AJAX STRATEGIE
function loadStrategie() {
    document.getElementById("btnStrategie").style.display = "none";
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("strategie").innerHTML = this.responseText;
    }
    xhttp.open("GET", "site/ajax_strategie.html", true);
    xhttp.send();
    document.getElementById("btnStrategieBack").style.display = "block";
}

function unloadStrategie() {
    document.getElementById("btnStrategieBack").style.display = "none";
    document.getElementById("strategie").innerHTML = strategieOldText;
    document.getElementById("btnStrategie").style.display = "block";
}

// Event listeners
document.getElementById('btnMissie').addEventListener('click', loadMissie);
document.getElementById('btnMissieBack').addEventListener('click', unloadMissie);
document.getElementById('btnVisie').addEventListener('click', loadVisie);
document.getElementById('btnVisieBack').addEventListener('click', unloadVisie);
document.getElementById('btnStrategie').addEventListener('click', loadStrategie);
document.getElementById('btnStrategieBack').addEventListener('click', unloadStrategie);


// CALCULATOR
// BEGIN STARTPAKKET
var startpakket = new Array();
startpakket["startpakket1"] = 12500;
startpakket["startpakket2"] = 15000;

function getStartpakket() {
  var startpakketRadio = document.getElementsByName("selectedpakket");

  for (i = 0; i < startpakketRadio.length; i++) {
    if (startpakketRadio[i].checked) {
      user_input = startpakketRadio[i].value;
    }
  }

  return startpakket[user_input];
}
// EIND STARTPAKKET

// BEGIN OPTIES
function getOptie1() {
  var optie1 = document.getElementById("optie1");

  if (optie1.checked) {
    return 1000;
  } else {
    return 0;
  }
}

function getOptie2() {
  var optie2 = document.getElementById("optie2");

  if (optie2.checked) {
    return 1000;
  } else {
    return 0;
  }
}

function getOptie3() {
  var optie3 = document.getElementById("optie3");

  if (optie3.checked) {
    return 1500;
  } else {
    return 0;
  }
}

function getOptie4() {
  var optie4 = document.getElementById("optie4");

  if (optie4.checked) {
    return 1500;
  } else {
    return 0;
  }
}
// EIND OPTIES

// BEGIN KILOMETERS
var kilometers = new Array();
kilometers["none"] = 0;
kilometers["10"] = 10;
kilometers["20"] = 20;
kilometers["30"] = 30;
kilometers["40"] = 40;
kilometers["50"] = 50;
kilometers["60"] = 60;
kilometers["70"] = 70;
kilometers["80"] = 80;
kilometers["90"] = 90;
kilometers["100"] = 100;

function getKilometers() {
  var kmSelect = document.getElementById('kilometers');

  return kilometers[kmSelect.value];
}
// EIND KILOMETERS

// BEGIN BEREKENEN TOTAALPRIJS
function calculateTotal() {
  var total = getKilometers() * (getStartpakket() + getOptie1() + getOptie2() + getOptie3() + getOptie4());
  var totalEl = document.getElementById('totalPrice');

  document.getElementById("totalPrice").innerHTML = "Totaalprijs: €" + total;
  totalEl.style.display = "block";
}
// EIND BEREKENEN TOTAALPRIJS
// EIND CALCULATOR

// MAPBOX: Voeg kaart en marker toe
mapboxgl.accessToken =
"pk.eyJ1IjoibnlhbmEiLCJhIjoiY2w5MDJ1aXAzMDBnMjNwbzV1dHl0bWNoYiJ9.WVgx1_ka8N6L36bMey947Q";
var map = new mapboxgl.Map({
  container: "map",
style: "mapbox://styles/mapbox/streets-v11",
center: [4.493162329367578, 51.908710828666244],
zoom: 15,
});
// Maak een nieuw marker object
const geojson = {
  type: 'FeatureCollection',
  features: [
    {
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: [4.493162329367578, 51.908710828666244]
      },
      properties: {
        title: 'Smartfalt HQ',
        description: 'Rotterdam, Nederland'
      }
    }
  ]
};
// Injecteer marker object op de kaart
for (const feature of geojson.features) {
  const el = document.createElement('div');
  el.className = 'smartfalt-hq-marker';
  new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map);
}
// /MAPBOX: Voeg kaart en marker toe

// LET OP: var's en Id's zijn hoofdlettergevoelig!