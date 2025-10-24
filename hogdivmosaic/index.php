<?php
include '../lib/generic_content.php';
?>

<html>
    <head>
    <title>Hog Mosaic</title>
<?php echo $standard_header_content;?>
  <style>
#container {
    position: relative;
    resize: both;
    overflow: hidden;
    min-width: 10px;
    min-height: 10px;
    width: 80vw;
    height: 80vh;
}
#container::after {
    content: "";
    position: absolute;
    bottom: 0;
    right: 0;
    width: 50px;
    height: 50px;
    background-image: url(images/buttons/resizer.png);
}
::-webkit-resizer {
    border: rgba(0,0,0,0);
    background: rgba(0,0,0,0);
    box-shadow: none;
    outline: none;
}

#no1 {
	position: absolute;
	/*width: calc(5*35vw - 6px);*/
	width: calc(9px + 4vw);
	height: calc(17px + 20vh);
  right: calc(548px - 20vh);
  top: calc(438px - 20vw);
	background-color: #2f2019;
}
#no2 {
	position: absolute;
	width: calc(9px + 2vh);
	height: calc(3px + 2vw);
  left: calc(87px + 10vh);
  top: calc(317px + 20vw);
	background-color: #332219;
}
#no3 {
	position: absolute;
	width: calc(3px + 5vw);
	height: calc(37px + 10vh);
  right: calc(209px + 30vh);
  bottom: calc(23px + 10vw);
	background-color: #332219;
}
#no4 {
	position: absolute;
	width: calc(6px + 6vh);
	height: calc(78px + 10vw);
  left: calc(325px - 20vh);
  bottom: calc(89px - 10vw);
	background-color: #262525;
}
#no5 {
	position: absolute;
	width: calc(16px + 3vh);
	height: calc(50px + 11vw);
  right: calc(88px + 20vh);
  top: calc(280px + 10vw);
	background-color: #352820;
}

#no6 {
	position: absolute;
	width: calc(29px + 6vw);
	height: calc(34px + 10vh);
  left: calc(23px + 4vw);
  top: calc(24px + 20vh);
	background-color: #c87935;
}
#no7 {
	position: absolute;
	width: calc(29px + 10vh);
	height: calc(85px + 20vw);
  right: calc(225px - 10vh);
  bottom: calc(205px - 8vw);
	background-color: #af6533;
}
#no8 {
	position: absolute;
	width: calc(26px + 10vw);
	height: calc(7px + 6vh);
  left: calc(253px + 10vw);
  bottom: calc(269px + 20vh);
	background-color: #ea953c;
}
#no9 {
	position: absolute;
	width: calc(66px + 20vh);
	height: calc(25px + 30vw);
  right: calc(349px - 20vh);
  top: calc(346px - 40vw);
	background-color: #985221;
}
#no10	{
	position: absolute;
	width: calc(81px + 16vw);
	height: calc(3px + 7vh);
  left: calc(15px + 18vw);
  top: calc(103px + 42vh);
	background-color: #a3642f;
}
#no11	{
	position: absolute;
	width: calc(104px + 24vw);
	height: calc(7px + 10vh);
  right: calc(100px + 16vh);
  bottom: calc(206px + 28vw);
	background-color: #e59c55;
}
#no12	{
	position: absolute;
	width: calc(105px + 18vw);
	height: calc(7px + 1vh);
  right: calc(295px - 20vw);
  bottom: calc(603px - 40vh);
	background-color: #dddedf;
}
#no13	{
	position: absolute;
	width: calc(32px + 6vw);
	height: calc(105px + 8vh);
  left: calc(3px + 4vw);
  bottom: calc(3px + 30vh);
	background-color: #c57932;
}
#no14	{
	position: absolute;
	width: calc(1px + 11vw);
	height: calc(2px + 10vh);
  right: calc(160px - 6vw);
  top: calc(300px - 7vh);
	background-color: #603721;
}
#no15	{
	position: absolute;
	width: 2vw;
	height: calc(2px + 2vh);
  left: calc(150px - 7vw);
  top: calc(226px + 40vh);
	background-color: #7c7164;
}
#no16	{
	position: absolute;
	width: calc(3px + 4vw);
	height: calc(5px + 1vh);
  right: calc(309px + 8vh);
  bottom: calc(7px + 12vw);
	background-color: #7c7164;
}
#no17	{
	position: absolute;
	width: calc(1px + 3vw);
	height: calc(3px + 2vh);
  left: calc(5px + 6vh);
  bottom: calc(4px + 8vw);
	background-color: #7c7164;
}
#no18	{
	position: absolute;
	width: calc(9px + 1vw);
	height: calc(8px + 1vh);
  right: calc(341px + 20vh);
  top: calc(239px + 40vw);
	background-color: #7c7164;
}
#no19	{
	position: absolute;
	width: calc(7px + 3vw);
	height: calc(4px + 2vh);
  left: calc(33px + 40vw);
  top: calc(211px + 50vh);
	background-color: #9e9d98;
}
#no20	{
	position: absolute;
	width: calc(3px + 1vw);
	height: calc(1px + 3vh);
  right: calc(201px + 14vw);
  bottom: calc(2px + 7vh);
	background-color: #948f86;
}
#no21	{
	position: absolute;
	width: calc(5px + 2vw);
	height: calc(3px + 1vh);
  left: calc(307px - 10vh);
  bottom: calc(102px - 14vw);
	background-color: #9e9d98;
}
#no22	{
	position: absolute;
	width: calc(3px + 5vh);
	height: calc(4px + 2vw);
  right: calc(136px + 10vh);
  top: calc(234px + 40vw);
	background-color: #635d59;
}
#no23	{
	position: absolute;
	width: calc(4px + 1vh);
	height: calc(2px + 2vw);
  left: calc(123px + 30vw);
  top: calc(304px + 22vw);
	background-color: #7c7164;
}
#no24	{
	position: absolute;
	width: calc(5px + 2vw);
	height: calc(4px + 2vh);
  right: calc(206px - 6vw);
  bottom: calc(97px - 8vh);
	background-color: #635d59;
}
#no25	{
	position: absolute;
	width: calc(24px + 20vw);
	height: calc(29px + 22vh);
  left: calc(204px + 22vh);
  bottom: calc(203px + 6vw);
	background-color: #5e5150;
}
#no26	{
	position: absolute;
	width: calc(22px + 8vh);
	height: calc(8px + 9vw);
  right: calc(103px - 4vw);
  top: calc(17px + 20vh);
	background-color: #4b3e3e;
}
#no27	{
	position: absolute;
	width: calc(57px + 8vw);
	height: calc(37px + 12vh);
  left: calc(158px + 42vh);
  top: calc(242px - 10vw);
	background-color: #3f3735;
}
#no28	{
	position: absolute;
	width: calc(42px + 10vh);
	height: calc(44px + 10vw);
  right: calc(109px - 20vw);
  bottom: calc(92px + 20vh);
	background-color: #514d4d;
}
#no29	{
	position: absolute;
	width: calc(1px + 4vh);
	height: calc(3px + 7vw);
  left: calc(329px + 20vh);
  bottom: calc(152px + 30vw);
	background-color: #453f47;
}
#no30	{
	position: absolute;
	width: calc(9px + 6vw);
	height: calc(3px + 8vh);
  right: calc(200px - 7vw);
  top: calc(199px - 15vh);
	background-color: #ad784e;
}
#no31	{
	position: absolute;
	width: calc(7px + 14vh);
	height: calc(3px + 2vw);
  left: calc(22px + 40vh);
  top: calc(27px + 20vw);
	background-color: #4b3a38;
}
#no32	{
	position: absolute;
	width: calc(3px + 2vw);
	height: calc(4px + 12vh);
  right: calc(23px + 50vh);
  bottom: calc(208px + 18vw);
	background-color: #4b3a38;
}
#no33	{
	position: absolute;
	width: calc(7px + 5vw);
	height: calc(4px + 8vh);
  left: calc(300px - 4vw);
  bottom: calc(350px - 6vh);
	background-color: #443837;
}
#no34	{
	position: absolute;
	width: calc(38px + 7vw);
	height: calc(4px + 8vh);
  right: calc(5px + 12vw);
  top: calc(207px - 8vh);
	background-color: #dcd0c5;
}
#no35	{
	position: absolute;
	width: calc(5px + 9vh);
	height: calc(5px + 3vw);
  left: calc(242px + 20vh);
  top: calc(108px + 20vw);
	background-color: #bf9d7e;
}
#no36	{
	position: absolute;
	width: calc(6px + 12vh);
	height: calc(3px + 4vw);
  right: calc(109px + 10vw);
  bottom: calc(156px + 14vh);
	background-color: #ddc0a6;
}
#no37	{
	position: absolute;
	width: calc(6px + 8vh);
	height: calc(1px + 2vw);
  left: calc(456px - 16vw);
  bottom: calc(500px - 21vh);
	background-color: #4b3a38;
}
#no38	{
	position: absolute;
	width: calc(5px + 5vw);
	height: calc(1px + 8vh);
  right: calc(1px + 14vw);
  top: calc(46px + 22vh);
	background-color: #bc8454;
}
#no39	{
	position: absolute;
	width: calc(3px + 4vw);
	height: calc(3px + 9vh);
  left: calc(502px - 19vh);
  top: calc(202px - 20vw);
	background-color: #9a6a4e;
}
#no40	{
	position: absolute;
	width: calc(1px + 8vh);
	height: calc(1px + 10vw);
  right: calc(51px + 12vh);
  bottom: calc(209px + 16vw);
	background-color: #5d5560;
}
#no41	{
	position: absolute;
	width: calc(2px + 5vw);
	height: calc(2px + 4vh);
  left: calc(300px + 11vh);
  bottom: calc(201px + 21vw);
	background-color: #3e3939;
}
#no42	{
	position: absolute;
	width: calc(2px + 2vw);
	height: calc(3px + 1vh);
  right: calc(207px - 16vw);
  top: calc(285px - 20vh);
	background-color: #7c5343;
}
#no43	{
	position: absolute;
	width: calc(3px + 1vw);
	height: calc(1px + 1vh);
  left: calc(264px + 20vh);
  top: calc(106px + 16vw);
	background-color: #000000;
}
#no44	{
	position: absolute;
	width: calc(3px + 11vh);
	height: calc(1px + 6vw);
  right: calc(107px - 20vw);
  bottom: calc(47 + 30vh);
	background-color: #dbcaba;
}
#no45	{
	position: absolute;
	width: calc(6px + 9vh);
	height: calc(6px + 5vw);
  left: calc(401px + 8vw);
  bottom: calc(102px + 16vh);
	background-color: #4a3d32;
}
#no46	{
	position: absolute;
	width: calc(2px + 2vh);
	height: calc(2px + 1vw);
  right: calc(4px + 7vw);
  top: calc(150px + 30vh);
	background-color: #1a1512;
}
#no47	{
	position: absolute;
	width: calc(1px + 2vh);
	height: calc(3px + 5vw);
  left: calc(421px + 11vh);
  top: calc(200px + 19vw);
	background-color: #1a1512;
}
#no48	{
	position: absolute;
	width: calc(4px + 2vh);
	height: calc(1px + 6vw);
  right: calc(280px - 40vw);
  bottom: calc(11px + 40vh);
	background-color: #e9bf98;
}
#no49	{
	position: absolute;
	width: calc(5px + 4vw);
	height: calc(4px + 2vh);
  left: calc(303px + 14vh);
  bottom: calc(303px + 12vw);
	background-color: #b67144;
}

</style>
</head>
<body>
<?php echo $standard_toolbar;?>
<!--
DIV NO1 is at the BACK of the image BEHIND everything else
DIV NO50 is at the FRONT of the image ON TOP of everything else
Made by Johnny H : )
-->
<!--<div id="container">-->
<div id="no1"></div>
<div id="no2"></div>
<div id="no3"></div>
<div id="no4"></div>
<div id="no5"></div>
<div id="no6"></div>
<div id="no7"></div>
<div id="no8"></div>
<div id="no9"></div>
<div id="no10"></div>
<div id="no11"></div>
<div id="no12"></div>
<div id="no13"></div>
<div id="no14"></div>
<div id="no15"></div>
<div id="no16"></div>
<div id="no17"></div>
<div id="no18"></div>
<div id="no19"></div>
<div id="no20"></div>
<div id="no21"></div>
<div id="no22"></div>
<div id="no23"></div>
<div id="no24"></div>
<div id="no25"></div>
<div id="no26"></div>
<div id="no27"></div>
<div id="no28"></div>
<div id="no29"></div>
<div id="no30"></div>
<div id="no31"></div>
<div id="no32"></div>
<div id="no33"></div>
<div id="no34"></div>
<div id="no35"></div>
<div id="no36"></div>
<div id="no37"></div>
<div id="no38"></div>
<div id="no39"></div>
<div id="no40"></div>
<div id="no41"></div>
<div id="no42"></div>
<div id="no43"></div>
<div id="no44"></div>
<div id="no45"></div>
<div id="no46"></div>
<div id="no47"></div>
<div id="no48"></div>
<div id="no49"></div>
<div id="no50"></div>
<!--</div>-->

</body>

</html>
