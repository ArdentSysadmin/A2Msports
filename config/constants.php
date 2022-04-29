<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Custom Constants
|--------------------------------------------------------------------------
*/

define('FROM_EMAIL', 'admin@a2msports.com');
//define('FROM_EMAIL', 'info@a2msports.com');
//define('TEST_FINT_EMAIL', 'hr@fintinc.com');
define('FB_APPID', '201602263551845');
define('FB_KEY', '2e07275226a7aa868e13179d8f449b40');
define('FB_REDIRECT', 'https://a2msports.com/login/validate_login');
define('BANNER_TEXT', 'Connecting Players, Coaches and Clubs');
define('GEO_LOC_KEY', 'AIzaSyC3_BjoW6T6jkMOL31GmDBeeVTv-NaI2Cg');

define('SANDBOX_PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('SANDBOX_PAYPAL_ID', 'admin-facilitator@a2msports.com');

define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');
define('PAYPAL_ID', 'admin@a2msports.com');

define('RESERVE_BLOCKED_CLUBS', serialize (array(1182, 1187)));

define('TOURN_DEF_IMGS', serialize (array(1 => 'default_tennis.jpg', 2 => 'default_table_tennis.jpg', 3 => 'default_badminton.jpg', 4 => 'default_golf.jpg', 5 => 'default_racquet_ball.jpg', 6 => 'default_squash.jpg', 7 => 'default_pickleball_new.jpg', 8 => 'default_chess.jpg', 9 => 'default_carroms.jpg', 10 => 'default_volleyball.jpg', 11 => 'default_fencing.jpg', 12 => 'default_bowling.jpg', 16 => 'default_cricket.jpg', 18 => 'default_basketball1.jpg' )));

define('TOURN_DEF_ICONS', serialize (array(1 => 'tennis-ico.png', 2 => 'tt-ico.png', 3 => 'badminton-ico.png', 4 => 'golf-ico.png', 5 => 'racquet-icon.png', 6 => 'squash-icon.png', 7 => 'pickleball-icon.png', 8 => 'chess-icon.png', 9 => 'carrom-icon.png', 10 => 'volleyball-icon.png', 11 => 'fencing1-icon.png', 12 => 'bowling-icon.png', 16 => 'cricket-icon.png', 18 => 'basketball-icon.png' )));



//define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
//define('PAYPAL_ID', 'admin-facilitator@a2msports.com');


/* End of file constants.php */
/* Location: ./application/config/constants.php */