theCalendar
===========

A PHP calendar visual preperation class. 


Example of use:
<pre><code>
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
</code></pre>