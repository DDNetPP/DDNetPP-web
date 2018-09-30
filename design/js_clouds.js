/*
 * @author NeXus from TeeWorlds =)
 * edit by ChillerDragon
 */

//var screenWidth     = screen.width; // worked fine on macOS safari; But went to early back on iPhone5
var screenWidth     = screen.width + 1000; // worked fine everywhere

var cloud1          = document.getElementById("cloud1");
var cloud1StartPos  = typeof sessionStorage['cloud1Pos'] == "undefined" ? cloud1.style.left : sessionStorage['cloud1Pos'];
var cloud1Speed     = 1;

var cloud2          = document.getElementById("cloud2");
var cloud2StartPos  = typeof sessionStorage['cloud2Pos'] == "undefined" ? cloud2.style.left : sessionStorage['cloud2Pos'];
var cloud2Speed     = 2;

var cloud3          = document.getElementById("cloud3");
var cloud3StartPos  = typeof sessionStorage['cloud3Pos'] == "undefined" ? cloud3.style.left : sessionStorage['cloud3Pos'];
var cloud3Speed     = 3;

var cloud4          = document.getElementById("cloud4");
var cloud4StartPos  = typeof sessionStorage['cloud4Pos'] == "undefined" ? cloud4.style.left : sessionStorage['cloud4Pos'];
var cloud4Speed     = 2;

var cloud5          = document.getElementById("cloud5");
var cloud5StartPos  = typeof sessionStorage['cloud5Pos'] == "undefined" ? cloud5.style.left : sessionStorage['cloud5Pos'];
var cloud5Speed     = 1;


window.onbeforeunload = function() {
sessionStorage['cloud1Pos'] = cloud1.style.left;
sessionStorage['cloud2Pos'] = cloud2.style.left;
sessionStorage['cloud3Pos'] = cloud3.style.left;
sessionStorage['cloud4Pos'] = cloud4.style.left;
sessionStorage['cloud5Pos'] = cloud5.style.left;
};

cloud1.style.left = cloud1StartPos;
cloud2.style.left = cloud2StartPos;
cloud3.style.left = cloud3StartPos;
cloud4.style.left = cloud4StartPos;
cloud5.style.left = cloud5StartPos;

//setInterval(function() { moveClouds() }, 0);

function moveClouds() {
    var cloud1CurrPos = cloud1.style.left;
    var cloud2CurrPos = cloud2.style.left;
    var cloud3CurrPos = cloud3.style.left;
    var cloud4CurrPos = cloud4.style.left;
    var cloud5CurrPos = cloud5.style.left;

    var newCloud1Position = parseInt(cloud1CurrPos)+cloud1Speed;
    var newCloud2Position = parseInt(cloud2CurrPos)+cloud2Speed;
    var newCloud3Position = parseInt(cloud3CurrPos)+cloud3Speed;
    var newCloud4Position = parseInt(cloud4CurrPos)+cloud4Speed;
    var newCloud5Position = parseInt(cloud5CurrPos)+cloud5Speed;

    var diff = parseInt(cloud1CurrPos) - newCloud1Position;

    newCloud1Position >= screenWidth ? cloud1.style.left = "-600px" : cloud1.style.left = newCloud1Position+"px";
    newCloud2Position >= screenWidth ? cloud2.style.left = "-600px" : cloud2.style.left = newCloud2Position+"px";
    newCloud3Position >= screenWidth ? cloud3.style.left = "-600px" : cloud3.style.left = newCloud3Position+"px";
    newCloud4Position >= screenWidth ? cloud4.style.left = "-600px" : cloud4.style.left = newCloud4Position+"px";
    newCloud5Position >= screenWidth ? cloud5.style.left = "-600px" : cloud5.style.left = newCloud5Position+"px";
    requestAnimationFrame(moveClouds);
}
requestAnimationFrame(moveClouds);
