<?php
/*

Copyright (C)  2010 Urmila Champatiray.

    Permission is granted to copy, distribute and/or modify this document

    under the terms of the GNU Free Documentation License, Version 1.3

    or any later version published by the Free Software Foundation;

    with no Invariant Sections, no Front-Cover Texts, and no Back-Cover Texts.

    A copy of the license is included in the section entitled "GNU

    Free Documentation License"

	@license GNU/GPL http://www.gnu.org/copyleft/gpl.html

    Scientific Calculator for Joomla

    This program is free software: you can redistribute it and/or modify

    it under the terms of the GNU General Public License as published by

    the Free Software Foundation, either version 3 of the License, or

    (at your option) any later version.

    This program is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    
    Reference -http://www.javascripter.net/faq/mathfunc.htm

    along with this program.  If not, see <http://www.gnu.org/licenses/>

Scientific Calculator for Joomla

Version 1.2

Created date: July 2010

Modified date: August 2010

Creator: Urmila Champatiray

Email: admin@joomlaseo.org

Website: http://www.joomlaseo.org

*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<script language=javascript>

var abc = "0"
var def = 0
var ghi = 0
var jkl = 3
var mno = 0
var decimal = 0
var enter = "";


function memory(operator) {

	document.pqr.stu.focus();

	if (operator == 1) {		// MS 
		document.pqr.mem.value = document.pqr.resultant.value
	}
	else if (operator == 2)	{	// MR
		var mem = document.pqr.mem.value;
		if (mem==0 || chracter(mem.charAt(0))) {mem = ""};
		document.pqr.stu.value += mem
	}
	else if (operator == 3) {	// CLS
		if (document.pqr.stu.value == "") {
			document.pqr.resultant.value = ""
		}
		else {
			document.pqr.stu.value = ""
		}
	}
}


function display(xyz) {
	if (xyz=="")
		{document.pqr.stu.focus()}
	else
		{document.pqr.resultant.select()}
}


function cdef(xyz) {
	document.pqr.stu.focus();
	document.pqr.stu.value += xyz
}
function factorial(n) {
	if ((n == 0) || (n == 1)) {
		return 1
	}
	else {
		var opqrst = (n * factorial(n-1));
		return opqrst
	}
}
function chracter(valuer) {
	var chracter="(ABCDEFGHIKLMNOPRSTUVWXYZ";
	for (var i=0; i<chracter.length; i++)
		if (valuer == chracter.charAt(i)) {return true} {return false}
}



function ghij(klmn) {
	var qrstu = "";
	var mem = 0;

	if (klmn >= 1) {
		if (document.pqr.stu.value == "") {
			abc = document.pqr.resultant.value
		}
		else {
	 	abc = document.pqr.stu.value;
			if (prisresultant(abc.charAt(0))) {
				abc = document.pqr.resultant.value + abc
			}
		}
	}

	for (var i=0; i<abc.length; i++) {
		if (abc.charAt(i) == ",") {qrstu += "."}
		else if (abc.charAt(i) == " ") {}
		else {qrstu += abc.charAt(i)}
	}

	if (operator(abc.charAt(abc.length-1))) {return false};
	qrstu = eval("1*" + qrstu);

	if (klmn > 1) {
		qrstu = mathcalc(klmn, qrstu)
	}

	document.pqr.oldresultant.value = qrstu;

	kutrian(qrstu);

	document.pqr.stu.value = "";
	document.pqr.stu.focus()
}


function mathcalc(klmn, mno) {
with (Math)
{
	if (klmn == 2) {
		mno = pow(mno, 2)
	}
	else if (klmn == 3) {
		mno = sqrt(mno)
	}
	else if (klmn == 4) {
		mno = -mno
	}
	else if (klmn == 5) {
		mno = log(mno)
	}
	else if (klmn == 6) {
		mno = pow(E, mno)
	}
	else if (klmn == 7) {
		mno = 1/mno
	}
	else if (klmn == 8) {
		mno = log(mno)/LN10
	}
	else if (klmn == 9) {
		mno = pow(10, mno)
	}
	else if (klmn >= 10 && klmn <= 12) {
		if (klmn == 10) {
			mno = atan(mno)
		}
		else if (klmn == 11) {
			mno = acos(mno)
		}
		else if (klmn == 12) {
			mno = asin(mno)
		}

		if (document.pqr.vwxyz[1].checked) {mno = (mno * 180) / PI}
	}
	else if (klmn >= 14 && klmn <= 16) {
		if (document.pqr.vwxyz[1].checked)
			{radian = (mno / 180) * PI}
		else
			{radian = mno};

		if (klmn == 14) {
			mno = tan(radian)
		}
		else if (klmn == 15) {
			mno = cos(radian)
		}
		else if (klmn == 16) {
			mno = sin(radian)
		}
	}
	else if (klmn == 17) {
		mno = mno/100
	}
	else if (klmn == 18) {
		mno = mno/1000000
	}
	else if (klmn == 20) {
		mno = factorial(mno)
	}
	else if (klmn == 21) {
		jkl = prompt("Kindly enter exponent", 3);
		mno = pow(mno, jkl)
	}
	else if (klmn == 22) {
		jkl = prompt("Kindly enter root", 3);
		mno = pow(mno, (1/jkl))
	}
	return mno
}
}


function kutrian(eabc) {

decimal=parseFloat(document.pqr.xyzab.options[document.pqr.xyzab.selectedIndex].value);
	var strabc = eabc + " ";
	if (strabc.charAt(0) == ".") {strabc = "0" + strabc};
	var intabc = strabc.length - 1;
	decklmn(strabc);

	if (intabc > 16 && ghi == -1) {
		if (decimal == -1) {decimal = 14};
		strabc = xyzab(strabc.substring(0,intabc)) + " ";
		intabc = strabc.length - 1;
		decklmn(strabc)
	}

	if (decimal >= 0 && decimal != 14) {
		if (def > 0) {
			var opqrst = xyzab(strabc.substring(0,intabc))
		}
		else {
			eabc = strabc.substring(0,intabc);
			if (decimal > 0) {
				eabc += ".";
				for (var n = 0; n < decimal; n++) {
					eabc += "0"
				}
			}
			var opqrst = eabc
		}
	}
	else {
		decimal = 14;
		var opqrst = xyzab(strabc)
	}

	if (opqrst.charAt(0) == ".") {opqrst = "0" + opqrst};

	document.pqr.resultant.value = opqrst;
}


function decklmn(sturt) {
	def = 0;
	ghi = 0;

	def = sturt.indexOf(".");
	ghi = sturt.indexOf("e")
}
function prisresultant(valuer) {
	var prisresultant="*/+";
	for (var i=0; i<prisresultant.length; i++)
		if (valuer == prisresultant.charAt(i)) {return true}
	return false
}


function xyzab(sturt) {
with (Math) {

	if (ghi == -1) {
		var fungsu = def;
		if (fungsu == -1) {fungsu = sturt.length};
		var chootia = "";

		if (fungsu > 16) {
			var amitvar = round(sturt*pow(10, 18)) + " ";
			var swetavar = amitvar.indexOf("e");
			var fungsuk = (amitvar.substring(0,swetavar));

			fungsuk = round(fungsuk*pow(10, 15))/pow(10, 15) + " ";
			chootia = (amitvar.substring(swetavar+2,amitvar.length-1));
			chootia = "e+" + (chootia-18)
		}
		else {
			var fungsuk = round(sturt*pow(10, decimal))/pow(10, decimal) + " "
		}
	}
	else {
		var fungsuk = sturt.substring(0,ghi);
		var chootia = sturt.substring(ghi,sturt.length);

		fungsuk = round(fungsuk*pow(10, decimal))/pow(10, decimal) + " "
	}

	fungsuk = fungsuk.substring(0,fungsuk.length - 1);

	if (fungsuk.charAt(0) == ".") {fungsuk = "0" + fungsuk};

	if (decimal < 14) {
		if (fungsuk.indexOf(".") == -1 && decimal != 0) {fungsuk += "."};
		var nula = (def + decimal) - (fungsuk.length - 1);
		if (nula > 0 && decimal > 0) {
			for (var n = 0; n < nula; n++) {
				fungsuk += "0"
			}
		}
	}
	return (fungsuk + " " + chootia)
}
}


function operator(valuer) {
	var dashop="*/+-";
	for (var i=0; i<dashop.length; i++)
		if (valuer == dashop.charAt(i)) {return true}
	return false
}



//Eni Generalic, Split, Create: 1999/10/14; Update: 2001/12/10
-->
</script>

<BODY TEXT="#234567" BGCOLOR="#FFFFFF" LINK="#0000CC" VLINK="#0000CC" ALINK="#0000FF" onLoad="document.pqr.stu.focus()">

    <FORM NAME="pqr">
<INPUT TYPE="hidden" NAME="oldresultant" VALUE="">
<INPUT TYPE="hidden" NAME="mem" VALUE="">

<div align="center">

<TABLE BORDER=4 CELLSPACING=0 CELLPADDING=1 BGCOLOR="#EFEFEF" WIDTH="250">
<TR> 
<TD ALIGN="center" VALIGN="middle"> 
<TABLE BORDER=2 WIDTH="100%" CELLSPACING=3 CELLPADDING=1 BGCOLOR="#CCCCCC">
<TR> 
<TD ALIGN="center" VALIGN="middle" WIDTH="100%" BGCOLOR="#EFEFEF"> 
<INPUT TYPE="text" SIZE="13" NAME="resultant" VALUE="" onFocus="display(document.pqr.resultant.value)" STYLE="BACKGROUND: #EFEFEF; FONT-SIZE: 14pt; HEIGHT: 30px; WIDTH: 220px">

</TD>
</TR>
</TABLE>

<TABLE BORDER=2 CELLSPACING=3 CELLPADDING=0 BGCOLOR="#EFEFEF">
<TR> 
<TD COLSPAN=5 ALIGN=CENTER VALIGN=middle><NOBR><FONT> 
<SELECT NAME=xyzab SIZE="1" onChange="if (document.pqr.oldresultant.value != '') {kutrian(document.pqr.oldresultant.value)}; document.pqr.stu.focus()">
<OPTION VALUE=-1 SELECTED>decimal</OPTION>
<OPTION VALUE=0> 0 </OPTION>
<OPTION VALUE=1> 1 </OPTION>
<OPTION VALUE=2> 2 </OPTION>

<OPTION VALUE=3> 3 </OPTION>
<OPTION VALUE=4> 4 </OPTION>
<OPTION VALUE=5> 5 </OPTION>
<OPTION VALUE=6> 6 </OPTION>
<OPTION VALUE=7> 7 </OPTION>
<OPTION VALUE=8> 8 </OPTION>

<OPTION VALUE=9> 9 </OPTION>
<OPTION VALUE=10> 10 </OPTION>
<OPTION VALUE=11> 11 </OPTION>
<OPTION VALUE=12> 12 </OPTION>
<OPTION VALUE=13> 13 </OPTION>
<OPTION VALUE=14> 14 </OPTION>

<OPTION VALUE=15> 15 </OPTION>
</SELECT>
</FONT>
<FONT SIZE="2" FACE="Arial" COLOR="#226622">
<INPUT TYPE="radio" NAME="vwxyz" CHECKED TITLE="Radians" onClick="document.pqr.stu.focus()"><A HREF="javascript:document.pqr.vwxyz[0].click()" onMouseOver="self.status='Radians'; return true">Rad</A>
<INPUT TYPE="radio" NAME="vwxyz" TITLE="Degree" onClick="document.pqr.stu.focus()"><A HREF="javascript:document.pqr.vwxyz[1].click()" onMouseOver="self.status='Degrees'; return true">Deg</A>
<INPUT TYPE="radio" NAME="vwxyz" TITLE="Gradient" onClick="document.pqr.stu.focus()"><A HREF="javascript:document.pqr.vwxyz[2].click()" onMouseOver="self.status='Degrees'; return true">Grad</A></FONT></NOBR></TD>
<TD> 
<INPUT HEIGHT="24" WIDTH="38" TYPE="button" NAME="Cls" VALUE="Cls" TITLE="Clear screen" onClick="memory(3)" STYLE="BACKGROUND: #EEEEEE; FONT-SIZE: 10pt; HEIGHT: 24px; WIDTH: 38px">
</TD>
</TR>
<TR BGCOLOR="#EFEFEF"> 

<TD ALIGN=CENTER VALIGN=MIDDLE WIDTH="100%" COLSPAN="6"><FONT COLOR="#0000FF" SIZE=3> 
<INPUT TYPE="text" SIZE="17" NAME="stu" VALUE="" onChange="enter.click()" onKeyDown="if (event.keyCode==13) {enter.click()}" STYLE="FONT-SIZE: 10pt; FONT-WEIGHT: bold; HEIGHT: 25px; WIDTH: 200px">
</FONT></TD>
</TR>
<TR> 
<TD style="width: 34px"> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="sqrt" VALUE="sqrt" TITLE="Square root" onClick="ghij(3)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="root" VALUE="root" TITLE="Root" onClick="ghij(22)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD style="width: 28px"> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="ln" VALUE="ln" TITLE="Natural logarithm" onClick="ghij(5)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD style="width: 22px"> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="log" VALUE="log" TITLE="Common logarithm" onClick="ghij(8)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>

<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="tan" VALUE="tan" TITLE="Tangent" onClick="ghij(14)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="atan" VALUE="atan" TITLE="Arc tangent" onClick="ghij(10)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
</TR>
<TR> 
<TD style="width: 34px"> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="kvadrat" VALUE="x^2" TITLE="Square" onClick="ghij(2)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="potencija" VALUE="x^y" TITLE="Power" onClick="ghij(21)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD style="width: 28px"> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="aln" VALUE="e^x" TITLE="Natural antilogarithm" onClick="ghij(6)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>

<TD style="width: 22px"> 
<INPUT HEIGHT="28" TYPE="button" NAME="alog" VALUE="10^x" TITLE="Common antilogarithm" onClick="ghij(9)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 37px" align="left">
</TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="cos" VALUE="cos" TITLE="Cosine" onClick="ghij(15)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="acos" VALUE="acos" TITLE="Arc cosine" onClick="ghij(11)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 9pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
</TR>
<TR> 
<TD style="width: 34px"> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="sign" VALUE="+/-" TITLE="Change sign" onClick="ghij(4)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="1/x" VALUE="1/x" onClick="ghij(7)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>

<TD style="width: 28px"> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="fact" VALUE="x!" TITLE="Factorial" onClick="ghij(20)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD style="width: 22px"> 
<input height="28" width="38" type="button" name="PI" value="Pi" onClick="cdef(Math.PI)" style="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px"></TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="sin" VALUE="sin" TITLE="Sine" onClick="ghij(16)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="28" WIDTH="38" TYPE="button" NAME="asin" VALUE="asin" TITLE="Arc sine" onClick="ghij(12)" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 28px; WIDTH: 38px">
</TD>
</TR>
<TR> 

<TD style="width: 34px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="7" VALUE="7" onClick="cdef(7)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="8" VALUE="8" onClick="cdef(8)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD style="width: 28px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="9" VALUE="9" onClick="cdef(9)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD style="width: 22px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="djeljeno" VALUE="/" onClick="cdef('/')" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<td> 
<input height="32" width="38" type="button" name="ppm" value="ppm" title="Part per milion" onClick="ghij(18)" style="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 32px; WIDTH: 38px">
</td>
<td> 
<input height="32" width="38" type="button" name="MS" value="MS" title="Memory store" onClick="memory(1)" style="BACKGROUND: #EEEEEE; FONT-SIZE: 10pt; HEIGHT: 32px; WIDTH: 38px">

</td>
</TR>
<TR> 
<TD style="width: 34px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="4" VALUE="4" onClick="cdef(4)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="5" VALUE="5" onClick="cdef(5)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD style="width: 28px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="6" VALUE="6" onClick="cdef(6)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD style="width: 22px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="puta" VALUE="*" onClick="cdef('*')" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<td> 
<input height="32" width="38" type="button" name="postotak" value="%" title="Percent" onClick="ghij(17)" style="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 32px; WIDTH: 38px">

</td>
<td> 
<input height="32" width="38" type="button" name="MR" value="MR" title="Memory recall" onClick="memory(2)" style="BACKGROUND: #EEEEEE; FONT-SIZE: 10pt; HEIGHT: 32px; WIDTH: 38px">
</td>
</TR>
<TR> 
<TD style="width: 34px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="1" VALUE="1" onClick="cdef(1)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="2" VALUE="2" onClick="cdef(2)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD style="width: 28px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="3" VALUE="3" onClick="cdef(3)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD style="width: 22px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="minus" VALUE="-" onClick="cdef('-')" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">

</TD>
<TD> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="lijevo" VALUE="(" onClick="cdef('(')" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="desno" VALUE=")" onClick="cdef(')')" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 10pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
</TR>
<TR> 
<TD style="width: 34px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="0" VALUE="0" onClick="cdef(0)" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="." VALUE="." onClick="cdef('.')" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD style="width: 28px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="exp" VALUE="E" onClick="cdef('e')" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 10pt; HEIGHT: 32px; WIDTH: 38px">

</TD>
<TD style="width: 22px"> 
<INPUT HEIGHT="32" WIDTH="38" TYPE="button" NAME="plus" VALUE="+" onClick="cdef('+')" STYLE="BACKGROUND: #DEDEDE; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 38px">
</TD>
<TD COLSPAN=2> 
<INPUT HEIGHT="32" TYPE="button" NAME="enter" onClick="ghij(1)" VALUE="=" STYLE="BACKGROUND: #CDCDCD; FONT-SIZE: 12pt; HEIGHT: 32px; WIDTH: 85px">
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</div>
</FORM>