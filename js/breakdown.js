var width = 350,
    height = 250,
    radius = Math.min(width, height) / 2;


var color = d3.scale.category20();
//var color = d3.scale.ordinal()
//    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

var arc = d3.svg.arc()
    .outerRadius(radius - 5)
    .innerRadius(radius - 50);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.total; });

var svg = d3.select("#content2").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

d3.json("data/getBreakdown.php", function(error, data) {
	/*
	function change() {
	    d3.json("data/getBreakdown.php", function(data2){
		    var sel = d3.select("#projection-menu").property("value");
		    d3.selectAll("div").remove();
		    var data = _.where(data2, {total: sel});
		})};


	//Dropdown Menu
	var a = ["Select one"];
	
	var month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	var year = [2010,2011,2012,2013,2014,2015,2016,2017,2018,2019];

	month.forEach(function(d) {
		a.push(d)
		    });
	
	//var arrayUnique = _.uniq(a);
	
	var options = month;
	
	var menu = d3.select("#content2")
	    .on("change", change);

	menu.selectAll("option")
	    .data(options)
	    .enter().append("option")
	    .text(function(d) { return d;});
	*/
	
	var Sum = d3.sum(data, function(d) { return +d.total; });

	var tip = d3.tip()
	    .attr("class","d3-tip")
	    .style("fill","black")
	    .html(String);
	//.html(function(d) { return Math.round(d.data["total"]*100 / Sum) + '%'; });
	    //.attr("x",0)
	    //.attr("y",0);

	svg.call(tip);

	var g = svg.selectAll(".arc")
	    .data(pie(data))
	    .enter()
	    .append("g")
	    .attr("class","arc");

	g.append("path")
	    .attr("d", arc)
	    .style("fill", function(d, i) { return color(i) });

	g.append("text")
	    .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
	    .attr("dy",".35em")
	    .attr("dx","-.45em")
	    .style("fill","black")
	    .text(function(d) { return d.data["type"]; })
	    .on('mouseover', function(d, i) {
		    var temp = d.data["total"];
	    	    tip.show(Math.round(temp*100/Sum)+"%");

	    	    svg.append("text")
			.attr("id","breaker")
			.attr("class","breaker")
	    		.attr("x",0)
	    		.attr("y",10)
	    		//.html(function(d, i) { return data[i].total; });
			.html("$"+temp);
	 
		})
	    //.on('mouseover',tip.show)
	    .on('mouseout', function(d) {
		    tip.hide();
		    svg.select("#breaker").remove();
		});
	/*
	var a = d3.select("#content2")
	    .append("text")
	    .html("Total Spending:");
	*/
	var b = d3.select("#content2")
	    .append("text")
	    .attr("id","breaker")
	    .attr("class","breaker")
	    .html("$"+Sum);


    });