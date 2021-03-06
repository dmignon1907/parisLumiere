<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<style>
  
html, body {
  width: 100%;
  height: 100%;
  margin: 15;
  margin-right: 30;
}

#map {
  width: 100%;
  height: 100%;
  margin: 15;
  margin-right: 30;
}
    
.stations, .stations svg {
  position: absolute;
}
    
.stations svg {
  width: 60px;
  height: 20px;
  padding-right: 100px;
  font: 10px sans-serif;
}
.stations circle {
  fill: brown;
  stroke: black;
  stroke-width: 1.5px;

}
.tooltip {
  position: absolute;
  line-height: .7;
  font-weight: bold;
  padding: 8px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  font-weight: bold;
  font: 11.5px sans-serif;
  border-radius: 2px;
  pointer-events: none;  

}
</style>
<div id="map"></div>
<script src="//maps.google.com/maps/api/js?librairies=place&key=AIzaSyDsYwvF3UUxTx8RB40wd4SnUVzfnbW66LM"></script>
<script src="//d3js.org/d3.v4.min.js"></script>
<script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
<script>
var format = d3.timeParse("%Y-%m-%d");
// Create the Google Map…
var map = new google.maps.Map(d3.select("#map").node(), {
  draggableCursor: 'crosshair',
  zoom: 12,
  center: new google.maps.LatLng(48.866667, 2.333333),
  mapTypeId: google.maps.MapTypeId.TERRAIN
});
// Load the station data. When the data comes back, create an overlay.
d3.json("data/tournagesdefilmsparis2011.json", function(error, data) {
  if (error) throw error;
  var overlay = new google.maps.OverlayView();
    
  // Add the container when the overlay is added to the map.
  overlay.onAdd = function() {
    var tooltip = d3.select(this.getPanes().overlayLayer).append("div")
        .attr("class", "tooltip")
				.style("opacity", 0);
    var layer = d3.select(this.getPanes().overlayMouseTarget).append("div")
        .attr("class", "stations")
         
    // Draw each marker as a separate SVG element.
    // We could use a single SVG, but what size would it have?
    overlay.draw = function() {
            
      var projection = this.getProjection(),
          padding = 10;
      var marker = layer.selectAll("svg")
          .data(d3.entries(data))
          .each(transform) // update existing markers
        	.enter().append("svg")
          .each(transform)
          .attr("class", "marker");
      var tooltip = d3.select("body")
        .append("div")
        .attr("class", "tooltip")
        .style("opacity", 0);
      // Add a circle.
      marker.append("circle")
          .attr("r", 8)
          .attr("cx", padding)
          .attr("cy", padding)
      		.style("fill", function(d){
          var jour=format(d.value.fields.date_debut).getDay() + 30*format(d.value.fields.date_debut).getMonth(); return d3.interpolateRdBu(jour/370)})
      		.on("mouseover", function(d) {
              tooltip.transition()
                .duration(200)
                .style("opacity", .9);
              tooltip.html('Titre : '+d.value.fields.titre+'<br>'+'Réalisateur'+d.value.fields.realisateur+'<br>'+"Date de début : "+d.value.fields.date_debut+'<br>'+"Date de fin : "+d.value.fields.date_fin)
                .style("left", (d3.event.pageX + 5) + "px")
                .style("top", (d3.event.pageY - 28) + "px");
      	})
     	.on("mouseout", function(d) {
          tooltip.transition()
          .duration(200)
          .style("opacity", 0);
      });
      
      function transform(d) {
        if(!(typeof d.value.fields.xy === "undefined")){
        d = new google.maps.LatLng(d.value.fields.xy[0],d.value.fields.xy[1]);
        d = projection.fromLatLngToDivPixel(d);
        return d3.select(this)
            .style("left", d.x - padding + "px")
            .style("top", d.y  - padding + "px");
        }
      }
    };
  }
  // Bind our overlay to the map…
  overlay.setMap(map);
});
 
 </script>
