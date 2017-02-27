d3.json("data/getMoneyInAndOut.php", function(error, data) {
	
	/*
	svg.append("text") // ACUITY CATEGORY TITLE //
	    //.attr("class", "li")
	    //.attr("x", 1)
	    //.attr("y", 24 )
	    .text(function(d) { return data["rich_checking"];})
	    .attr("x", 50)
	    .attr("y", 50)
	    .attr("fill","black");
	*/

	function tabulate(data, columns){
	    var table = d3.select('#content3').append('table')
		.attr("style","margin-left:0px");
	    var thead = table.append('thead');
	    var tbody = table.append('tbody');
	    
	    thead.append('tr')
		.selectAll('th')
		//.data(columns).enter()
		//.data(['account','amount']).enter()
		.append('th')
		.text(function(column) { return column;})
		//.attr("x", 50)
		//.attr("y", 50)
		//.attr("fill","black");

	    var rows = tbody.selectAll('tr')
		.data(data)
		.enter()
		.append('tr');

	    var cells = rows.selectAll('td')
		.data(data)
		.data(function(row){
			return row;
		    })
		//return columns.map(function(column){
		//	return {column: column, value: row[column]};
		// });
		//  })
		.enter()
		.append('td')
		.text(function(d) {return d;})
		//.attr("x", 50)
		//.attr("y", 50)
		//.attr("fill","black");

	    return table;
	}


	/*
	  {id: 1, rich_checking: 5, mel_checking: 6}
	  
	  ==>
	  
	  [{id: 1},{rich_checking: 5},{mel_checking: 6}] 
	 */

	//tabulate(data, ['id','rich_checking','rich_savings','melissa_checking','luna_savings','miles_savings','time','total','cash']);
	tabulate(data, ['','']);

    });