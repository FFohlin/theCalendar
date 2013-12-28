<?php 

require_once('thecalendarclass.php');

$times = array(
    		0=>(Object)array('start' => '2011-10-10 01:00', 'length' => '60', 'title' => 'Fohlin', 'text' => '', 'color'=>'#78ae94'),
    		1=>(Object)array('start' => '2011-10-10 01:20', 'length' => '60', 'title' => 'Svensson', 'text' => '', 'color'=>'#ae9c78'),
    		2=>(Object)array('start' => '2011-10-10 01:25', 'length' => '90', 'title' => 'Persson', 'text' => '', 'color'=>'#cccc66'),
    		3=>(Object)array('start' => '2011-10-10 02:35', 'length' => '90', 'title' => 'Olsson', 'text' => '', 'color'=>'#bbb'),
    		4=>(Object)array('start' => '2011-10-10 04:45', 'length' => '60', 'title' => 'Berra', 'text' => '', 'color'=>'#c787ae'),
    		5=>(Object)array('start' => '2011-10-10 08:00', 'length' => '45', 'title' => 'Fohlin', 'text' => '', 'color'=>'#78ae94'),
    		6=>(Object)array('start' => '2011-10-10 08:30', 'length' => '60', 'title' => 'jönsson', 'text' => '', 'color'=>'#87a7c7'),
    		7=>(Object)array('start' => '2011-10-11 02:00', 'length' => '60', 'title' => 'Berra', 'text' => '', 'color'=>'#c787ae'),
    		8=>(Object)array('start' => '2011-10-11 02:30', 'length' => '60', 'title' => 'Berra', 'text' => '', 'color'=>'#c787ae'),
    		9=>(Object)array('start' => '2011-10-11 02:30', 'length' => '60', 'title' => 'Svensson', 'text' => '', 'color'=>'#ae9c78'),
    		10=>(Object)array('start' => '2011-10-11 04:00', 'length' => '60', 'title' => 'Olsson', 'text' => '', 'color'=>'#bbb'),
			11=>(Object)array('start' => '2011-10-11 04:30', 'length' => '60', 'title' => 'Persson', 'text' => '', 'color'=>'#cccc66'),
			12=>(Object)array('start' => '2011-10-11 05:00', 'length' => '45', 'title' => 'Svensson', 'text' => '', 'color'=>'#ae9c78'),
			15=>(Object)array('start' => '2011-10-11 13:15', 'length' => '45', 'title' => 'Svensson', 'text' => '', 'color'=>'#ae9c78'),
			13=>(Object)array('start' => '2011-10-12 02:00', 'length' => '120', 'title' => 'Fohlin', 'text' => '', 'color'=>'#78ae94'),
			14=>(Object)array('start' => '2011-10-12 04:15', 'length' => '60', 'title' => 'jönsson', 'text' => '', 'color'=>'#87a7c7')		
);
	
# (tiderna, höjd på en kvart i px)	
$object = new TheCalendar($times, 25);	

# Om arrayns starttid och längd på eventet heter nåt annat än
# "start" och "length" så sätts det här. Sätt bara de som inte heter 
# som de ska. "limitstart" och "limitend" kan bara vara hela timmar, 
# ex 3 eller 19 (från och med, till och med-tider). Det enda som görs
# med limiten är att ta bort timmar ur $object->hours. Om man har tider
# som borde ligga på en borttagen timma (eller rättare sagt använder
# poisionsdata från en timma) så hamnar den alltså på 0.
$object->config(array(
	'start' => 'start', 
	'length' => 'length', 
	'compressed' => true, 
	'limitstart' => 0, 
	'limitend' => 21
));

# skapa tider...
$object->generateDays();
$days = $object->days;
?>

<!doctype html>

<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->

<head>
	<meta charset="utf-8">
	
	<title>Schemademo</title>
	
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="edge" />
	
	<!-- http://t.co/dKP3o1e -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- For all browsers -->
	<? /*
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/mygrid.css">
	
	<link rel="stylesheet" href="fonts/style.css">
	*/ ?>
	<link rel="stylesheet" href="css/sitestyling.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700' rel='stylesheet' type='text/css'>
	
	<style type="text/css">
		a:hover {opacity: 0.7;}
		#schedule {position: relative;}
		.schedule-column {
			float: left;
			padding: 0 4px;
		}
		.day-inner {
			background-color: #ebebed;
		}
		
		.timelabel-column {
			width: 50px;
			text-align: right;
		}
		.timelabel-inner {
			position: relative;
			
		}
		.timelabel {
			position: absolute;
			width: 100%;
			left: 0;
		}
		.timelabel span {display: block; margin-top: -6px; font-size: 12px;}
		.schedule-day {
			width: 25%;
		}
		.column-header {display: block; margin-bottom: 10px;}
		.hours {position: absolute; top: 0; left: 0; width: 100%; height: 100%;}
		.hour {position: absolute; top: 0; left: 0; width: 100%; height: 60px; border-top: 1px solid #ddd;}
		
		.calendaritem {
			display: block;
			position: absolute;
			border-radius: 3px;
		}
		
		.calendarcontent {
			padding: 10px;
			overflow: visible;
		}
		
		.calendarcontent h4 {
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		a.calendaritem.cl-1-1 {width: 100%;}
		a.calendaritem.cl-1-2 {width: 49.5%;}
		a.calendaritem.cl-2-2 {width: 49.5%; left: 50.5%;}
		a.calendaritem.cl-1-3 {width: 32.667%;}
		a.calendaritem.cl-2-3 {width: 32.667%; left: 33.667%;}
		a.calendaritem.cl-3-3 {width: 32.667%; left: 67.334%;}
		a.calendaritem.cl-1-4 {width: 24%;}
		a.calendaritem.cl-2-4 {width: 24%; left: 25%;}
		a.calendaritem.cl-3-4 {width: 24%; left: 51%;}
		a.calendaritem.cl-4-4 {width: 24%; left: 76%;}
		a.calendaritem.cl-1-5 {width: 20%;}
		a.calendaritem.cl-2-5 {width: 20%; left: 20%;}
		a.calendaritem.cl-3-5 {width: 20%; left: 40%;}
		a.calendaritem.cl-4-5 {width: 20%; left: 60%;}
		a.calendaritem.cl-5-5 {width: 20%; left: 80%;}
		
		
	</style>
	
	<!--[if (lt IE 9) & (!IEMobile)]>
	<script src="js/respond.js"></script>
	<script src="js/selectivizr-1.0.2-min.js"></script>
	<![endif]-->
	
	<!-- JavaScript -->
	<script src="js/modernizr-2.5.3-min.js"></script>
	
	<!--<link rel="shortcut icon" href="/favicon.ico">-->
</head>


<?php
	# Här går jag igenom timmarna (som inte innehåller annat än just information om timmar, och hur de ska se ut
	# Det här används sedan för att få schemat att se rätt ut med tider där man vill ha dem, och rätt höjd på spalter mm
	$totalhoursheight = 0;
	$hourcolumncontent = '';
	$hoursinsidecolumns = '';
	
	foreach($object->hours as $key => $h) {
		$hourcolumncontent .= '<div class="timelabel" style="height:' .$h->length. 'px; top: ' .$h->pos. 'px">';
		$hourcolumncontent .= '<span class="text-color-light">' .$key. '.00</span>';
		$hourcolumncontent .= '</div>';
		# hoursinsidecolumns används för att sätta dekor bakom tiderna (streck och sånt)
		$hoursinsidecolumns .= '<div class="hour color' .$colorclass. '" style="height:' .$h->length. 'px; top: ' .$h->pos. 'px"></div>';
		# totalhoursheight använder jag för att sätta höjden på kolumner och tidsspalten.
		$totalhoursheight = $totalhoursheight+$h->length;
	}
?>


<body>
	
<div id="schedule">
	
	<?php //echo '<pre style="position: absolute; z-index: 10;">'; print_r($object->days); echo '</pre>'; ?>
	<?php //echo '<pre style="position: absolute; left: 400px; z-index: 10;">'; print_r($object->hours); echo '</pre>'; ?>
	
	<div class="timelabel-column schedule-column">
		<span class="column-header text-bold text-size-large">&nbsp;</span>
		<div class="timelabel-inner" style="height: <?php echo $totalhoursheight ?>px;">
			<?php echo $hourcolumncontent; ?>
		</div>
	</div>
	
	<?php foreach($days as $day) { ?>
	
	<div class="schedule-day schedule-column">
		<span class="column-header">
			<span class="text-bold text-size-large"><?php echo $day->data->dayNumber ?></span> 
			<span class="text-color-light text-size-small"><?php echo $day->data->shortName ?></span>
		</span>
		<div class="day-inner schedule-day-inner" style="position: relative; height: <?php echo $totalhoursheight ?>px;">
			<div class="hours">
				<?php echo $hoursinsidecolumns ?>
			</div>
		
			<?php
			foreach($day->times as $t) {
				if($object->hours[$t->hour]) {
					echo '<a class="calendaritem ' .$t->styleclass. '" href="" style="top: ' .($object->hours[$t->hour]->pos+$t->minutepos). 'px; background-color: ' .$t->color. '; height: ' .$t->pixellength. 'px;">';
						echo '<div class="calendarcontent">';	
							echo '<h4 style="margin: 0;">' .$t->title. '</h4>';
							if($t->text) echo '<p>' .$t->text. '</p>';
							echo '<p class="text-size-small">' .date('H:i', strtotime($t->start)). ' - ' .date('H:i', strtotime($t->start.'+'.($t->length).' minutes')). '</p>';
						echo '</div>';
					echo '</a>';
				}
			}
			?>
		</div>
	</div>
	
	<?php } ?>
	
</div>	
	
	

	
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
	
	<? 
	
	//	<script src="js/niceScheme-0.1.js"></script> 
	
	# Framtid med javascript:
	# I backbone vill jag sedan ha olika vyer för vecka (period), dag, tid. Så att 
	# en dag kan uppdateras, och en tid kan uppdateras. Utan att uppdatera hela skiten.
	# Det skulle kunna innebära att jag behöver en kollektion med dagar. Eller?
	
	?>
	
	<script>
		$( document ).ready(function() {
			//$('#schedule').writeSchedule();
			
			/*
			var highest = 0;
			$.each($('.schedule-day-inner'), function(  ) {
				console.log(this);
				var heightNeeded = $(this).find('.calendaritem').last().position().top+$(this).find('.calendaritem').last().outerHeight();
				if(heightNeeded > highest) {
					highest = heightNeeded;
					$('.schedule-day-inner').css('height', heightNeeded+20);
				}
  			});
  			*/
  			
  			//$('.day-inner').css('height', $('.hours').outerHeight());
					
			//$( window ).resize(function() {

			});
		});
	</script>
	
</body>
</html>