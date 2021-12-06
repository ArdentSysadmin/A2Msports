<script> //#fdb50a
$(document).ready(function(){
	$('#mens_gpa_rankings').hide();
	$('#womens_mx_gpa_rankings').hide();
	$('#mens_mx_gpa_rankings').hide();

function change_to_yellow(btn){
		$('#'+btn).css('background-color', '#fcda00');
		$('#'+btn).css('color', '#000');
}

function change_to_blue(btn){
		$('#'+btn).css('background-color', '#012a75');
		$('#'+btn).css('color', '#fff');
}

		change_to_yellow('btn_womens');


	$('#btn_mens').click(function(){
		$('#mens_gpa_rankings').show();
		$('#womens_gpa_rankings').hide();
		$('#womens_mx_gpa_rankings').hide();
		$('#mens_mx_gpa_rankings').hide();

		change_to_yellow('btn_mens');
		change_to_blue('btn_mens_mx');
		change_to_blue('btn_womens');
		change_to_blue('btn_womens_mx');
	});

	$('#btn_womens').click(function(){
		$('#mens_gpa_rankings').hide();
		$('#mens_mx_gpa_rankings').hide();
		$('#womens_mx_gpa_rankings').hide();
		$('#womens_gpa_rankings').show();

		change_to_yellow('btn_womens');
		change_to_blue('btn_womens_mx');
		change_to_blue('btn_mens');
		change_to_blue('btn_mens_mx');
	});

	$('#btn_womens_mx').click(function(){
		$('#mens_gpa_rankings').hide();
		$('#mens_mx_gpa_rankings').hide();
		$('#womens_gpa_rankings').hide();
		$('#womens_mx_gpa_rankings').show();

		change_to_yellow('btn_womens_mx');
		change_to_blue('btn_womens');
		change_to_blue('btn_mens');
		change_to_blue('btn_mens_mx');
	});
		
	$('#btn_mens_mx').click(function(){
		$('#mens_gpa_rankings').hide();
		$('#mens_mx_gpa_rankings').show();
		$('#womens_gpa_rankings').hide();
		$('#womens_mx_gpa_rankings').hide();

		change_to_yellow('btn_mens_mx');
		change_to_blue('btn_womens_mx');
		change_to_blue('btn_mens');
		change_to_blue('btn_womens');
	});
		
});
</script>
<div class="container">
<div class="row">
	<div class="col-md-12" style="margin-top: 50px; margin-left: 0px;">
	<h3 style="color:#0032af;">GPA Rankings</h3>
	</div>
</div>
</div>

<div class="container">
<div class="row" style="margin-bottom: 40px; margin-top: 40px;">
	
	<div class="col-md-2">
	<input type="button" id="btn_womens" name="btn_womens" value="Women's Doubles" class="book-submit" style="margin-bottom: 3px;" />
	</div>
	<div class="col-md-3">
	<input type="button" id="btn_womens_mx" name="btn_womens_mx" value="Women's Mixed Doubles" class="book-submit" style="margin-bottom: 3px;" />
	</div>
	<div class="col-md-2">
	<input type="button" id="btn_mens" name="btn_mens" value="Men's Doubles" class="book-submit" style="margin-bottom: 3px;" />
	</div>
	<div class="col-md-3">
	<input type="button" id="btn_mens_mx" name="btn_mens_mx" value="Men's Mixed Doubles" class="book-submit" style="margin-bottom: 3px;" />
	</div>

</div>

<!-- Women's Doubles -->
<div id="womens_gpa_rankings">
<div class="row">

	<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><font color="#000000">WOMEN'S 3.0 - 50 &amp; Over (TOP 20)</font></td>
	</tr>

	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roundtree</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">D.</font></td>
		<td align="center" valign=top sdval="275" sdnum="1033;"><font color="#000000">275</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mircio</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roselyn</font></td>
		<td align="center" valign=top sdval="225" sdnum="1033;"><font color="#000000">225</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chaim</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sook</font></td>
		<td align="center" valign=top sdval="220" sdnum="1033;"><font color="#000000">220</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vann</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tammie</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Leseueur</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Julie</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Katt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Beth</font></td>
		<td align="center" valign=top sdval="145" sdnum="1033;"><font color="#000000">145</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Carpenter</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martha</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chmiel</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rachel</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rose</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Evy</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bailey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cindy</font></td>
		<td align="center" valign=top sdval="130" sdnum="1033;"><font color="#000000">130</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ingram</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cindy</font></td>
		<td align="center" valign=top sdval="130" sdnum="1033;"><font color="#000000">130</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cohen</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Margie</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="13" sdnum="1033;"><font color="#000000">13</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roberson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Robin</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Meeds</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Heather</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Williams-Mitchell</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rozetta</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Barrett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Elaine</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kight</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Leanne</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Naiser</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Valerie</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Fay</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shelly</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pollyann</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Moore</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shelli</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Smith</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kelly</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Witcher</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Michelle</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
</table>

	</div>

	<div class="col-md-4" style="text-align: center;">

<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan='4' align="center" valign=bottom><font color="#000000">WOMEN'S 3.0 - 49 &amp; Under (TOP 10) </font></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
		</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lyons</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lena</font></td>
		<td align="center" valign=top sdval="415" sdnum="1033;"><font color="#000000">415</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">reynolds</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">kat</font></td>
		<td align="center" valign=top sdval="280" sdnum="1033;"><font color="#000000">280</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dillon</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Amy</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hooper</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shannon</font></td>
		<td align="center" valign=top sdval="120" sdnum="1033;"><font color="#000000">120</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mayfield</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Heather</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dowdy</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mary Beth</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jones</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tiffany</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vickers</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Adalina</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hamilton</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Joni</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hoffman</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tanya</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maples</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mary Anne</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mitsunaga</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keiko</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Royal</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">LeAnn</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
</table>

	</div>

	<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">

	<tr style='font-weight:bold;'>
		<td colspan='4' align="center" valign=bottom><font color="#000000">WOMENS 3.5 - 50 &amp; Over (TOP 20)</font></td>
	</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Clarke</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kim</font></td>
		<td align="center" valign=top sdval="405" sdnum="1033;"><font color="#000000">405</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Eva</font></td>
		<td align="center" valign=top sdval="390" sdnum="1033;"><font color="#000000">390</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jones</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bella</font></td>
		<td align="center" valign=top sdval="305" sdnum="1033;"><font color="#000000">305</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stokes</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tesha</font></td>
		<td align="center" valign=top sdval="250" sdnum="1033;"><font color="#000000">250</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Blaginin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Karla</font></td>
		<td align="center" valign=top sdval="180" sdnum="1033;"><font color="#000000">180</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bishop</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sandy</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Austin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Becky</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Farriba</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ellie</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Foster</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kitty</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bennett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jamie</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Riaz</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Angelyn</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Blihovde</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Diana</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="13" sdnum="1033;"><font color="#000000">13</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Davidson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Norma</font></td>
		<td align="center" valign=top sdval="130" sdnum="1033;"><font color="#000000">130</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brown</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jonita</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pitts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Darlene</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shedd</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Naomi</font></td>
		<td align="center" valign=top sdval="110" sdnum="1033;"><font color="#000000">110</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Spratt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jenny</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dowdy</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bev</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Diamond</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Leslie</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lavey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ellen</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
</table>

	</div>
</div>

<div class="row">

<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">

	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><font color="#000000">WOMENS 3.5 - 49 &amp; Under (TOP 20)</font></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
		</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Schu</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lara</font></td>
		<td align="center" valign=top sdval="780" sdnum="1033;"><font color="#000000">780</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Briant</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Angela</font></td>
		<td align="center" valign=top sdval="685" sdnum="1033;"><font color="#000000">685</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Walter</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Olivia</font></td>
		<td align="center" valign=top sdval="305" sdnum="1033;"><font color="#000000">305</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Caraballo</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Julie</font></td>
		<td align="center" valign=top sdval="280" sdnum="1033;"><font color="#000000">280</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tyson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Julie</font></td>
		<td align="center" valign=top sdval="230" sdnum="1033;"><font color="#000000">230</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ruplin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dana</font></td>
		<td align="center" valign=top sdval="190" sdnum="1033;"><font color="#000000">190</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Beard</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Daniela</font></td>
		<td align="center" valign=top sdval="180" sdnum="1033;"><font color="#000000">180</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Catlin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Laura</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Klein</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sidney</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Storey-Pitts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Katie</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Murphy</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maggie</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Windom</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dylan</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="13" sdnum="1033;"><font color="#000000">13</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bennett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ripley</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shue</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Christy</font></td>
		<td align="center" valign=top sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Adams</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Amy</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Borer</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rebecca</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Millwood</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rena</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Polk</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kelly</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mims</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Marlana</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">San Martin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vanessa</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
</table>

	</div>

<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">

	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><font color="#000000">WOMENS 4.0 - 49 &amp; Under (TOP 10)</font></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jaeger</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Heather</font></td>
		<td align="center" valign=top sdval="295" sdnum="1033;"><font color="#000000">295</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kind</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kristy</font></td>
		<td align="center" valign=top sdval="295" sdnum="1033;"><font color="#000000">295</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Crowley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Marnie</font></td>
		<td align="center" valign=top sdval="245" sdnum="1033;"><font color="#000000">245</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maddrey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maggie</font></td>
		<td align="center" valign=top sdval="145" sdnum="1033;"><font color="#000000">145</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Everett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Katrina</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hooper</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lilly</font></td>
		<td align="center" valign=top sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rackley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Emily</font></td>
		<td align="center" valign=top sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">D'Souza</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Marissa</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martinez</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Denisse</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">O'Kelley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Morgan</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
</table>
</div>

<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">WOMENS 4.0 - 50 &amp; Over (TOP 10)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lamb</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Blanche</font></td>
		<td align="center" valign=top sdval="380" sdnum="1033;"><font color="#000000">380</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Coggins</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Angie</font></td>
		<td align="center" valign=top sdval="370" sdnum="1033;"><font color="#000000">370</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Thomason</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tracy</font></td>
		<td align="center" valign=top sdval="300" sdnum="1033;"><font color="#000000">300</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Alligood</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cindy</font></td>
		<td align="center" valign=top sdval="240" sdnum="1033;"><font color="#000000">240</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Manning</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jewel</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Coker</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tammy</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stringfield</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sherese</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Griffin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cindy</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hancock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kellie</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Huyen</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Linda</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
</table>
</div>

</div><!-- row close -->
</div>


<!-- Women's Doubles -->



<!-- Men's Doubles -->
<div id="mens_gpa_rankings">
<div class="row">
	<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><font color="#000000">MENS 3.0 - 49 &amp; Under (TOP 25)</font></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
		</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lyons</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">David</font></td>
		<td align="center" valign=top sdval="240" sdnum="1033;"><font color="#000000">240</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">kelly</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">timothy</font></td>
		<td align="center" valign=top sdval="205" sdnum="1033;"><font color="#000000">205</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kemper</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">King</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mohammed</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Asif</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ivey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Garrett</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">McElreath</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ben</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Deutsch</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Zachary</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Duginski</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Corin</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kight</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Andy</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Morrison</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Alex</font></td>
		<td align="center" valign=top sdval="110" sdnum="1033;"><font color="#000000">110</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bridges</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Derrick</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">CAFFEE</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">STEVEN</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lewis</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Matthew</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">McGrath</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Garrick</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Replogle</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Matt</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Drinkard</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Austin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ian</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shanmugasundaram</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Subhash</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cowart</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Charles</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bacon</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jordan</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="21" sdnum="1033;"><font color="#000000">21</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Barber</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Christopher</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="22" sdnum="1033;"><font color="#000000">22</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Durham</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ross</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="23" sdnum="1033;"><font color="#000000">23</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wade</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lee</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="24" sdnum="1033;"><font color="#000000">24</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Walker</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Johnathon</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="25" sdnum="1033;"><font color="#000000">25</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ivey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chris</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
</table>
	</div>

	<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><b><font color="#000000">MENS 3.0 - 50 &amp; Over (TOP 25)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kritch</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keith</font></td>
		<td align="center" valign=top sdval="250" sdnum="1033;"><font color="#000000">250</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vann</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">David</font></td>
		<td align="center" valign=top sdval="190" sdnum="1033;"><font color="#000000">190</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Halley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Michael</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Holt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Frank</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Barrett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bill</font></td>
		<td align="center" valign=top sdval="130" sdnum="1033;"><font color="#000000">130</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Fletcher</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bud</font></td>
		<td align="center" valign=top sdval="130" sdnum="1033;"><font color="#000000">130</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pitts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Michael</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Griffin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sorenson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Todd</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Clark</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keith</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Craddock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bryan</font></td>
		<td align="center" valign=top sdval="110" sdnum="1033;"><font color="#000000">110</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Potter</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vazquez</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Carlos</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hazlett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Scott</font></td>
		<td align="center" valign=top sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Orr</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brent</font></td>
		<td align="center" valign=top sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Easton</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Everard</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ruiz</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Artie</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Teems</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Darryl</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vann</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tommy</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hester</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bob</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="21" sdnum="1033;"><font color="#000000">21</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wilson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Joey</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="21" sdnum="1033;"><font color="#000000">21</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kight</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Steven</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="23" sdnum="1033;"><font color="#000000">23</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Loftus</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Duane</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="23" sdnum="1033;"><font color="#000000">23</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Powell</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Elbert</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="23" sdnum="1033;"><font color="#000000">23</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shedd</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tim</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
</table>

	</div>

	<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><b><font color="#000000">MENS 3.5 - 49 &amp; Under (TOP 25)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lewis</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bo</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Whitmire</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lucas</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Nance</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ruthstrom</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dillon</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ivey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Landon</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Holt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Josh</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Medlock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Houston</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Gibbs</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Josh</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ruiz</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roger</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Holbert</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jonah</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bax</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Raoul</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cavender</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Christopher</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Gavin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Trey</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Poore</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Byron</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stapleton</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bill</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roberts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">John</font></td>
		<td align="center" valign=top sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Barrett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ryan</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vega</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jose</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bradshaw</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jordan</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hardeman</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Daniel</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wilson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Josh</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="22" sdnum="1033;"><font color="#000000">22</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tyson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ira</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="23" sdnum="1033;"><font color="#000000">23</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lloyd</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jacob</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="23" sdnum="1033;"><font color="#000000">23</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Santangelo</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Will</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="25" sdnum="1033;"><font color="#000000">25</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Greer</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sean</font></td>
		<td align="center" valign=top sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="25" sdnum="1033;"><font color="#000000">25</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wallace</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rob</font></td>
		<td align="center" valign=top sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>
</table>
	</div>
	</div>
 
<div class="row">
	<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><b><font color="#000000">MENS 3.5 - 50 &amp; Over (TOP 25)</font></b></td>
	</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stokes</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Eddie</font></td>
		<td align="center" valign=top sdval="665" sdnum="1033;"><font color="#000000">665</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Benario</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Fred</font></td>
		<td align="center" valign=top sdval="495" sdnum="1033;"><font color="#000000">495</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Johnson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Richard</font></td>
		<td align="center" valign=top sdval="335" sdnum="1033;"><font color="#000000">335</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Minton</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chris</font></td>
		<td align="center" valign=top sdval="285" sdnum="1033;"><font color="#000000">285</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Perkins</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lee</font></td>
		<td align="center" valign=top sdval="275" sdnum="1033;"><font color="#000000">275</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kritch</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kevin</font></td>
		<td align="center" valign=top sdval="250" sdnum="1033;"><font color="#000000">250</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pollock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">David</font></td>
		<td align="center" valign=top sdval="240" sdnum="1033;"><font color="#000000">240</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stone</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Robert</font></td>
		<td align="center" valign=top sdval="220" sdnum="1033;"><font color="#000000">220</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Scheck</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Steve</font></td>
		<td align="center" valign=top sdval="210" sdnum="1033;"><font color="#000000">210</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Minniefield</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stanley</font></td>
		<td align="center" valign=top sdval="205" sdnum="1033;"><font color="#000000">205</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">John</font></td>
		<td align="center" valign=top sdval="190" sdnum="1033;"><font color="#000000">190</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rahn</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stephen</font></td>
		<td align="center" valign=top sdval="190" sdnum="1033;"><font color="#000000">190</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="13" sdnum="1033;"><font color="#000000">13</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bradshaw</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jason</font></td>
		<td align="center" valign=top sdval="185" sdnum="1033;"><font color="#000000">185</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Medlock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Nathan</font></td>
		<td align="center" valign=top sdval="180" sdnum="1033;"><font color="#000000">180</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Traub</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stephen</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bacon</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kerry</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bates</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chris</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bracewell</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mitch</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maddox</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brent</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Popadiuk</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Nick</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Campbell</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Darrell</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keener</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Richard</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="23" sdnum="1033;"><font color="#000000">23</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bardes</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keith</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="24" sdnum="1033;"><font color="#000000">24</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mauldin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Carl</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="25" sdnum="1033;"><font color="#000000">25</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mcghee</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Danny</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
</table>

	</div>

	<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><b><font color="#000000">MENS 4.0 - 49 &amp; Under (TOP 10)</font></b></td>
	</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vantreese</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Justin</font></td>
		<td align="center" valign=top sdval="685" sdnum="1033;"><font color="#000000">685</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Olszanski</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Leandro</font></td>
		<td align="center" valign=top sdval="460" sdnum="1033;"><font color="#000000">460</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Gonzales</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Carlos</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chan</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dan</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Knox</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Robbie</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Thompson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">JT</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Walters</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Trent</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Barry</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Drew</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Contreras</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cristobal</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kourajian</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Darin</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
</table>
	</div>

	<div class="col-md-4" style="text-align: center;">
<table class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><b><font color="#000000">MENS 4.0 - 50 &amp; Under (TOP 20)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
		</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Choe</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sung</font></td>
		<td align="center" valign=top sdval="430" sdnum="1033;"><font color="#000000">430</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Olsen</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="390" sdnum="1033;"><font color="#000000">390</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Seymour</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Frank</font></td>
		<td align="center" valign=top sdval="370" sdnum="1033;"><font color="#000000">370</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Thomason</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Charles</font></td>
		<td align="center" valign=top sdval="285" sdnum="1033;"><font color="#000000">285</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bennett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Steven</font></td>
		<td align="center" valign=top sdval="230" sdnum="1033;"><font color="#000000">230</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pflug</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stuart</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Knox</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jon</font></td>
		<td align="center" valign=top sdval="145" sdnum="1033;"><font color="#000000">145</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Midkiff</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Paul</font></td>
		<td align="center" valign=top sdval="145" sdnum="1033;"><font color="#000000">145</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Freese</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Thomas</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Holland</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">George (Clay)</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Helsel</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mark</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ingram</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brent</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="13" sdnum="1033;"><font color="#000000">13</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Meyer</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jerry</font></td>
		<td align="center" valign=top sdval="120" sdnum="1033;"><font color="#000000">120</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lowry</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lynn</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Raines</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Scott</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Austin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Clarence</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Knox</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kelley</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">burson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">mike</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Collins</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mike</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Frazier</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">John</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
</table>
	</div>
	</div>

<div class="row">

	<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">

	<tr style='font-weight:bold;'>
		<td colspan=4 align="center" valign=bottom><b><font color="#000000">MENS 4.5+ ALL (TOP 15)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
			<td height="20" align="center" valign=bottom><font color="#000000">Rank</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Firstname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Lastname</font></td>
			<td height="20" align="center" valign=bottom><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Spicer</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Greg</font></td>
		<td align="center" valign=top sdval="580" sdnum="1033;"><font color="#000000">580</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Callihan</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">David</font></td>
		<td align="center" valign=top sdval="265" sdnum="1033;"><font color="#000000">265</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hall</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mike</font></td>
		<td align="center" valign=top sdval="240" sdnum="1033;"><font color="#000000">240</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ruplin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Matthew</font></td>
		<td align="center" valign=top sdval="220" sdnum="1033;"><font color="#000000">220</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pickering</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Frank</font></td>
		<td align="center" valign=top sdval="185" sdnum="1033;"><font color="#000000">185</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cartenuto</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jason</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Watson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Art</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Atwood</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kenny</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Price</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mark</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bixler</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rob</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Blankenship</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tom</font></td>
		<td align="center" valign=top sdval="130" sdnum="1033;"><font color="#000000">130</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Smith</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dahm</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="13" sdnum="1033;"><font color="#000000">13</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Noble</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brian</font></td>
		<td align="center" valign=top sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bragman</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Adam</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Milton</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jayke</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
</table>

	</div>
</div>
</div> 
<!-- Men's Doubles -->


<!-- Women's Mixed Doubles -->
<div id="womens_mx_gpa_rankings">
<div class="row">
	<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><font color="#000000">WOMENS MIXED 3.0 - 49 &amp; Under (TOP 15)</font></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="left" valign=bottom><font color="#000000">Rank</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">First Name</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Last Name</font></td>
		<td align="center" valign=top><font color="#000000">Points</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Lyons</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Lena</font></td>
		<td align="center" valign=top sdval="380" sdnum="1033;"><font color="#000000">380</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Briant</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Angela</font></td>
		<td align="center" valign=top sdval="345" sdnum="1033;"><font color="#000000">345</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Jones</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Tiffany</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Sumner</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Shay</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Maples</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Mary Anne</font></td>
		<td align="center" valign=top sdval="145" sdnum="1033;"><font color="#000000">145</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Dennison</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Shalyn</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">baggett</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">cecilia</font></td>
		<td align="center" valign=top sdval="120" sdnum="1033;"><font color="#000000">120</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">O'Kelley</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Hannah</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Klein</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Sidney</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Dillon</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Amy</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Baumann</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Shelley</font></td>
		<td align="center" valign=top sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Walter</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Olivia</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Shue</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Christy</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Dowdy</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Mary Beth</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Storey-Pitts</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Katie</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Hooper</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Shannon</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Taylor</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Julia</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Woodard</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Jasmine</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="right" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Blalock</font></td>
		<td align="left" valign=top sdnum="1033;0;@"><font color="#000000">Ashley</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
</table>
	</div>
	<div class="col-md-4" style="text-align: center;">
	<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">WOMENS MIXED 3.0 - 50 &amp; Over (TOP 10)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Fay</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shelly</font></td>
		<td align="center" valign=top sdval="355" sdnum="1033;"><font color="#000000">355</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Barrett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Elaine</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Midkiff</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Linda</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Eva</font></td>
		<td align="center" valign=top sdval="155" sdnum="1033;"><font color="#000000">155</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Austin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Becky</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Harmon</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jan</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Snyder</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maureen</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">quigg</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">cheryl</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vann</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tammie</font></td>
		<td align="center" valign=top sdval="120" sdnum="1033;"><font color="#000000">120</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stout</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Susan</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Clarke</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kim</font></td>
		<td align="center" valign=top sdval="110" sdnum="1033;"><font color="#000000">110</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roberson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Robin</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Smith</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kelly</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rose</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Evy</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cheek</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kathy</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Emerick</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tammi</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ainsworth</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Gloria</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Crosby</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Becky</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Carpenter</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martha</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Cohen</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Margie</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
</table>
	</div>

	<div class="col-md-4" style="text-align: center;">
	<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">WOMENS MIXED 3.5 - 49 &amp; Under (TOP 20)</font></b></td>
	</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Schu</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Lara</font></td>
		<td align="center" valign=top  sdval="675" sdnum="1033;"><font color="#000000">675</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Tyson</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Julie</font></td>
		<td align="center" valign=top  sdval="280" sdnum="1033;"><font color="#000000">280</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Ruplin</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Dana</font></td>
		<td align="center" valign=top  sdval="195" sdnum="1033;"><font color="#000000">195</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Mayfield</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Heather</font></td>
		<td align="center" valign=top  sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Woodason</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Tara</font></td>
		<td align="center" valign=top  sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Windom</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Dylan</font></td>
		<td align="center" valign=top  sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Millwood</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Rena</font></td>
		<td align="center" valign=top  sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Adams</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Amy</font></td>
		<td align="center" valign=top  sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Jeffery</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Jennifer</font></td>
		<td align="center" valign=top  sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Beard</font></td>
		<td align="center" valign=top  sdnum="1033;0;@"><font color="#000000">Daniela</font></td>
		<td align="center" valign=top  sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>
	</table>
	</div>
	</div> <!-- row close -->

<div class="row">
	<div class="col-md-4" style="text-align: center;">
	<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">WOMENS MIXED 3.5 - 50 &amp; Over (TOP 20)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stokes</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tesha</font></td>
		<td align="center" valign=top sdval="250" sdnum="1033;"><font color="#000000">250</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mircio</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roselyn</font></td>
		<td align="center" valign=top sdval="250" sdnum="1033;"><font color="#000000">250</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Katt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Beth</font></td>
		<td align="center" valign=top sdval="190" sdnum="1033;"><font color="#000000">190</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Farriba</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ellie</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lavey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ellen</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Medlock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tracy</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Naiser</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Valerie</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hampton</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Deborah</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Blaginin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Karla</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kight</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Leanne</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stone</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bonnie</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pitts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Darlene</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lewis</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Charlie</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Blihovde</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Diana</font></td>
		<td align="center" valign=top sdval="110" sdnum="1033;"><font color="#000000">110</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Gourlay</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rebecca</font></td>
		<td align="center" valign=top sdval="110" sdnum="1033;"><font color="#000000">110</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ding</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lili</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dowdy</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bev</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shedd</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Naomi</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mclean</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Carol</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Thomason</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tracy</font></td>
		<td align="center" valign=top sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Spratt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jenny</font></td>
		<td align="center" valign=top sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>

	</table>
	</div>

	<div class="col-md-4" style="text-align: center;">
	<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">WOMENS MIXED 4.0+  -  49 &amp; Under (TOP 20)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Everett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Katrina</font></td>
		<td align="center" valign=top sdval="505" sdnum="1033;"><font color="#000000">505</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bennett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ripley</font></td>
		<td align="center" valign=top sdval="320" sdnum="1033;"><font color="#000000">320</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kind</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kristy</font></td>
		<td align="center" valign=top sdval="310" sdnum="1033;"><font color="#000000">310</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jones</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Melissa</font></td>
		<td align="center" valign=top sdval="225" sdnum="1033;"><font color="#000000">225</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Crowley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Marnie</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hooper</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lilly</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Borer</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rebecca</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Simon</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Angela</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maddrey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maggie</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jaeger</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">LeAnn</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">O'Kelley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Morgan</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rackley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Emily</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="13" sdnum="1033;"><font color="#000000">13</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martinez</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Denisse</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jaeger</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Heather</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">D'Souza</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Marissa</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="16" sdnum="1033;"><font color="#000000">16</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">San Martin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vanessa</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	</table>
	</div>
	</div> <!-- row close -->

	<!-- <div class="col-md-4" style="text-align: center;">
	<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">

	</table>
	</div> -->



</div>
<!-- Women's Mixed Doubles -->


<!-- Men's Mixed Doubles -->
<div id="mens_mx_gpa_rankings">
	<div class="row">
		<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">MENS MIXED 3.0 - 49 &amp; Under (TOP 20)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lyons</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">David</font></td>
		<td align="center" valign=top sdval="380" sdnum="1033;"><font color="#000000">380</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">McGrath</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Garrick</font></td>
		<td align="center" valign=top sdval="230" sdnum="1033;"><font color="#000000">230</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Caffee</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Steven</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Austin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ian</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Baggett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Charlie</font></td>
		<td align="center" valign=top sdval="120" sdnum="1033;"><font color="#000000">120</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">O'Kelley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Javan</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Williams</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Freddie</font></td>
		<td align="center" valign=top sdval="100" sdnum="1033;"><font color="#000000">100</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Klein</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Conner</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Morrison</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Alex</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">kelly</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">timothy</font></td>
		<td align="center" valign=top sdval="40" sdnum="1033;"><font color="#000000">40</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="11" sdnum="1033;"><font color="#000000">11</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Grant</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Royce</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Gibbs</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Josh</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Barber</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Christopher</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shue</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Talsania</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kris</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">OKelley</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shawn</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wade</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lee</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Oliver</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Michael</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Storey-Pitts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kevin</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
</table>

		</div> 
		<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">MENS MIXED 3.0 - 50 &amp; Over (TOP 20)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Hazlett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Scott</font></td>
		<td align="center" valign=top sdval="260" sdnum="1033;"><font color="#000000">260</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Perkins</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lee</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Holt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Frank</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Humphrey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Marc</font></td>
		<td align="center" valign=top sdval="155" sdnum="1033;"><font color="#000000">155</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bates</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chris</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Griffin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mallary</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ken</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vann</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">David</font></td>
		<td align="center" valign=top sdval="120" sdnum="1033;"><font color="#000000">120</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pitts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Michael</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stout</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dwight</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Greenwood</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Toby</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bardes</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keith</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pearman</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Parker</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Loftus</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Duane</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Waterstone</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bob</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wessell</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Scott</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Aragon</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Edward</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sorenson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Todd</font></td>
		<td align="center" valign=top sdval="30" sdnum="1033;"><font color="#000000">30</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Pollock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">David</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Saviello</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tim</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Payne</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kenny</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mullen</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kevin</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bivens</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lee</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>

</table>
		</div> 
		<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">MENS MIXED 3.5 - 49 &amp; Under (TOP 20)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Olszanski</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Leandro</font></td>
		<td align="center" valign=top sdval="360" sdnum="1033;"><font color="#000000">360</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Tyson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ira</font></td>
		<td align="center" valign=top sdval="280" sdnum="1033;"><font color="#000000">280</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Turner</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="245" sdnum="1033;"><font color="#000000">245</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ruplin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Matthew</font></td>
		<td align="center" valign=top sdval="195" sdnum="1033;"><font color="#000000">195</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ruiz</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roger</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kight</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Andy</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Poore</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Byron</font></td>
		<td align="center" valign=top sdval="160" sdnum="1033;"><font color="#000000">160</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Nance</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeff</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wilson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Josh</font></td>
		<td align="center" valign=top sdval="50" sdnum="1033;"><font color="#000000">50</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bax</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Raoul</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Roberts</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">John</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Koszalkowski</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Joshua</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Childree</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keith</font></td>
		<td align="center" valign=top sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vega</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jose</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Greer</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sean</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brace</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Warren</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Moultrie</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Arnrae</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Short</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Todd</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Miller</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lamar</font></td>
		<td align="center" valign=top sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
	</tr>

</table>
		</div> 
	</div><!-- row close -->
	<div class="row">
		<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">MENS MIXED 3.5 - 50 &amp; Over (TOP 20)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Choe</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sung</font></td>
		<td align="center" valign=top sdval="610" sdnum="1033;"><font color="#000000">610</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Benario</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Fred</font></td>
		<td align="center" valign=top sdval="460" sdnum="1033;"><font color="#000000">460</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stokes</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Eddie</font></td>
		<td align="center" valign=top sdval="330" sdnum="1033;"><font color="#000000">330</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Martin</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">John</font></td>
		<td align="center" valign=top sdval="275" sdnum="1033;"><font color="#000000">275</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="5" sdnum="1033;"><font color="#000000">5</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Minniefield</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stanley</font></td>
		<td align="center" valign=top sdval="240" sdnum="1033;"><font color="#000000">240</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Maddox</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brent</font></td>
		<td align="center" valign=top sdval="220" sdnum="1033;"><font color="#000000">220</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bennett</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Steven</font></td>
		<td align="center" valign=top sdval="215" sdnum="1033;"><font color="#000000">215</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Medlock</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Nathan</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Farriba</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mark</font></td>
		<td align="center" valign=top sdval="170" sdnum="1033;"><font color="#000000">170</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Rahn</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stephen</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Levesque</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Lee</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jeffery</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Adrian</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="12" sdnum="1033;"><font color="#000000">12</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Bailey</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Sean</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="14" sdnum="1033;"><font color="#000000">14</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Gibson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Glenn</font></td>
		<td align="center" valign=top sdval="135" sdnum="1033;"><font color="#000000">135</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Stone</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Robert</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="15" sdnum="1033;"><font color="#000000">15</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">quigg</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">kevin</font></td>
		<td align="center" valign=top sdval="125" sdnum="1033;"><font color="#000000">125</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="17" sdnum="1033;"><font color="#000000">17</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dutton</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Danny</font></td>
		<td align="center" valign=top sdval="115" sdnum="1033;"><font color="#000000">115</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="18" sdnum="1033;"><font color="#000000">18</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Presberg</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Leonard</font></td>
		<td align="center" valign=top sdval="110" sdnum="1033;"><font color="#000000">110</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="19" sdnum="1033;"><font color="#000000">19</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">McCook</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Keven</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dowdy</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Ronnie</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="20" sdnum="1033;"><font color="#000000">20</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Fallgatter</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dieter</font></td>
		<td align="center" valign=top sdval="80" sdnum="1033;"><font color="#000000">80</font></td>
	</tr>
</table>
		</div> 
		<div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
	<tr style='font-weight:bold;'>
		<td colspan=4 height="20" align="center" valign=bottom><b><font color="#000000">MENS MIXED 4.0 +  -  49 &amp; Under (TOP 10)</font></b></td>
		</tr>
	<tr style='font-weight:bold;'>
		<td height="20" align="center" valign=bottom><b><font color="#000000">Rank</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">First Name</font></b></td>
		<td align="center" valign=top sdnum="1033;0;@"><b><font color="#000000">Last Name</font></b></td>
		<td align="center" valign=top><b><font color="#000000">Points</font></b></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="1" sdnum="1033;"><font color="#000000">1</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Vantreese</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Justin</font></td>
		<td align="center" valign=top sdval="805" sdnum="1033;"><font color="#000000">805</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="2" sdnum="1033;"><font color="#000000">2</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Holt</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Josh</font></td>
		<td align="center" valign=top sdval="195" sdnum="1033;"><font color="#000000">195</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="3" sdnum="1033;"><font color="#000000">3</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Feagans</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Robert</font></td>
		<td align="center" valign=top sdval="150" sdnum="1033;"><font color="#000000">150</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Jezerinac</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Peter</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="4" sdnum="1033;"><font color="#000000">4</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Underwood</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Shea</font></td>
		<td align="center" valign=top sdval="140" sdnum="1033;"><font color="#000000">140</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="6" sdnum="1033;"><font color="#000000">6</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mcdonald</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Kevin</font></td>
		<td align="center" valign=top sdval="105" sdnum="1033;"><font color="#000000">105</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="7" sdnum="1033;"><font color="#000000">7</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Smith</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Dahm</font></td>
		<td align="center" valign=top sdval="95" sdnum="1033;"><font color="#000000">95</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="8" sdnum="1033;"><font color="#000000">8</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Wilson</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Brett</font></td>
		<td align="center" valign=top sdval="90" sdnum="1033;"><font color="#000000">90</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="9" sdnum="1033;"><font color="#000000">9</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Heuermann</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Darin</font></td>
		<td align="center" valign=top sdval="70" sdnum="1033;"><font color="#000000">70</font></td>
	</tr>
	<tr>
		<td height="20" align="center" valign=bottom sdval="10" sdnum="1033;"><font color="#000000">10</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Mason</font></td>
		<td align="center" valign=top sdnum="1033;0;@"><font color="#000000">Chase</font></td>
		<td align="center" valign=top sdval="60" sdnum="1033;"><font color="#000000">60</font></td>
	</tr>
</table>
		</div> 
		<!-- <div class="col-md-4" style="text-align: center;">
<table class='table' class='table' cellspacing="0" border="0" style="background-color: #f1f0f0;">
		Men's Mixed 6
</table>
		</div>  -->
	</div><!-- row close -->
</div>
<!-- Men's Mixed Doubles -->



</div><!-- container close -->
</div> <!-- Container close -->