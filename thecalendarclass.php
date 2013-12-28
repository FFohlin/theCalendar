<?php

class TheCalendar {
	
	protected $times;
	public $hours;
	public $days = array(); # Här lägger jag alla tider omvandlade till dagar med mer info
	public $quarterheight; # px höjd på varje kvart
	protected $conf = array(
		'start' => 'start',
		'length' => 'length',
		'compressed' => false,
		'limitstart' => false,
		'limitend' => false
	);
	
	public function __construct( $times, $quarterheight = 25 )
    {
        // bool date_default_timezone_set ( string $timezone_identifier )
        date_default_timezone_set('Europe/Stockholm');
        
        $this->times = $times;
        $this->quarterheight = $quarterheight;
    }
    
    function generateDays() {
	    $date = date('Y-m-d', strtotime($this->times[0]->{$this->conf['start']}));
		$dayno = 0;
		
		foreach($this->times as $key => $t) {
       	  	if($date != date('Y-m-d', strtotime($t->{$this->conf['start']}))) {
       	  		$dayno++;
       	  		$date = date('Y-m-d', strtotime($t->{$this->conf['start']}));
       	  	}
       	  	$t->dayno = $dayno;
       	  	$t->pixeltop = $this->getStartTimePixels($t->{$this->conf['start']}); // används inte längre i schemat, men fortfarande i uträkningar.
       	  	$t->hour = date('H', strtotime($t->{$this->conf['start']})); //str_pad($starthour+$i, 2, '0', STR_PAD_LEFT);
       	  	$t->minutepos = $this->getMinutePosition($t->{$this->conf['start']});
	       	$t->pixellength = $this->getLengthPixels($t->{$this->conf['length']});
	       	$t->pixelend = $t->pixeltop+$t->pixellength;
	       	$t->colplace = 1;
	       	$t->colwidth = 1;
	       	$t->styleclass = 'cl-1-1';
	       	
	       	if($key > 0) {
	       		# kolla hur många tidigare som slutar EFTER den här STARTAR, och skapa en array.
	       		# jag kollar alltså inte tider "EFTER" den här, bara före… (smashes = krockar)
	       		$t->smashes = array();
	       		
	       		for ($i=0; $i < $key; $i++) {
	       			# Om tiden som jämförs med inte är idag, så hoppa över den.
	       			if($this->times[$i]->dayno != $dayno) continue;
	       			# vi skickar med kolumnplaceringen, för att kunna sätta nästa tid i en ledig kolumn
	       			if($this->times[$i]->pixelend > ($t->pixeltop+1)) {
	       				$t->smashes[$i] = $this->times[$i]->colplace; 
		   				# after-värdet används nog inte just nu...
		   				$this->times[$i]->smashes['after']++;
	       			}
	       		}
				
				# bara för att skriva ut i testen...
				$t->krockar = count($t->smashes);
				
				# tre parallella borde skapa värdet 3 (två krockar plus den här)
				$t->colwidth = count($t->smashes)+1; 
				
				# hitta den lediga kolumnen för den här tiden
				if(count($t->smashes)) {
		   			$t = $this->findFreeColumn($t);
		   		}
		   	}
	       	$this->days[$dayno]->times[] = $t;
	       	
	       	# så att man kan bestämma om oanvända timmar ska visas stora eller små...
	       	# Vi lägger till tiden till ett kanske redan befintlig object.
	       	$this->days[$dayno]->usedhours = $this->getThisTimesUsedHours($this->days[$dayno]->usedhours, $t->{$this->conf['start']}, $t->{$this->conf['length']});
	       	
	    }
		
		foreach($this->days as $day) {
			# Övrig data om dagen
			$day->data = $this->getDayFact($day->times[0]);
			# kombinera dagens använda tider med andra dagars använda...
			$this->addUsedDayTimesToTotalUsedTimes($day->usedhours);
		}
		
		$this->setHourStartTopPosition();
    }
	
	# ==================================== #
	# Ger tillbaka startpositionen i pixlar.
	# Här måste jag också räkna med om timmar är kollapsade eller inte - GÖRS INTE ÄNNU
	
	function getStartTimePixels($datetime) 
	{
		return round($this->quarterheight*($this->hoursToMinutes(date('H:i', strtotime($datetime)))/15));
	}
	
	function getMinutePosition($datetime)
	{
		$kvartar = date('i', strtotime($datetime))/15;
		return round($this->quarterheight*$kvartar);
	}
	
	# ==================================== #
	# Funktionen ger tillbaka totallängden på objektet i pixlar.
	# Invärdena är längden i minuter, och hur många pixlar långt en 
	# kvart är. 
	
	function getLengthPixels($length)
	{
		return $this->quarterheight*($length/15);
	}
	
	# ==================================== #
	# Räknar om timmar till minuter
	
	function hoursToMinutes($hours) 
	{ 
		$minutes = 0; 
	    if (strpos($hours, ':') !== false) 
	    { 	// Split hours and minutes. 
	        list($hours, $minutes) = explode(':', $hours); 
	    } 
	    return $hours * 60 + $minutes; 
	}
	
	# ==================================== #
	# Den här funktionen används i första hand till att hitta en ledig kolumn för tiden
	# att placeras i. Jag vandrar igenom kolumnerna från 1, tills jag hittar en ledig, och
	# placerar tiden i den. Just nu är max antal kolumer 6.
	
	function findFreeColumn($t) {
		if(count($t->smashes)) {
   			for($i=1; $i <= 6; $i++) { 
   				if (!in_array($i, $t->smashes)) {
					$t->colplace = $i; break;
				}
   			}
   			
   			# sätt samma bredd på de krockande tiderna (de har ju inte fått det med automatik)
   			# men observera att vi inte sätter en bredare bredd än tiden har sedan tidigare.
   			foreach($t->smashes as $key => $smash) {
   				if($this->times[$key]->colwidth < $t->colwidth) {
   					$this->times[$key]->colwidth = $t->colwidth;
   				}
   				# sätter css-klassen på de tidigare krockarna
   				$this->times[$key]->styleclass = 'cl-' .$this->times[$key]->colplace. '-' .$this->times[$key]->colwidth;
   			}
   			
   			# Här skulle vi kunna kolla om kolumnen före är bredare än den här, men
   			# det kan förändras, så tills vidare… 
   			$t->styleclass = 'cl-' .$t->colplace. '-' .$t->colwidth;
   		}
   		
   		return $t;
	}
	
	# ==================================== #
	# Den här funktionen sätter in använda timmar på motsvarande key i den array som skickas med (usedhours).
	# För att få med timmar mellan start och sluttid så kollar jag om sluttiden är i en annan timma än starttiden
	# och är det så så vandrar jag igenom timmarna från start till slut och markerar dem som använda i array.
	
	function getThisTimesUsedHours($usedhours, $start, $length) {
		$starthour = date('H', strtotime($start));
		$endhour = date('H', strtotime($start.'+'.($length-1).' minutes'));
		$diff = $endhour-$starthour;
		if($diff >= 1) {
			//echo $endhour.' - '.$starthour.' = '.$diff;
			$usedhours[$starthour] = true;
			for($i=1; $i <= $diff; $i++) {
				$usedhours[($starthour+$i < 10 ? str_pad($starthour+$i, 2, '0', STR_PAD_LEFT) : $starthour+$i)] = true;
			}
		} else {
			$usedhours[$starthour] = true;
		}
		return $usedhours;
	}
	
	# ====================================== #
	
	function getDayFact($firsttime) {
		$dayfact = (Object)array(
			'name' => date('l', strtotime($firsttime->{$this->conf['start']})),
			'shortName' => date('D', strtotime($firsttime->{$this->conf['start']})),
			'dayNumber' => date('d', strtotime($firsttime->{$this->conf['start']}))
		);
		return $dayfact;
	}
	
	# =====================================#
	# lägger till dagens tider till den totala för alla hämtade dagar.
	# Då kan vi använda den informationen till att bestämma om tiderna ska visas
	# i full längd eller inte (vi kan dra ihop tider som inte innehåller någon information)
	
	function addUsedDayTimesToTotalUsedTimes($dayUsedHours) {
		foreach($dayUsedHours as $key => $hour) {
			$this->hours[$key] = true;
		}
	}
	
	# Sätter start och längd för timmar (sammanslaget över alla hämtade dagar)
	# Timmarna används som grund för att placera tiderna (vi kunde placerat tiderna
	# mot toppen på spalten istället, men då skulle det inte går att komprimera tider
	# som inte används - lika enkelt åtminstone.
	# Om tiden som visas är begränsad i schemat, så görs det även här, genom att
	# vi tar bort de timmar som inte ska visas ur arrayn.
	function setHourStartTopPosition() {
		$pos = 0;
		
		if($this->conf['limitend']) $starthour = $this->conf['limitstart'];
			else $starthour = 0;
			
		if($this->conf['limitend']) $endhour = $this->conf['limitend'];
			else $endhour = 24;
		
		for($i=0; $i<24; $i++) {
			$key = str_pad($i, 2, '0', STR_PAD_LEFT);
			if($i < $starthour || $i > $endhour) {
				if(isset($this->hours[$key])) {
					unset($this->hours[$key]);
				}
			# om vi inte komprimerar schemat så körs alla timmar i full höjd
			} else if(isset($this->hours[$key]) || $this->conf['compressed'] == false) {
				$this->hours[$key] = (object) array('pos' => $pos, 'length' => $this->quarterheight*4);
				$pos = $pos+$this->quarterheight*4;
			} else {
				$this->hours[$key] = (object) array('pos' => $pos, 'length' => $this->quarterheight);;
				$pos = $pos+$this->quarterheight;
			}
		}
	}
	
	# ==================================== #
	# Sätt config.
	
	function config($array) {
		foreach($array as $key => $c) {
			$this->conf[$key] = $c;
		}
	}

}