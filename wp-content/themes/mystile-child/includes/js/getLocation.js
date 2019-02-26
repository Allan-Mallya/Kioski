var x = document.getElementById("demo");
var latitude;
var longitude;

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
    //calculate distance from the store
    storelatitude = -1.218566;  
    storelongitude= 36.879185299999996;
    
    p = 0.017453292519943295;
    c = Math.cos;
    a = 0.5 - c((storelatitude - latitude) * p)/2 +
            c(latitude * p) * c(storelatitude * p) *
            (1 - c((longitude - storelongitude) * p))/2;
    d = 12742 * Math.asin(Math.sqrt(a)); // 2 * R; R = 6371 km
    distance= d.toFixed(1);
  
    //reversegeocoding to get address details
    $.get("https://maps.googleapis.com/maps/api/geocode/json?latlng="+latitude+","+longitude+"&key=AIzaSyBDEHonAaVf0douP3tdO5f5snt-KU-oMZQ").then(
             function(returnedData){
       add1 = (returnedData.results[0].address_components[0].short_name);
       add2 = (returnedData.results[0].address_components[1].short_name); 
       add3 = (returnedData.results[0].address_components[2].short_name);
       window.location="http://kioski.co/checkout/?lat="+latitude+"&long="+longitude+"&distance="+"&add1="+add1+"&add2="+add2+"&add3="+add3;
       
        }, function(err){
             console.log(err);
         })
  
  
  
  




}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}
  
  


