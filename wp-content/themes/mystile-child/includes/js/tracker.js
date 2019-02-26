//initiate jquery
jQuery(document).ready(function($){
$(document).ready(function(){
  
  //get order id from the search order textbox and run get function to database
    $("button").click(function(){
     //retrive order id
      orderid=document.getElementById("orderid").value;
       
      //run http get with user order number and read only user key
      $.get("https://www.kioski.co/wc-api/v3/orders/"+orderid+"?filter[meta]=true&consumer_key=ck_e6d3f3e923a9e33a75c4415792c75251082aceea&consumer_secret=cs_7d5c16fd0cfb77b426261d8e3fcfe12c9018250e", function(data, status){
      //parse json    
      var json = data;
      
      //check delivery status and dsiaply infomration depening of order status
      deliverystatus = data.order.order_meta.delivery_status;
      
      if (deliverystatus == "pending")
       {
       document.getElementById('info').innerHTML = "<center>We are still processing your order. We will notify you when your package is in transit.</center>";
       } 
      
      if (deliverystatus == "completed")
       {
       document.getElementById('info').innerHTML = "<center> This order has already been delivered. If you didnt not get this delivery contact us.</center>";
       } 
      
      if (deliverystatus == "in_progress")
      {
  //if order status is in progress then retrive courier location
        
  //initiate pouchDB and connection with cloudant, watch changes in remote cloudant location data and update location of the map
  var p = 'https://kioski.cloudant.com/locationtracker';
  var db = new PouchDB(p);
  db.changes({include_docs: true, live:true}).on('change', updateMovingLayer);

  document.getElementById('info').innerHTML = "<h1><center>Courier Location</center></h1>";
  var map = L.map('map').setView([42.36, -71.1], 10);

  //call mapbox API with the key
  L.tileLayer('https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoia2lvc2tpIiwiYSI6ImNpbG1hdjFqbDAwNDA3bG00MTJwNGtmN2wifQ.QsXYYs-8mnEXzDprXfknZg', {
    maxZoom: 18,
    attribution: 'Map data &copy; ' +
      '<a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
      '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    detectRetina: true,
    id: 'examples.map-20v6611k'
  }).addTo(map);

  var movementLayer = L.geoJson().addTo(map);

//function to update location on map
  function updateMovingLayer(change) {
    if ( !change.doc._deleted && change.doc.type == 'Feature' ) {
      movementLayer.clearLayers();
      movementLayer.addData(change.doc);
      map.fitBounds(movementLayer.getBounds());
    }
  }
      
      }      
 //if 404 is returned then order doesnt exist     
        }).fail(function() {
         document.getElementById('info').innerHTML = "<center> This order doesn't seem to exist in our records. Please recheck the order number. For futher assistance contact us</center>";
    
       });
  });
    });
});