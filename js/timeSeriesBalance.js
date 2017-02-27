//var svg = d3.select("#contentline").append("contentline:svg");
var margin = {top:40, right:20, bottom:60, left: 50},
    width = 1200 - margin.left - margin.right,
    height = 300 - margin.top - margin.bottom;
//var g = svg.append("g").attr("tranform","translate(" + margin.left + "," + margin.top + ")");

var parseTime = d3.time.format("%Y-%m-%d %H:%M:%S").parse;

var x = d3.time.scale()
    .range([0, width]);
var y = d3.scale.linear()
    .range([height, 0]);

//var x = d3.scale.linear().range([margin.left, width - margin.right]).domain([2000,2010]);

var xAxis = d3.svg.axis().scale(x)
    .orient("bottom")
    .ticks(20)
    .tickFormat(d3.time.format("%y-%m-%d"));

var yAxis = d3.svg.axis().scale(y)
    .orient("left").ticks(5);
 

var line = d3.svg.line()
    .x(function(d) { return x(d.time); })
    //.y(function(d) { return y(d.rich_checking); });
    .y(function(d) { return y(d.current); });
    //.interpolate("cardinal");


var svg = d3.select("#contentline")
    .append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom);


var tip = d3.tip()
    .attr("class","d3-tip")
    .style("fill","black")
    .html(String);

svg.call(tip);

var g = svg.append("g")
    .attr("transform", 
	  "translate(" + margin.left + "," + margin.top + ")");


//d3.json("data/getTimeSeriesBalance.php", function(error, data) {
d3.json("data/getTimeSeriesBalance2.php", function(error, data) {

	data.forEach(function(d) {
		d.time = parseTime(d.time);
		//d.rich_checking = +d.rich_checking;
		d.current = +d.current;
	    });


	x.domain(d3.extent(data, function(d) { return d.time; }));
	//y.domain(d3.extent(data, function(d) { return d.rich_checking; }));		  
	y.domain(d3.extent(data, function(d) { return d.current; }));		  
		  
	g.append("path")
	    .attr("d", line(data))
	    .attr("stroke","green")
	    .attr("stroke-width", 6)
	    .attr("fill", "none");
	
	
	g.selectAll("dot")
	    .data(data)
	    .enter().append("circle")
	    .attr("r",5)
	    .attr("cx", function(d) { return x(d.time); })
	    //.attr("cy", function(d) { return y(d.rich_checking); })
	    .attr("cy", function(d) { return y(d.current); })
	    .on('mouseover', function(d, i) { 
		    tip.show('$'+d["amount"]+' for '+d["type"]+'\n Current balance of '+'$'+d["current"]+'   {'+d["time"]+'}');
		    //d3.json("data/getTimeSeriesBalance.php", function(error, data) {
		    /*
		    d3.xhr("data/getPointData.php")
			.header("Content-Type", "application/json")
			.post(
			      JSON.stringify({time: d.time}),
			      function(err, rawData){
				  var data2 = JSON.parse(rawData);
				  console.log("got response", data2);				  
			      });
		    */
		    //	};
		    
		})
	    .on('mouseout', tip.hide);

	g.append("g")
	    .attr("class","axis")
	    .attr("transform", "translate(0,200)")
	    .call(xAxis)
	    .selectAll("text")
	    .style("text-anchor","end")
	    .style("font-size", 16)
	    .attr("dx","-.8em")
	    .attr("dy","-.55em")
	    .attr("transform","rotate(-45)");

	g.append("g")
	    .attr("class","axis")
	    .call(yAxis)
	    .selectAll("text")
	    .attr("transform", "rotate(-90)")
	    .attr("y", 6)
	    .attr("dy", "-.90em")
	    .style("text-anchor", "end")
	    .style("font-size", 16);

    });

