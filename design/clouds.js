/*
 * @author NeXus from TeeWorlds =)
 * edit by ChillerDragon
 */

var screenWidth     = screen.width;

var cloud1          = document.getElementById("cloud1");
var cloud1StartPos  = typeof sessionStorage['cloud1Pos'] == "undefined" ? cloud1.style.left : sessionStorage['cloud1Pos'];
var cloud1Speed     = 1;

var cloud2          = document.getElementById("cloud2");
var cloud2StartPos  = typeof sessionStorage['cloud2Pos'] == "undefined" ? cloud2.style.left : sessionStorage['cloud2Pos'];
var cloud2Speed     = 2;

window.onbeforeunload = function() {
sessionStorage['cloud1Pos'] = cloud1.style.left;
sessionStorage['cloud2Pos'] = cloud2.style.left;
sessionStorage['cloud3Pos'] = cloud3.style.left;
sessionStorage['cloud4Pos'] = cloud4.style.left;
sessionStorage['cloud5Pos'] = cloud5.style.left;
};

cloud1.style.left = cloud1StartPos;
cloud2.style.left = cloud2StartPos;

setInterval(function() { moveClouds() }, 0);

function moveClouds() {
   var cloud1CurrPos = cloud1.style.left;
   var cloud2CurrPos = cloud2.style.left;

   var newCloud1Position = parseInt(cloud1CurrPos)+cloud1Speed;
   var newCloud2Position = parseInt(cloud2CurrPos)+cloud2Speed;

       newCloud1Position >= screenWidth ? cloud1.style.left = "0px" : cloud1.style.left = newCloud1Position+"px";
       newCloud2Position >= screenWidth ? cloud2.style.left = "0px" : cloud2.style.left = newCloud2Position+"px";
}
