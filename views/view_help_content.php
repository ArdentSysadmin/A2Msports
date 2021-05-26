<?php 
$url2 = $_SERVER['QUERY_STRING'];
?>
<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
var abc = "<?php echo $url2; ?>";

$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: abc }); //some_id section1 in demo
});
});
</script>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<h3 style="text-align:left">Browse for help topics</h3>
<div class="accordion" id="section1"><i class="fa fa-arrow-circle-o-right"></i>Club Management<span></span></div>
<div class="acc-content" style="padding:10px">
	<p><b>What features do you offer for clubs? </b></p>
	<p>We offer free website to clubs with all our features like Tournament/ League Software, Players Ratings/ Rankings, Court/ Table Reservation System, Customer Engagement features. </p>
	
	<p><b>How do you charge for your services? </b></p>
	<p>We charge a monthly, quarterly or annual service fee from the clubs for all our sevices. One club, one price. We don't charge per feature.</p>

	<p><b>Do you take commission on sales? </b></p>
	<p>No commisions on sales. We only charge a monthly service fee. Your payment Gateway may have commissions from the sales though!</p>
	
	<p style="margin-top:30px"><b>What is Customer Engagement?</b></p>
	<p>We monitor the members dues and notify the members and the club owners if the membership expired and the fees are due. We provide an option to send notificaitons to your customers anytime you want to communicate with them. We are adding more features like attendance to clubs, QR Code scanning etc. soon!</p>
</div>

<div class="accordion" id="section2"><i class="fa fa-arrow-circle-o-right"></i>FAQ - General<span></span></div>
<div class="acc-content" style="padding:10px">
	<p><b>What types of tournaments you support? </b></p>
	<p>We support regular tournaments, Leagues and Challenge Ladders. We suport Team Tournaments and Team Leagues as well. </p>
	
	<p><b>What types of brackets you support? </b></p>
	<p>We support Single Elimination, Consolation, Round Robin, Playoffs, Switch Doubles. Each tournament may have any or all of these draws as needed. </p>
	
	
	<p><b>Who Creates a Tournament? </b></p>
	<p>At this point, there is no restriction on creating a tournament. So, anyone who wants to organize a tournament with at least 3 or more players can create a tournament.</p>
	
	<p><b>What's the difference between a Tournament and a League?</b></p>
	<p>Tournaments usually run on a day or a couple of days, where as the leagues run over longer time (weeks). Leagues will have a Game Day, usually, once a week (rarely, twice or more often). Players can register in a league for all Game Days, or any particular Game Day, based on the number of available spots. </p>
	
	<p><b>What is a Flexible League? </b></p>
	<p>Flexible League will give the players an option to play at different places and different times, usually over a period of time. Players will choose a place they like to play (Home) and when the tournament admin creates the draws, it'll automatically creates half of the matches/ games at the player's Home court/ club and half of them Away.</p>
	
	<p><b>What is a Challenge Ladder? </b></p>
	<p>Challenge Ladder is a League with many players where players can challenge each other and earn points for playing. We support Challenge Ladders for Singles and Doubles.</p>
	
	
	<p style="margin-top:30px"><b>Is there a fee to create a tournament?</b></p>
	<p>There is no fee to create a tournament. You can create and orgnize tournaments for free up to one year. If you orgnize more tournaments in an year and wants to have a custom page,please contact us for pricing information.</b></p>

	<p style="margin-top:30px"><b>Can I do Round Robin in the fist round and knockout after that?</b></p>
	<p>Yes. We support two different types of playoffs after a round robin. A Simple Knockout or a Elminator-Qualifier style as well.</p>

	<p style="margin-top:30px"><b>What is 'A2M Score' and how do you come up with rankings?</b></p>
	<p>A2M Score is our way of rating a player. We use a proprietary algorithm based on the number of matches played, won and lost by each player. All players start at a score of 100. The more matches you play and win, your score will keep going up. If you win against a player that has higher A2M Score than you, you will get more points. A2M Score is adjusted for every match you play on our system. We are constantly enhancing our system to provide more accurate scores and ranking system. The more you play the accurate the system will be.</p>
</div>
<div class="accordion" id="section3"><i class="fa fa-arrow-circle-o-right"></i>Golf<span></span></div>
<div class="acc-content" style="padding:10px">
	<p><b>How many holes to play in one round?</b></p>
	<p>There are no restrictions. You play 9, 18 or anywhere in between. We calculate the scores based on what you enter.</p>
	
	<p style="margin-top:30px"><b>Would you pay the Golf Course entry fee?</b></p>
	<p>You need to pay any entry fees associated with the Golf Club. We'll find a player for you.</p>
</div>

<div class="accordion" id="section4"><i class="fa fa-arrow-circle-o-right"></i>Tennis<span></span></div>
<div class="acc-content" style="padding:10px">
	<p><b>How many sets do I play in a tennis match?</b></p>
	<p>It is completely up to you. To report a score we need at least one set of scores We allow up to 6 sets in a tennis match.</p>
	
	<p style="margin-top:30px"><b>What kind of balls should I play when playing with under 12 players?</b></p>
	<p>It is completely up to you and your opponent. You can play with whichever you are most comfortable with.</p>
</div>

<div class="accordion" id="section4"><i class="fa fa-arrow-circle-o-right"></i>Table Tennis<span></span></div>
<div class="acc-content" style="padding:10px">
	<p><b>For how many points do I play a game?</b></p>
	<p>It is completely up to you. You can either play 11 point game or 21 point game. You need to win by two points.</p>
	
	<p style="margin-top:30px"><b>Would you find a place to play for me?</b></p>
	<p>We are working with multiple sports academies to provide space for you to play. However, you may still have to pay an entry fee to play in those.</p>
</div>

<div class="accordion" id="section5"><i class="fa fa-arrow-circle-o-right"></i>Badminton<span></span></div>
<div class="acc-content" style="padding:10px">
	<p style="margin-top:30px"><b>Would you find a place to play for me?</b></p>
	<p>We are working with multiple sports academies to provide space for you to play. However, you may still have to pay an entry fee to play in those.</p>
	
	<p><b>For how many points do I play a game?</b></p>
	<p>It is completely up to you. You can either play 11 point game or 21 point game. You need to win by two points.</p>
</div>

<div class="accordion" id="section6"><i class="fa fa-arrow-circle-o-right"></i>Squash<span></span></div>
<div class="acc-content" style="padding:10px">
	<p style="margin-top:30px"><b>Would you find a place to play for me?</b></p>
	<p>We are working with multiple sports academies to provide space for you to play. However, you may still have to pay an entry fee to play in those.</p>
	
	 <p><b>For how many points do I play a game?</b></p>
	<p>It is completely up to you. You can either play 11 point game or 21 point game. You need to win by two points.</p>
</div>

<div class="accordion" id="section7"><i class="fa fa-arrow-circle-o-right"></i>Team Leagues<span></span></div>
<div class="acc-content" style="padding:10px">
	<p style="margin-top:30px"><b>What are Team Leagues and how do they work? </b></p>
	<p>Team Leagues @ A2M Sports are for a team of 3 or higher number of players play against a team with similar # of players. It’s just a regular tournament, but the Draws or Brackets will be done at a Team Level (compared to an individual level in a regular tournament). Your Team will be the winner or 2nd place etc.</p></br>
	
	<p><b>What are Lines in a Team?</b></p>
	<p>Lines are individual matches within a team. If a League Consists of two Singles and three Doubles matches, then, we play two singles lines and three doubles lines. Generally, Line1 (for both singles and doubles) is for Top Level Players in the team. Line2 is for the next level players, Line3 is for next lower level etc.</p></br>
	
	<p><b>How many Players or Lines are in a Team League?</b></p>
	<p>We support anywhere from 1 to 5 Singles and/ or Doubles Lines in each league. Tournament Admin can define the number of lines for his/her league depending on their League.</p></br>
	
	<p><b>Who can form or create a team?</b></p>
	<p>Anyone that wants to lead a group of players and be responsible to manage their entries in and out of the team and is willing to enter scores could form a Team. Usually, Teams represent your Club, School, Academy or your neighborhood. Person that creates the team will automatically become a Team Captain. However, you can always make other players as Team Captain.</p></br>
	
	<p><b>How do I find a Team or join a team?</b></p>
	<p>Once you login to our site, under your name (on Top Right Corner), you will see My Teams page. On My Teams page, you will see a list of Nearby Teams that may be of interest to you. You can join any of those team(s) by sending a Join Request to the Team Captain. Your Team Captain will accept or Deny your request.</p></br>
	
	<p><b>How do I withdraw from a team?</b></p>
	<p>On My Teams page, you will see an option to Withdraw. You just have to click that button!</p></br>
	
	<p><b>How do I register for a Team League?</b></p>
	<p>If you are the team captain, you register your team and yourself for the league. If you are just a player, your Team Captain will add you to the team and you will be automatically registered to the league. If you don’t want to be a Team Captain and just want to play in the league, you need to join a team first. You can do this on your Teams Page by sending a Join Request to the Team Captain.</p></br>
	
	<p><b>What are Team Captain’s tasks/ responsibilities?</b></p>
	<p>Team Captains are responsible to manage their team online and on the court while playing. They can add or remove players from participating in a league or tournament. They are responsible to schedule matches by coordinating with the other Team Captains and enter the scores for their team (if they win the match). They can also organize the social events for the team, though we don’t mandate it:).</p></br>
	
	<p><b>Who enters the Score for the matches? And, How?</b></p>
	<p>Team Captains will have to print a Scorecard for each match. Once the match is played, both captains will enter the scores on the scorecard and sign each other's copy. When they get  chance, generally a winning team captain will enter the score online by clicking Add Score on the tournament page.</p></br>
								
	<p><b>What is the maximum Team Size?</b></p>
	<p>Right now, the team size is limited to 15. However, if there is a specific need to increase it, you can contact us..</p></br>
	
	<p><b>Can I create a team league with different size of teams? Or, can I customize my team league?</b></p>
	<p>Yes. You can create League with any number of players. Your league may have one Singles and one Doubles Lines (3 players), or, up to 10 singles and 5 doubles lines (15 players) or, anywhere in between. Once you create a league, all teams will have a minimum # of players to support each line..</p></br>
	
	<p><b>Do you have any restrictions on players playing at different levels?</b></p>
	<p>In a single match (one team vs the other team), the same player can NOT play in multiple lines. This is the only restriction from our application. There may be other restrictions that your Tournament Director may impose for a specific league. .</p></br>
	
	<p><b>Do you support all types of Brackets for Team Leagues?</b></p>
	<p>Yes. We support, Round Robin, Single Elimination and Consolation types for Team Leagues as well.</p></br>
</div>
<div class="accordion" id="section8"><i class="fa fa-arrow-circle-o-right"></i>Pickleball<span></span></div>
<div class="acc-content" style="padding:10px">
	 <p style="margin-top:30px"><b>What is Pickleball? </b></p>
	<p>Well, Wikipedia says it's "a game resembling tennis in which players use paddles to hit a perforated plastic ball over a net". If you want a better definition, check out USAPA.org site, at https://www.usapa.org/what-is-pickleball/ and we think that should clear it up.</p></br>
	
	<p><b>What kind of Pickleball tournaments you support?</b></p>
	<p>We support most formats of tournaments in Pickleball. Singles, Doubles, Mixed Doubles formats.  We also support team leagues of different sizes.</p></br>

	<p><b>Do you support Leaues and Flexible Leagues for my club?</b></p>
	<p>Yes. You can do leagues and flexible leagues as well on our platform. It's by far, the best Flexible League platform with ease of use on the website and mobile app support.</p></br>

	<p><b>Do you support Ladder Leaues?</b></p>
	<p>Of course! You can do the league with Singles or Switch Doubles (Partner Rotation) leagues with variety of statistics.</p></br>
	
	<p><b>What type of brackets you support?</b></p>
	<p>Round Robin, Sinlge Elimination, Consolation and Switch Doubles brackets are supported. You can do a Round Robin with a Playoff too.</p></br>

	<p><b>Do you give ratings for Pickleball Players?</b></p>
	<p>Yes. We provide Ratings to all players who play in our leagues and tournaments. Players rating will change based on the opponents' rating and can vary between 2.0 and 6.0.</p></br>
	
	<p><b>Where do I find more Pickleball Events or Players?</b></p>
	<p>You can find Pickleball players with their ratings, all our tournaments, Leagues and more at https://a2msports.com/pickleball</p></br>
</div>

</div><!--Close Top Match-->
