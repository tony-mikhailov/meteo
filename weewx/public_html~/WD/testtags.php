<?php
//
// Weewx-WD Testtags.php Version 1.07 (refer Weewx-WD Wiki for changelog)
//
// Template Version: 1.0.0a2              Date: 13 December 2014 12:00 UTC+10
//
// Based on the Work by Ken True - Saratoga-Weather.org and others
//
// This file was produced by Weewx-WD and and is compatible with testtags.php
// version 1.07. Version 1.07 includes support for:
//
// WebsterWeather:  http://www.websterweatherlive.com/wxScripts.php
//   Alt-Dashboard 4.xx Script (Pre-Rainer's JavaScript)    V4.30   18-FEB-2011
//   Alt-Dashboard 5.xx Script                              V5.20   18-FEB-2011
//   UpdatedAlt-Dashboard 6.xx Script                       V6.20   27-JUN-2011
//   UpdatedMOBILE Dashboard 1.xx Script                    V1.30   15-JUL-2011
//   High/Low/Averages Script Ver 3 Ajax-PHP Template Only  V3.01   25-MAR-2011
//
// 642weather (MChallis) http://www.642weather.com/weather/scripts-printable-flyer.php
//   Printable Flyer Add-on for WD/PHP/AJAX Website Template V1.12  06-Nov-2009
//
// Eastmasonville http://eastmasonvilleweather.com/downloads.php
//   Station Records (wxrecords)                            V1.13   24-May-2011
//
// Relayweather http://www.relayweather.com/downloads.php
//   Temperature and Rain Trending (wxglobalwarming)        V1.0    20-Jan-2010
//

// allow viewing of generated source
if ( isset($_REQUEST['sce']) && strtolower($_REQUEST['sce']) == 'view' ) {
//--self downloader --
   $filenameReal = __FILE__;
   $download_size = filesize($filenameReal);
   header('Pragma: public');
   header('Cache-Control: private');
   header('Cache-Control: no-cache, must-revalidate');
   header("Content-type: text/plain");
   header("Accept-Ranges: bytes");
   header("Content-Length: $download_size");
   header('Connection: close');
   readfile($filenameReal);
   exit;
}
//
// Following date/time format strings were used from skin.conf. 
// Time format string: %H:%M
// Long time format string: %H:%M:%S
// Second format string: %S
// Minute format string: %M
// Hour format string: %H
// Date format string: %-d/%-m/%Y
// Day format string: %d
// Day name format string: %A
// Weekday number format string: %w
// Day of year format string: %j
// Month format string: %m
// Month name format string: %B
// Year format string: %Y
// Date time format string: %-d/%-m/%Y %H:%M
// Ephemeris date time format string: %H:%M UTC %-d %B %Y
// Record date format string: %-d %b %Y
//
//
// Units
// -----
$uomtemp = '&deg;C'; //  = 'C', 'F',  (or  'C', 'F', or '&deg;C', '&deg;F' )
$uombaro = 'hPa'; //  = 'inHg', 'hPa', 'kPa', 'mb'
$uomwind = 'km/h'; //  = 'kts','mph','kmh','km/h','m/s','Bft'
$uomrain = 'mm'; //  = 'mm', 'in'
$datefmt = 'd/m/y'; //  =  'd/m/y', 'm/d/y'
$uomdistance = 'km'; // = 'mi','km'  (for windrun variables)
//
// General or Non-Weather Specific Sun/Moon
// ----------------------------------------
$time = '04:11';
$date = '6/3/2016';
$sunrise = '06:43';
$time_minute = '11';
$time_hour = '04';
$date_day = '06';
$date_month = '03';
$date_year = '2016';
$monthname = 'March';    // Current month name
$dayname = 'Sunday';    // Current day name
$sunset = '17:53';// sunset time
$moonrisedate = 'N/A';// moon rise date
$moonrise = 'N/A';// moon rise time
$moonsetdate = 'N/A';// moon set date
$moonset = 'N/A';// moon set time
$moonage = 'N/A';// current age of the moon (days since new moon)
$moonphase = '8%';// Moon phase %
$moonphasename = 'Waning crescent'; // 10.36z addition
$marchequinox = 'N/A';// March equinox date
$junesolstice = 'N/A';// June solstice date
$sepequinox = 'N/A';// September equinox date
$decsolstice = 'N/A';// December solstice date
$newmoon = 'N/A';// Date/time of the previous new moon
$nextnewmoon = 'N/A';// Date/time of the next new moon for next month
$firstquarter = 'N/A';// Date/time of the next/last first quarter moon
$lastquarter = 'N/A';// Date/time of the next/last last quarter moon
$fullmoon = 'N/A';// Date/time of the next/last full moon
$fullmoondate = 'N/A';// Date of the next/last full moon (date only)
$moonperihel = '10:56 UTC 4 January 2017';// Next Moon perihel date
$moonaphel = '15:56 UTC 4 July 2016';// Next moon perihel date
$moonperigee = '07:02 UTC 10 March 2016';// Next moon perigee date
$moonapogee = '14:17 UTC 25 March 2016';// Next moon apogee date
$suneclipse = '01:57 UTC 9 March 2016';// Next sun eclipse
$mooneclipse = '11:47 UTC 23 March 2016';// Next moon eclipse date
$easterdate = '27 Mar 2016';// Next Easter date
$chinesenewyear = '28 Jan 2017';// Chinese new year
$hoursofpossibledaylight = '11:10:29';// Total hours/minutes of possible daylight for today
$weatherreport = 'N/A';     //current weather conditions from selected METAR
$stationaltitude = '502';   // Station altitude, feet, as set in the units setup
$stationlatitude = '54:33:36'; // Latitude (from the sun moon rise/set setup)
$stationlongitude = '43:11:24';   // Longitude (from the sun moon rise/set setup)
$windowsuptime = '0 days, 2 hours, 9 minutes'; // uptime for OS on system
$freememory = '517860 kB'; // amount of free memory on the pc
$Startimedate = '6/3/2016 03:19'; // Time/date WD was started
$NOAAEvent = 'N/A'; // NOAA Watch/Warning/Advisory
$noaawarningraw = 'N/A'; // NOAA RAW watch/warning/advisory

$swversion = '3.4.0';  // Weather Display version number you are running
$swversiononly = '3.4.0';
$noaacityname = 'N/A';  // City name,from the noaa setup (in the av/ext setup)
$timeofnextupdate = '04:12';    // Time of next Update/Upload of the weather data to your web page
$heatcolourword = 'Cold';   // How hot/cold it feels at the moment, based on the humidex, used with the conditionscolour.jpg
//
// Temperature/Humidity
// --------------------
// Current:
// --------
$temperature = '-0.6';
$tempnodp = '-1';
$humidity = '80';
$indoortemp = '17.3';
$dewpt = '-3.7';
$maxtemp = '0.4';
$maxtempt = '02:30';
$mintemp = '-0.6';
$mintempt = '04:11';

$feelslike =  '-0.6';   // Shows heat index or humidex or windchill (if less than 16oC)

$heati = '-0.6';    // current heat index
$heatinodp = '-1';    // current heat index,no decimal place
$windch = '-0.6';   // current wind-chill
$windchnodp = '-1';    // current wind-chill, no decimal place
$humidexfaren = '25.6';  // Humidex value in oF
$humidexcelsius = '-3.6';    // Humidex value in oC
$apparenttemp = '-3.1'; // Apparent temperature
$apparenttempc = '-3.1';   // Apparent temperature, oC
$apparenttempf = '26.4';   // Apparent temperature, oF
$apparentsolartemp = '-3.2'; // Apparent temperature in the sun (you need a solar sensor)
$apparentsolartempc = '-3.2';    // Apparent temperature in the sun, oC (you need a solar sensor)
$apparentsolartempf = '26.2';   // Apparent temperature in the sun, oF (you need a solar sensor)
//
$WUmaxtemp = '0'; // Todays average max temperature from the selected Wunderground almanac station
$WUmintemp = '0'; // Todays average min temperature from the selected Wunderground almanac station
// 
$WUmaxtempr = '0';    // Todays record max temperature from the selected Wunderground almanac station
$WUmintempr = '0';    // Todays record min temperature from the selected Wunderground almanac station
$WUmaxtempryr = 'N/A';  // Year that it occured
$WUmintempryr = 'N/A';  // year that it occured
// 
// Yesterday:
// ----------
$tempchangehour = '-1.0';   // Temperature change in the last hour
$maxtempyest = '0.4';  // Yesterday's max temperature
$maxtempyestt = '00:00'; // Time of yesterday's max temperature
$mintempyest = '-0.6';  // Yesterday's min temperature
$mintempyestt = '03:29'; // Time of yesterday's min temperature
//
// Trends:
// -------
$temp24hoursago = 'N/A'; // The temperature 24 hours ago
$humchangelasthour = '-0';  // Humidity change last hour
$dewchangelasthour = '-1.0'; // Dew point change last hour
$barochangelasthour = '-0.2';   // Baro change last hour
//
// Wind
// ----
// Current:
// --------
$avgspd = '0'; // average wind speed (current)
$gstspd = '0';  // current/gust wind speed
$maxgst = '0';    // today's maximum wind speed
$maxgstt = '04:11';   // time this occurred
$maxgsthr = '0 km/h'; // maximum gust last hour
$dirdeg = '359'; // wind direction (degrees)
$dirlabel = 'N';   // wind direction (NNE etc)
$maxgustlastimediatehourtime =  'N/A';  //   time that the max gust last prior 1 hour occurred
$avwindlastimediate10 = '0';  // Average wind for the last immediate 10 minute period
$avdir10minute =  '359';    // average ten minute wind direction (degrees)

$beaufortnum = '0'; //Beaufort wind force number
$currbftspeed = '0 bft'; //Current Beaufort wind speed
$bftspeedtext = 'Calm'; //Beaufort scale in text (i.e Fresh Breeze)
//
// Baromometer
// -----------
// Current:
// --------
$baro = '1052.8';
$baroinusa2dp = '31.09 inHg';  // Current barometer reading in inches, 2 decimal places only.
$trend = '-0.2';  // amount of change in the last hour

$trend3hour = 'N/A';  // amount of change in the last 3 hours
$pressuretrendname = 'Steady'; // pressure trend (i.e. 'falling'), last hour
$pressuretrendname3hour = 'N/A';   // pressure trend (i.e. 'falling'), last 3 hours

$vpforecasttext = '';
// Rain
// ----
// Current:
// --------
$dayrn = '1.0';
$monthrn = '3.8'; // rain so far this month
$yearrn = '3.8';   // rain so far this year
$dayswithnorain = '0'; // Consecutive days with no rain
$dayswithrain = '2'; // Days with rain for the month
$dayswithrainyear = '2';  // Days with rain for the year
$currentrainratehr = '0.0';   // Current rain rate, mm/hr (or in./hr)
$maxrainrate = '0.0'; // Max rain rate,for the day, mm/min (or in./min)
$maxrainratehr = '2.0';   // Max rain rate,for the day, mm/hr (or in.mm)
$maxrainratetime = '02:39';   // Time that occurred
// Yesterday:
// ----------
$yesterdayrain = '2.8';   // Yesterday rain
$vpstormrainstart = 'N/A';  //Davis VP Storm rain start date
$vpstormrain = 'N/A';           //Davis VP Storm rain value
//
// Sunshine/Solar/ET
// -----------------
$VPsolar = '0';//  Solar energy number (W/M2)
$highsolar = '0';// Daily high solar (for Davis VP and Grow stations)
$currentsolarpercent = '99 %';// Current solar percent for stations with a temperature solar sensor (like the dallas 1 wire)
$highsolartime = '02:30';// Time that the daily high solar occurred
$lowsolartime = '02:30';// Time that the daily low solar occurred
$VPuv = '0.0';// UV number
$highuv = '0.0';// Daily high UV (for Davis VP stations)
$highuvtime = '02:30';// Time that the daily high UV occurred
$lowuvtime = '02:30';// Time that the daily low UV occurred
$highuvyest = '0.0';// Yesterday's high UV
$highuvyesttime = '00:00';// Time of yesterday's high UV
$burntime = '99';// Time (minutes) to burn (normal skin) at the current UV rate, from the Davis VP with UV sensor
//
// Record Readings
// ---------------
// Current month to date:
// ----------------------
$mrecordwindgust = '0';   // Current month record high wind gust
$mrecordhighgustday = '06';   // Day of current month record high wind gust
//
// Tags needed for trends-inc.php
// ------------------------------
$temp0minuteago = '-0.6';  // ****this one is needed for all the others to work
$wind0minuteago = '0';
$gust0minuteago = '0';
$dir0minuteago = 'N';
$hum0minuteago = '80';
$dew0minuteago = '-3.7';
$baro0minuteago = '1052.8';
$rain0minuteago = '1.0';
$VPsolar0minuteago = '0';
$VPuv0minuteago =  '0.0';

$temp5minuteago = '-0.5';
$wind5minuteago = '0';
$gust5minuteago = '0';
$dir5minuteago = 'N';
$hum5minuteago = '80';
$dew5minuteago = '-3.6';
$baro5minuteago = '1052.9';
$rain5minuteago = '1.0';
$VPsolar5minuteago = '0';
$VPuv5minuteago = '0.0';

$temp10minuteago = '-0.5';
$wind10minuteago = '0';
$gust10minuteago = '0';
$dir10minuteago = 'N';
$hum10minuteago = '80';
$dew10minuteago = '-3.5';
$baro10minuteago = '1052.9';
$rain10minuteago = '1.0';
$VPsolar10minuteago = '0';
$VPuv10minuteago = '0.0';

$temp15minuteago = '-0.4';
$wind15minuteago = '0';
$gust15minuteago = '0';
$dir15minuteago = 'N';
$hum15minuteago = '80';
$dew15minuteago = '-3.4';
$baro15minuteago = '1052.9';
$rain15minuteago = '1.0';
$VPsolar15minuteago = '0';
$VPuv15minuteago = '0.0';

$temp20minuteago = '-0.3';
$wind20minuteago = '0';
$gust20minuteago = '0';
$dir20minuteago = 'N';
$hum20minuteago = '80';
$dew20minuteago = '-3.3';
$baro20minuteago = '1053.0';
$rain20minuteago = '1.0';
$VPsolar20minuteago = '0';
$VPuv20minuteago = '0.0';

$temp30minuteago = '-0.1';
$wind30minuteago = '0';
$gust30minuteago = '0';
$dir30minuteago = 'N';
$hum30minuteago = '80';
$dew30minuteago = '-3.1';
$baro30minuteago = '1053.0';
$rain30minuteago = '1.0';
$VPsolar30minuteago = '0';
$VPuv30minuteago = '0.0';

$temp45minuteago = '0.2';
$wind45minuteago = '0';
$gust45minuteago = '0';
$dir45minuteago = 'N';
$hum45minuteago = '80';
$dew45minuteago = '-2.8';
$baro45minuteago = '1053.0';
$rain45minuteago = '1.0';
$VPsolar45minuteago = '0';
$VPuv45minuteago = '0.0';

$temp60minuteago = 'N/A';
$wind60minuteago = 'N/A';
$gust60minuteago = 'N/A';
$dir60minuteago = 'N/A';
$hum60minuteago = 'N/A';
$dew60minuteago = 'N/A';
$baro60minuteago = 'N/A';
$rain60minuteago = '1.0';
$VPsolar60minuteago = 'N/A';
$VPuv60minuteago = 'N/A';

$temp75minuteago = '-0.2';
$wind75minuteago = '0';
$gust75minuteago = '0';
$dir75minuteago = 'N';
$hum75minuteago = '80';
$dew75minuteago = '-3.2';
$baro75minuteago = '1053.0';
$rain75minuteago = '0.8';
$VPsolar75minuteago = '0';
$VPuv75minuteago = '0.0';

$temp90minuteago = '0.1';
$wind90minuteago = '0';
$gust90minuteago = '0';
$dir90minuteago = 'N';
$hum90minuteago = '80';
$dew90minuteago = '-2.9';
$baro90minuteago = '1053.0';
$rain90minuteago = '0.5';
$VPsolar90minuteago = '0';
$VPuv90minuteago = '0.0';

$temp105minuteago = 'N/A';
$wind105minuteago = 'N/A';
$gust105minuteago = 'N/A';
$dir105minuteago = 'N/A';
$hum105minuteago = 'N/A';
$dew105minuteago = 'N/A';
$baro105minuteago = 'N/A';
$rain105minuteago = 'N/A';
$VPsolar105minuteago = 'N/A';
$VPuv105minuteago = 'N/A';

$temp120minuteago = 'N/A';
$wind120minuteago = 'N/A';
$gust120minuteago = 'N/A';
$dir120minuteago = 'N/A';
$hum120minuteago = 'N/A';
$dew120minuteago = 'N/A';
$baro120minuteago = 'N/A';
$rain120minuteago = 'N/A';
$VPsolar120minuteago = 'N/A';
$VPuv120minuteago = 'N/A';

$VPet = '0.7';
$VPetmonth = '179.4';
$dateoflastrainalways = '6/3/2016';
$highbaro = '1053.0';
$highbarot = '02:30';
$highsolaryest = '0';
$highsolaryesttime = '00:00';
$hourrn =  '0';
$maxaverageyest = '0 km/h N';
$maxaverageyestt = '03:30';
$maxavgdirectionletter = 'N';
$maxavgspd = '0 km/h';
$maxavgspdt = '04:11';
$maxbaroyest = '1053.0';
$maxbaroyestt = '00:00';
$maxgstdirectionletter = 'N';
$maxgustyest = '0 km/h N';
$maxgustyestt = '03:29';
$mcoldestdayonrecord = 'NA  on: --';
$mcoldestnightonrecord = '-0.6&deg;C  on: 6 Mar 2016';
$minchillyest = '-0.6';
$minchillyestt = '03:29';
$minwindch = '-0.6';
$minwindcht = '04:11';
$mrecordhighavwindday = '06';
$mrecordhighavwindmonth = '03';
$mrecordhighavwindyear = '2016';
$mrecordhighbaro = '1053.0';
$mrecordhighbaroday = '04';
$mrecordhighbaromonth = '03';
$mrecordhighbaroyear = '2016';
$mrecordhighgustmonth = '03';
$mrecordhighgustyear = '2016';
$mrecordhightemp = '0.4';
$mrecordhightempday = '04';
$mrecordhightempmonth = '03';
$mrecordhightempyear = '2016';
$mrecordlowchill = '-0.6';
$mrecordlowchillday = '06';
$mrecordlowchillmonth = '03';
$mrecordlowchillyear = '2016';
$mrecordlowtemp = '-0.6';
$mrecordlowtempday = '06';
$mrecordlowtempmonth = '03';
$mrecordlowtempyear = '2016';
$mrecordwindspeed = '0'; // Month Record Avg Wind Speed
$mwarmestdayonrecord = 'NA  on: --';
$mwarmestnightonrecord = '-0.6&deg;C  on: 6 Mar 2016';
$raincurrentweek = '3.8';
$raintodatemonthago = 'N/A';
$raintodateyearago = 'N/A';
$timeoflastrainalways = '02:57';
$windruntodatethismonth = '0.3 km';
$windruntodatethisyear = '0.3 km';
$windruntoday = '0.0';
$yesterdaydaviset = '70.9';
$yrecordhighavwindday = '06';
$yrecordhighavwindmonth = '03';
$yrecordhighavwindyear = '2016';
$yrecordhighbaro = '1053.0';
$yrecordhighbaroday = '04';
$yrecordhighbaromonth = '03';
$yrecordhighbaroyear = '2016';
$yrecordhighgustday = '06';
$yrecordhighgustmonth = '03';
$yrecordhighgustyear = '2016';
$yrecordhightemp = '0.4';
$yrecordhightempday = '04';
$yrecordhightempmonth = '03';
$yrecordhightempyear = '2016';
$yrecordlowchill = '-0.6';
$yrecordlowchillday = '06';
$yrecordlowchillmonth = '03';
$yrecordlowchillyear = '2016';
$yrecordlowtemp = '-0.6';
$yrecordlowtempday = '06';
$yrecordlowtempmonth = '03';
$yrecordlowtempyear = '2016';
$yrecordwindgust = '0';
$yrecordwindspeed = '0';
$daysTmaxGT35C = '0';
$daysTmaxGT30C = '0';
$daysTmaxGT25C = '0';
$daysTminLT5C = '3';
$daysTminLT0C = '3';
$daysTminLTm15C = '0';
//
// End tags needed for trends-inc.php
//
// Create array for current conditions icons for clientraw.txt. There are 35
// possible values in clientraw.txt. It would be simpler to do this with
// array() but to make it easier to modify each element is defined
// individually. Each index [#] corresponds to the value provided in
// clientraw.txt.
$icon_array[0] =  'day_clear.gif';            // imagesunny.visible
$icon_array[1] =  'night_clear.gif';          // imageclearnight.visible
$icon_array[2] =  'day_partly_cloudy.gif';    // imagecloudy.visible
$icon_array[3] =  'day_partly_cloudy.gif';    // imagecloudy2.visible
$icon_array[4] =  'night_partly_cloudy.gif';  // imagecloudynight.visible
$icon_array[5] =  'day_partly_cloudy.gif';    // imagedry.visible
$icon_array[6] =  'fog.gif';                  // imagefog.visible
$icon_array[7] =  'haze.gif';                 // imagehaze.visible
$icon_array[8] =  'day_heavy_rain.gif';       // imageheavyrain.visible
$icon_array[9] =  'day_mostly_sunny.gif';     // imagemainlyfine.visible
$icon_array[10] =  'mist.gif';                // imagemist.visible
$icon_array[11] =  'fog.gif';                 // imagenightfog.visible
$icon_array[12] =  'night_heavy_rain.gif';    // imagenightheavyrain.visible
$icon_array[13] =  'night_cloudy.gif';        // imagenightovercast.visible
$icon_array[14] =  'night_rain.gif';          // imagenightrain.visible
$icon_array[15] =  'night_light_rain.gif';    // imagenightshowers.visible
$icon_array[16] =  'night_snow.gif';          // imagenightsnow.visible
$icon_array[17] =  'night_tstorm.gif';        // imagenightthunder.visible
$icon_array[18] =  'day_cloudy.gif';          // imageovercast.visible
$icon_array[19] =  'day_partly_cloudy.gif';   // imagepartlycloudy.visible
$icon_array[20] =  'day_rain.gif';            // imagerain.visible
$icon_array[21] =  'day_rain.gif';            // imagerain2.visible
$icon_array[22] =  'day_light_rain.gif';      // imageshowers2.visible
$icon_array[23] =  'sleet.gif';               // imagesleet.visible
$icon_array[24] =  'sleet.gif';               // imagesleetshowers.visible
$icon_array[25] =  'snow.gif';                // imagesnow.visible
$icon_array[26] =  'snow.gif';                // imagesnowmelt.visible
$icon_array[27] =  'snow.gif';                // imagesnowshowers2.visible
$icon_array[28] =  'day_clear.gif.gif';       // imagesunny.visible
$icon_array[29] =  'day_tstorm.gif';          // imagethundershowers.visible
$icon_array[30] =  'day_tstorm.gif';          // imagethundershowers2.visible
$icon_array[31] =  'day_tstorm.gif';          // imagethunderstorms.visible
$icon_array[32] =  'tornado.gif';             // imagetornado.visible
$icon_array[33] =  'windy.gif';               // imagewindy.visible
$icon_array[34] =  'day_partly_cloudy.gif';   // stopped raining
$icon_array[35] =  'windyrain.gif';           // Wind+rain

$iconnumber = '0';
$current_icon = $icon_array[0]; // name of our condition icon
// ----------------------------------------------------------------------------------
//   $current_summary = 'Dry' . "<br />" . 'Mainly cloudy/Dry ';
### FIXME
$weathercond = 'Dry';
### FIXME
$Currentsolardescription = 'Not Available';

$current_summary = $Currentsolardescription;
$current_summary = preg_replace('|^/[^/]+/|','',$current_summary);
$current_summary = preg_replace('|\\\\|',", ",$current_summary);
$current_summary = preg_replace('|/|',", ",$current_summary);
//
//

$cloudheightfeet = '1749.0'; // Estimated cloud base height, feet, (based on dew point, and you height above sea  level...enter
$cloudheightmeters = '533.0';   // Estimated cloud base height, metres, (based on dew point, and you height above sea
//
// End of stock testtags.txt
//
// ----------------------------------------------------------------------------
// MChallis Printable Flyer Add-on Tags
// ----------------------------------------------------------------------------
$maxgsthrtime = '0';        // time that the max gust last prior 1 hour occurred
$minbaroyest = '1052.8';
$minbaroyestt = '03:29';
$mrecordlowbaro = '1052.8';
$mrecordlowbaroday = '06';
$mrecordlowbaromonth = '03';
$mrecordlowbaroyear = '2016';
$yrecordlowbaro = '1052.8';
$yrecordlowbaroday = '06';
$yrecordlowbaromonth = '03';
$yrecordlowbaroyear = '2016';
//
// End MChallis Printable Flyer Add-on Tags
//
// ----------------------------------------------------------------------------
// WebsterWeatherLive VER 4.10 tags
// ----------------------------------------------------------------------------
$lighteningbearing = '0';
$lighteningdistance = '0';
$lighteningcountlasthournextstorm = '0';
$lighteningcountlastminutenextstorm = '0';
$lighteningcountlast12hournextstorm = '0';
$lighteningcountlast30minutesnextstorm = '0';
$timeofdaygreeting = 'Morning';
$avwindlastimediate60 = '0'; // average wind speed
$avwindlastimediate120 = '0'; // average wind speed
$currentmonthaveragerain = 'N/A'; // average rain for current month
//
// Version 5.00+
//
$avwindlastimediate15 = '0'; // average wind speed
$avwindlastimediate30 = '0'; // average wind speed
$todayhihumidex = '-2.4'; //today's high humidex
$todaylohumidex = '-3.6'; //today's low Humidex
//
// Version 5.02
//
$dayornight = 'Night'; // Day or night flag
//
// Version 6.20
//
$tempchangelasthourfaren = '30.3'; //For snow prediction
$abshum = '80'; //For snow prediction
$maxtemp4today = '0.4'; // max from station's records
$mintemp4today = '-0.6'; // min from station's records
$maxtemp4todayyr = '2016'; // max year from station's records
$mintemp4todayyr = '2016'; // min year from station's records
//
// End of WebsterWeatherLive Tags
//
// ----------------------------------------------------------------------------
// Relayweather Temperature and Rain Trending (wxglobalwarming)
// ----------------------------------------------------------------------------
//
// Temperature Trending
//
$avtempjannow = 'N/A';
$avtempfebnow = 'N/A';
$avtempmarnow = 'N/A';
$avtempaprnow = 'N/A';
$avtempmaynow = 'N/A';
$avtempjunnow = 'N/A';
$avtempjulnow = 'N/A';
$avtempaugnow = 'N/A';
$avtempsepnow = 'N/A';
$avtempoctnow = 'N/A';
$avtempnovnow = 'N/A';
$avtempdecnow = 'N/A';
$avtempjan = 'N/A'; //Average temperature for january from your data
$avtempfeb = 'N/A'; //Average temperature for february from your data
$avtempmar = 'N/A'; //Average temperature for march from your data
$avtempapr = 'N/A'; //Average temperature for april from your data
$avtempmay = 'N/A'; //Average temperature for may from your data
$avtempjun = 'N/A'; //Average temperature for june from your data
$avtempjul = 'N/A'; //Average temperature for july from your data
$avtempaug = 'N/A'; //Average temperature for august from your data
$avtempsep = 'N/A'; //Average temperature for september from your data
$avtempoct = 'N/A'; //Average temperature for october from your data
$avtempnov = 'N/A'; //Average temperature for november from your data
$avtempdec = 'N/A'; //Average temperature for december from your data
//
// Rain Trending
//
$avrainjan = 'N/A'; //Average rainfall for january from your data
$avrainfeb = 'N/A'; //Average rainfall for february from your data
$avrainmar = 'N/A'; //Average rainfall for march from your data
$avrainapr = 'N/A'; //Average rainfall for april from your data
$avrainmay = 'N/A'; //Average rainfall for may from your data
$avrainjun = 'N/A'; //Average rainfall for june from your data
$avrainjul = 'N/A'; //Average rainfall for july from your data
$avrainaug = 'N/A'; //Average rainfall for august from your data
$avrainsep = 'N/A'; //Average rainfall for september from your data
$avrainoct = 'N/A'; //Average rainfall for october from your data
$avrainnov = 'N/A'; //Average rainfall for november from your data
$avraindec = 'N/A'; //Average rainfall for december from your data
$avrainjannow = 'N/A';
$avrainfebnow = 'N/A';
$avrainmarnow = 'N/A';
$avrainaprnow = 'N/A';
$avrainmaynow = 'N/A';
$avrainjunnow = 'N/A';
$avrainjulnow = 'N/A';
$avrainaugnow = 'N/A';
$avrainsepnow = 'N/A';
$avrainoctnow = 'N/A';
$avrainnovnow = 'N/A';
$avraindecnow = 'N/A';
// End Rain Trending
//
// End of Relayweather tags
//
// ----------------------------------------------------------------------------
// Eastmasonville Station Records (wxrecords) Tags
// ----------------------------------------------------------------------------
$recordhightemp = '0.4'; // Record high temp
$recordlowtemp = '-0.6'; // Record low temp
$recordhighheatindex = '0.4';
$recordlowchill = '-0.6';  //record low windchill
$warmestdayonrecord = 'NA  on: --'; //Warmest Day on Record
$coldestdayonrecord = 'NA  on: --'; //coldest Day on Record
$warmestnightonrecord = '-0.6&deg;C  on: 6 Mar 2016'; //Warmest Night on Record
$coldestnightonrecord = '-0.6&deg;C  on: 6 Mar 2016'; //coldest Night on Record
$recordwindgust = '0'; // All Time Record wind gust
$recordwindspeed = '0'; // All Time Record Avg Wind Speed
$recordhighwindrun = '0.0';
$recorddailyrain = '2.8'; // Record Daily Rain
$recordhighrainmth = 'N/A';
$recordrainrate = '2.0';
$recorddayswithrain = '2';
$recorddaysnorain = '1';
$recordhighdew = '-2.7';
$recordlowdew = '-3.7';
$recordhighhum = '80';
$recordlowhum = '80';
$recordhighbaro = '1053.0'; // All time record high barometer
$recordlowbaro = '1052.8'; // All time record low barometer
$recordhighsolar = '0';
$recordhightempmonth = '03'; //Record high temp month
$recordhightempday = '04'; //Record high temp day
$recordhightempyear = '2016'; //Record high temp year
$recordlowtempmonth = '03';   // Record low temp month
$recordlowtempday = '06';   // Record low temp day
$recordlowtempyear = '2016';   // Record low temp year
$recordhighheatindexmonth = '03';   // Record high heatindex month
$recordhighheatindexday = '04';   // Record high heatindex day
$recordhighheatindexyear = '2016';   // Record high heatindex year
$recordlowchillmonth = '03';   // Record low windchill month
$recordlowchillday = '06';   // Record low windchill day
$recordlowchillyear = '2016';   // Record low windchill year
$recordhighgustmonth = '03';
$recordhighgustday = '06';
$recordhighgustyear = '2016';
$recordhighavwindmonth = '03';
$recordhighavwindday = '06';
$recordhighavwindyear = '2016';
$recordhighwindrunmth = '03';
$recordhighwindrunday = '05';
$recordhighwindrunyr = '2016';
$recorddailyrainmonth = '03';   // Record daily rain month
$recorddailyrainday = '05';   // Record daily rain day
$recorddailyrainyear = '2016';   // Record daily rain year
$recordhighrainmthmth = '';
$recordhighrainmthyr = '';
$recordrainratemonth = '03';
$recordrainrateday = '05';
$recordrainrateyear = '2016';
$recorddayswithrainmonth = '03';
$recorddayswithrainday = '06';
$recorddayswithrainyear = '2016';
$recorddaysnorainmonth = '03';
$recorddaysnorainday = '04';
$recorddaysnorainyear = '2016';
$recordhighdewmonth = '03';
$recordhighdewday = '04';
$recordhighdewyear = '2016';
$recordlowdewmonth = '03';
$recordlowdewday = '06';
$recordlowdewyear = '2016';
$recordhighhummonth = '03';
$recordhighhumday = '04';
$recordhighhumyear = '2016';
$recordlowhummonth = '03';
$recordlowhumday = '06';
$recordlowhumyear = '2016';
$recordhighbaromonth = '03';   // Record high baro month
$recordhighbaroday = '04';   // Record high baro day
$recordhighbaroyear = '2016';   // Record high baro year
$recordlowbaromonth = '03';   // Record low baro month
$recordlowbaroday = '06';   // Record low baro day
$recordlowbaroyear = '2016';   // Record low baro year
$mrecordhighsolar = '0';
$mrecordhighsolarday = '04';
$mrecordhighsolarmonth = '03';
$mrecordhighsolaryear = '2016';
$yrecordhighsolar = '0';
$yrecordhighsolarday = '04';
$yrecordhighsolarmonth = '03';
$yrecordhighsolaryear = '2016';
$recordhighsolarmonth = '03';
$recordhighsolarday = '04';
$recordhighsolaryear = '2016';
$mrecordhighuv = 'N/A';
$mrecordhighuvmonth = 'N/A';
$mrecordhighuvday = 'N/A';
$mrecordhighuvyear = 'N/A';
$yrecordhighuv = 'N/A';
$yrecordhighuvmonth = 'N/A';
$yrecordhighuvday = 'N/A';
$yrecordhighuvyear = 'N/A';
$recordhighuv = 'N/A';
$recordhighuvmonth = 'N/A';
$recordhighuvday = 'N/A';
$recordhighuvyear = 'N/A';
$yrecordhighheatindex = '0.4';
$yrecordhighheatindexmonth = '03';
$yrecordhighheatindexday = '04';
$yrecordhighheatindexyear = '2016';
$ywarmestdayonrecord = 'NA  on: --'; //Warmest Day on Record
$ycoldestdayonrecord = 'NA  on: --'; //Coldest Day on Record
$ywarmestnightonrecord = '-0.6&deg;C  on: 6 Mar 2016'; //Warmest Night this month
$ycoldestnightonrecord = '-0.6&deg;C  on: 6 Mar 2016'; //Coldest Night this month
$yrecordhighwindrun = '0.0';
$yrecordhighwindrunmth = '03';
$yrecordhighwindrunday = '05';
$yrecordhighwindrunyr = '2016';
$yrecorddailyrain = '2.8';
$yrecordhighrainmth = 'N/A';
$yrecordrainrate = '2.0';
$yrecorddayswithrain = '2';
$yrecorddaysnorain = '1';
$yrecordhighdew = '-2.7';
$yrecordlowdew = '-3.7';
$yrecordhighhum = '80';
$yrecordlowhum = '80';
$yrecorddailyrainmonth = '03';
$yrecorddailyrainday = '05';
$yrecorddailyrainyear = '2016';
$yrecordhighrainmthmth = '';
$yrecordhighrainmthyr = '';
$yrecordrainratemonth = '03';
$yrecordrainrateday= '05';
$yrecordrainrateyear= '2016';
$yrecorddayswithrainmonth = '03';
$yrecorddayswithrainday = '06';
$yrecorddaysnorainmonth = '03';
$yrecorddaysnorainday = '04';
$yrecordhighdewmonth = '03';
$yrecordhighdewday = '04';
$yrecordhighdewyear = '2016';
$yrecordlowdewmonth = '03';
$yrecordlowdewday = '06';
$yrecordlowdewyear = '2016';
$yrecordhighhummonth = '03';
$yrecordhighhumday = '04';
$yrecordhighhumyear = '2016';
$yrecordlowhummonth = '03';
$yrecordlowhumday = '06';
$yrecordlowhumyear = '2016';
$mrecordhighheatindex = '0.4';
$mrecordhighheatindexmonth = '03';
$mrecordhighheatindexday = '04';
$mrecordhighheatindexyear = '2016';
$mrecordhighwindrun = '0.0';
$mrecordhighwindrunday = '05';
$mrecordhighwindrunmth = '03';
$mrecordhighwindrunyr = '2016';
$mrecorddailyrain = '2.8';
$mrecordhighrainmth = '3.8';
$mrecordrainrate = '2.0';
$mrecorddayswithrain = '2';
$mrecorddaysnorain = '1';
$mrecordhighdew = '-2.7';
$mrecordlowdew = '-3.7';
$mrecordhighhum = '80';
$mrecordlowhum = '80';
$mrecorddailyrainmonth = '03';
$mrecorddailyrainday = '05';
$mrecorddailyrainyear = '2016';
$mrecordhighrainmthmth = '03';
$mrecordhighrainmthyr = '2016';
$mrecordrainratemonth = '03';
$mrecordrainrateday= '05';
$mrecordrainrateyear = '2016';
$mrecorddayswithrainmonth = '03';
$mrecorddayswithrainday = '06';
$mrecorddaysnorainmonth = '03';
$mrecorddaysnorainday = '04';
$mrecordhighdewmonth = '03';
$mrecordhighdewday = '04';
$mrecordhighdewyear = '2016';
$mrecordlowdewmonth = '03';
$mrecordlowdewday = '06';
$mrecordlowdewyear = '2016';
$mrecordhighhummonth = '03';
$mrecordhighhumday = '04';
$mrecordhighhumyear = '2016';
$mrecordlowhummonth = '03';
$mrecordlowhumday = '06';
$mrecordlowhumyear = '2016';
//
// Eastmasonville Station Records (wxrecords) Tags
//
// ----------------------------------------------------------------------------
// Other Addons
// ----------------------------------------------------------------------------
$vpissstatus = 'N/A'; // N/A string
$vpreception2 = 'N/A'; // VP Current reception %  *** NEW IN V1.01
$vpconsolebattery = 'N/A'; // VP Console Battery Volts *** NEW IN V1.01
$firewi = 'N/A'; // Fire Weather Index
$avtempweek = '0.0';    // Average temperature over past 7 days
$hddday = '18.3';        // Heating Degree for day
$hddmonth = '54.9';    // Heating Degree for month to date
$hddyear = '54.9';    // Heating Degree for year to date
$cddday = '0.0';        // Cooling Degree for day
$cddmonth = '0.0';    // Cooling Degree for month to date
$cddyear = '0.0';    // Cooling Degree for year to date
$minchillweek = '-0.6';  // Minimum Wind Chill over past 7 days
$maxheatweek = '0.4';  // Maximum Heat Index over past 7 days *** NEW IN V2.00
$airdensity = '1.344';  //air density
$solarnoon = 'N/A'; // Solar noon
$changeinday = 'N/A';  // change in day length since yesterday
$etcurrentweek = '179.4'; // ET total for the last 7 days
$sunshinehourstodateday = '0';
$sunshinehourstodatemonth = '0';
$maxsolarfortime = '0';
$wetbulb = '-1.6';
$lighteningcountlasthour = '0';
$lighteningcountlastminute = '0';
$lighteningcountlast5minutes = '0';
$lighteningcountlast12hour = '0';
$lighteningcountlast30minutes = '0';
$lighteningcountlasttime = '0';
$lighteningcountmonth = '0';
$lighteningcountyear = '0';
$chandler = '-0.8';
$maxdew = '-2.7&deg;C';
$maxdewt = '02:30';
$mindew = '-3.7&deg;C';
$mindewt = '04:11';
$maxdewyest = '-2.7&deg;C';
$maxdewyestt = '00:00';
$mindewyest = '-3.6&deg;C';
$mindewyestt = '03:29';
$stationname = 'Tony's dev PWS, Sarov';
$raindifffromav = 'N/A';
$raindifffromavyear = '0';
$gddmonth = '0.0';
$gddyear = '0.0';
$maxheat = '0.4&deg;C';
$maxheatt = '02:30';
$maxheatyest = '0.4&deg;C';
$yeartodateavtemp = '0.0';
$monthtodateavtemp = '0.0';
$maxchillyest = '0.4&deg;C';
$monthtodatemaxgust = '0';
$monthtodateavspeed = '0'; // MTD average wind speed
$monthtodateavgust = '0'; //MTD average wind gust
$yeartodateavwind = '0'; // YTD average wind speed
$yeartodategstwind = '0'; // YTD avg wind gust
$lowbaro = '1052.8';
$lowbarot = '04:11';
$monthtodatemaxbaro = '1053.0'; // MTD high barometer
$monthtodateminbaro = '1052.8'; //MTD low barometer
$sunshinehourstodateyear = '0';
$sunshineyesterday = '0';
$avtempsincemidnight = '-0.0';
$yesterdayavtemp = '0.0';
$avgspeedsincereset = '-0.0';
$maxheatyestt = '00:00';
$windrunyesterday = '0.2';
$currentwdet = '0';
$yesterdaywdet = '0';
$highhum = '80';
$highhumt = '02:30';
$lowhum = '80';
$lowhumt = '04:11';
$maxhumyest = '80';
$maxhumyestt = '00:00';
$minhumyest = '80';
$minhumyestt = '03:29';
$recordhightempjan = 'N/A';
$recordlowtempjan = 'N/A';
$recordhightempfeb = 'N/A';
$recordlowtempfeb = 'N/A';
$recordhightempmar = '0.4';
$recordlowtempmar = '-0.6';
$recordhightempapr = 'N/A';
$recordlowtempapr = 'N/A';
$recordhightempmay = 'N/A';
$recordlowtempmay = 'N/A';
$recordhightempjun = 'N/A';
$recordlowtempjun = 'N/A';
$recordhightempjul = 'N/A';
$recordlowtempjul = 'N/A';
$recordhightempaug = 'N/A';
$recordlowtempaug = 'N/A';
$recordhightempsep = 'N/A';
$recordlowtempsep = 'N/A';
$recordhightempoct = 'N/A';
$recordlowtempoct = 'N/A';
$recordhightempnov = 'N/A';
$recordlowtempnov = 'N/A';
$recordhightempdec = 'N/A';
$recordlowtempdec = 'N/A';
// ----------------------------------------------------------------------------------------------------
// end of testtags.txt/testtags.php
//
?>
