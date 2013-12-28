theCalendar
===========

A PHP calendar visual preperation class. 


Example of use:
```html
$times = array(
    		0=>(Object)array('start' => '2011-10-10 01:00', 'length' => '60', 'title' => 'Fohlin', 'text' => '', 'color'=>'#78ae94'),
    		1=>(Object)array('start' => '2011-10-10 01:20', 'length' => '60', 'title' => 'Svensson', 'text' => '', 'color'=>'#ae9c78'),
    		2=>(Object)array('start' => '2011-10-10 01:25', 'length' => '90', 'title' => 'Persson', 'text' => '', 'color'=>'#cccc66'),
    		3=>(Object)array('start' => '2011-10-10 02:35', 'length' => '90', 'title' => 'Olsson', 'text' => '', 'color'=>'#bbb'),
    		4=>(Object)array('start' => '2011-10-10 04:45', 'length' => '60', 'title' => 'Berra', 'text' => '', 'color'=>'#c787ae'),
    		5=>(Object)array('start' => '2011-10-10 08:00', 'length' => '45', 'title' => 'Fohlin', 'text' => '', 'color'=>'#78ae94')	
);
	
# (timearray, height of 15 minutes in px)	
$object = new TheCalendar($times, 25);	
```
It is possible to use a times array with different member variable names, as long as you have the start time and the length. Just send in the names in the config shown below. If you dont want to change anything, do not add it to config.

```html
$object->config(array(
	'start' => 'your_starttime_name', 
	'length' => 'your_length_name', 
	'compressed' => true, 
	'limitstart' => 0, // (removes hours earlier than...)
	'limitend' => 21 // (removes hours later than...)
));
```
Lets generate the days.

```html
$object->generateDays();
$days = $object->days;
```
To use this class you need to understand that the times in the visual calendar is positioned by absolute positioning. And to make the calendar as flexible as I wanted it, I use a hour-array that contains the hour position, instead of putting the total position information in each time. Look thru the example, and you will understand. Each time is positioned with hour position plus time position.

```html
$object->hours
```