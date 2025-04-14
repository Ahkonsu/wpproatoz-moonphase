// JavaScript Document
<!-- Moon Phase Start -->
     
<!--hide
// cloned from very old opensource script converted to wordpress plugin
function showMoon() {
var height=1
var size = 40
var i
var currentDate  = new Date()
// Convert it to GMT
	currentDate.setTime(currentDate.getTime() + (currentDate.getTimezoneOffset()*60000))
// Get Date (GMT) for recent full moon
// NOTE: months, hours, and minutes are 0 based
var blueMoonDate = new Date(96, 1, 3, 16, 15, 0)
// Compute length of lunar period -- source: World Almanac
var lunarPeriod  = 29*(24*3600*1000) + 12*(3600*1000) + 44.05*(60*1000)
var moonPhaseTime = (currentDate.getTime() - blueMoonDate.getTime()) % lunarPeriod
// alert("Moon phase in days = "+moonPhaseTime/(24*3600*1000))
// Compute various percentages of lunar cycle
var percentRaw = (moonPhaseTime / lunarPeriod)
	// alert("% = "+percentRaw)
var percent    = Math.round(100*percentRaw) / 100
	// alert("% = "+percent)
var percentBy2 = Math.round(200*percentRaw)
var left  = (percentRaw >= 0.5) ? "../../../images/black.gif" : "../../../images/white.gif"
var right = (percentRaw >= 0.5) ? "../../../images/white.gif" : "../../../images/black.gif"
document.write("<center>")
	if (percentBy2 > 100) {
		percentBy2 = percentBy2 - 100
		}
	for (i = -(size-1); i < size; ++i) {
		var wid=2*parseFloat(Math.sqrt((size*size)-(i*i)));
		if (percentBy2 != 100)
			document.write ("<img src="+left +" height=1 width="+(wid*((100-percentBy2)/100))+">")
		if (percentBy2 != 0)
			document.write ("<img src="+right+" height=1 width="+(wid*((percentBy2)/100))+">")
		document.write ("<br>")
	} // for
document.write(	"</center>",
              "<BR>",
 				"<font size=2 face=Arial class=bodytext>",
 				"Next full moon is in about ",
 				Math.round((lunarPeriod-moonPhaseTime)/(24*3600*1000)),
				" day",
				Math.round((lunarPeriod-moonPhaseTime)/(24*3600*1000)) != 1 ? "s" : "",
				"")
}
// -->


      <!-- Moon Phase End -->