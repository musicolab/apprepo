export var gUser = "test";
var THEUSER = "test";

function _1(md){
	return(md``)
}


function _chart(l,n,d3,width,height,color,drag,invalidation) {
	const links = l.map(d => Object.create(d));
	const nodes = n.nodes.map(d => Object.create(d));
	const nn = nodes.map(n => {
		const red = d3.randomInt(1, 256)();
		const green = d3.randomInt(1, 256)();
		const blue = d3.randomInt(1, 256)();
		const alpha = Math.random();
		return { color: d3.rgb(red, green, blue, alpha) };
	});

  var div = d3.select("body").append("div").attr("class", "tooltip").style("opacity", 0);
  
  const gethtml = (id, links) => {
	return `<div><font face="Helvetica" size="3px" color="##FFC300"><b>Audio File</b>:</font> <font face="Helvetica" size="3px" >${id}</font></div> 
           	<div><font face="Helvetica" size="3px" color="##FFC300"><b>Similarity</b>:</font> <font face="Helvetica" size="3px" >${links}</div></div> 
           	<audio controls>
              		<source src="jazz_1.ogg" type="audio/ogg"> <source src="jazz_1.mp3" type="audio/mpeg">
		</audio>`;
  }

  function toString2() { return this.url; }

  /*
  const simulation = d3.forceSimulation(nodes)
      ///.force("link", d3.forceLink(links).id(d => d.id))
      //Here you can change the line attributes - PZ
      .force("link", d3.forceLink(links).id(function (d) {return d.id;}).distance(100).strength(1))
      .force("charge", d3.forceManyBody())
      .force("center", d3.forceCenter(width / 2, height / 2));
  */
  var simulation = d3.forceSimulation(nodes,links)
    .force("link", d3.forceLink(links).distance(
	function(d){ 
		console.log(d); 
		let src = d.source.index;
		let tar = d.target.index;
		console.log("nodes");
		console.log(nodes);
		let user = new URLSearchParams(window.location.search).get('user');
		console.log("user = ",user);
		let req = new XMLHttpRequest();
		req.open("GET", "https://musicolab.hmu.gr/apprepository/files/distanceNetwork_"+user+".json", false);
		req.send();
		console.log("response");
		console.log(req.responseText);
		let w = JSON.parse(req.responseText);
		console.log("src="+src);
		console.log("tar="+tar);
		console.log("- w["+tar+"]="+w.nodes);
		console.log("- w["+tar+"]="+JSON.stringify(w.nodes[1,tar]));
		console.log("- w["+tar+"]="+JSON.stringify(w.nodes[1,tar].weight));
		//return Math.floor(Math.random() * 200) + 10; 
		return JSON.stringify(w.nodes[1,tar].weight)*200+10;
	}).id(d => d.id))
    //.force("link", d3.forceLink(links).distance(function(d) { return 100) } ).id(d => d.id) )
    //.force("link", d3.forceLink(links).distance(linkDistance).strength(1))
    .force("charge", d3.forceManyBody())
    .force("center", d3.forceCenter(width / 2, height / 2));

function linkDistance() {
	//console.log("nodes");
	//console.log(nodes);
	//console.log("links");
	console.log(d);
	return Math.floor(Math.random() * 200) + 10;
}


  const svg = d3.create("svg").attr("viewBox", [0, 0, width, height]);

  const link = svg.append("g")
      .attr("stroke", "#999")
      .attr("stroke-opacity", .6)
      .selectAll("line")
      .data(links)
      .join("line")
      .attr("stroke-width", d => Math.sqrt(d.weight));

  const node = svg.append("g")
      .attr("stroke", "#fff")
      .attr("stroke-width", 1.5)
      .selectAll("circle")
      .data(nodes)
      .join("circle")
      //Here you can change the node attributes - PZ
      .attr("r", d => Math.sqrt(d.weight)+2)
      .attr("fill", d => color(d))
      .on('mouseover', function (d, i) {
          d3.select(this).transition().duration('50').attr('opacity', '.85');
          div.transition().duration(50).style("opacity", 1);
          let num = 50;
          div.html(gethtml(d.id,d.weight))
               .style("left", (d3.event.pageX + 10) + "px")
               .style("top", (d3.event.pageY - 15) + "px");
     })
    
     .on('mouseout', function (d, i) {
		//event.target.style.color = "orange";
          	d3.select(this).transition().duration('50').attr('opacity', '1');
		div.transition().duration('2050').style("opacity", 0);
     })
     .call(drag(simulation));

  // node.append("title")
  //     .text(d => d.id);

  simulation.on("tick", () => {
    link
        .attr("x1", d => d.source.x)
        .attr("y1", d => d.source.y)
        .attr("x2", d => d.target.x)
        .attr("y2", d => d.target.y);

    node
        .attr("cx", d => d.x)
        .attr("cy", d => d.y);
  });

  invalidation.then(() => simulation.stop());

  return svg.node();
}


function _l(FileAttachment){
	return(FileAttachment("distanceLinks_"+THEUSER+".json").json());
}

function _n(FileAttachment){
	return(FileAttachment("distanceNetwork_"+THEUSER+".json").json())
}

function _style(html){return(
html`<style>

div.tooltip {
     position: absolute;
     text-align: left;
     padding: .5rem;
     background: #FFFFFF;
     color: #313639;
     border: 1px solid #313639;
     border-radius: 8px;
     pointer-events: none;
     font-size: 1.3rem;
}

</style>`
)}

function _height(){return(
600
)}

function _color(d3)
{
  const scale = d3.scaleOrdinal(d3.schemeCategory10);
  return d => scale(Math.sqrt(d.weight));
}


function _drag(d3){return(
simulation => {
  function dragstarted(d) {
    if (!d3.event.active) simulation.alphaTarget(0.3).restart();
    d.fx = d.x;
    d.fy = d.y;
    
  }
  
  function dragged(d) {
    d.fx = d3.event.x;
    d.fy = d3.event.y;
  }
  
  function dragended(d) {
    if (!d3.event.active) simulation.alphaTarget(0);
    d.fx = null;
    d.fy = null;
  }
  
  return d3.drag()
      .on("start", dragstarted)
      .on("drag", dragged)
      .on("end", dragended);
}
)}

function _d3(require){
		return(
			require("d3@5", 'd3-random')
		)
}

export function setGUser(runtime, val){
	const main = runtime.module();
	main.variable(observer("gUser"), val);
	console.log("setting gUser to "+val);
	console.log(main);
}

export default function define(runtime, observer) {
	const urlParams = new URLSearchParams(window.location.search);
	const user = urlParams.get('user')
	THEUSER = user;
	const main = runtime.module();
	console.log(gUser);

	function toString() { return this.url; }
	const fileAttachments = new Map([
		["distanceNetwork_"+user+".json", {url: new URL("./files/distanceNetwork_"+user+".json", import.meta.url), mimeType: "application/json", toString}],
		["distanceLinks_"+user+".json", {url: new URL("./files/distanceLinks_"+user+".json", import.meta.url), mimeType: "application/json", toString}]
	]);

	main.builtin("FileAttachment", runtime.fileAttachments(name => fileAttachments.get(name)));
	main.variable(observer("info")).define(["md"], _1);
	main.variable(observer("chart")).define("chart", ["l","n","d3","width","height","color","drag","invalidation"], _chart);
	main.variable(observer("l")).define("l", ["FileAttachment"], _l);
	main.variable(observer("similarity")).define("n", ["FileAttachment"], _n);
	main.variable(observer("style")).define("style", ["html"], _style);
	main.variable(observer("height")).define("height", _height);
	main.variable(observer("color")).define("color", ["d3"], _color);
	main.variable(observer("drag")).define("drag", ["d3"], _drag);
	main.variable(observer("d3")).define("d3", ["require"], _d3);
	//return main;
}
