<?php 
session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	$id_squadra_logged="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
}
include("menu.php");

?>

<script>
$(document).ready(function(){
    $( "#tabs" ).tabs(

        {
            collapsible: true
        }
    );
});
</script>
<h2>Albo D'oro</h2>

<div class="albodoro" id="tabs">
	<ul>
		<li><a href="#tabs-1">Campionato</a></li>
		<li><a href="#tabs-2">Coppa delle Coppe</a></li>
		<li><a href="#tabs-3">Coppa Italia</a></li>
		<li><a href="#tabs-4">Supercoppa</a></li>
		<li><a href="#tabs-5">Fustometro</a></li>
		<!-- <li><a href="#tabs-6">Sanzioni</a></li> -->
	</ul>
	<div id="tabs-1">
		<h3>Campionato Susy league</h3>
		<div  class="content">
			<div class="anno">2019/2020</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione"> Finale Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">Rodrigo Becao</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">CrossaPù</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
					</div>
				</div>	
				<div class="competizione">
					<div class="descrizione">Aggregate - Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">Rodrigo Becao</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2° </div>
							<div class="squadra">SC Valle S.Andrea</div>
							<div class="allenatore">(Andrea Rotondo)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Bono Coppi</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Aggregate - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="far fa-futbol"></i></div>
							<div class="titolo">1° </div>
							<div class="squadra">Rodrigo Becao</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Bono Coppi</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Apertura - Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">Rodrigo Becao</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2° </div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Bar Fabio 1936</div>
							<div class="allenatore">(Daniele Rotondo)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Apertura - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="far fa-futbol"></i></div>
							<div class="titolo">1° </div>
							<div class="squadra">Rodrigo Becao</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Bono Coppi</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Chiusura - Campionato*</div>
					<div class="vincitori">
						
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">CrossaPù</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Bono Coppi</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">SC Valle S.Andrea</div>
							<div class="allenatore">(Andrea Rotondo)</div>
						</div>
						<div>
							<span class="note"style="font-size:10px;">*Definita in base alla classifica avulsa</span>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Chiusura - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="far fa-futbol"></i></div>
							<div class="titolo">1° </div>
							<div class="squadra">I NANI</div>
							<div class="allenatore">(Giuseppe Aurilio)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Bono Coppi</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
					</div>
				</div>		
			</div>
			<div class="anno">2018/2019</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Organizzazione Zero</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">I NANI</div>
							<div class="allenatore">(Giuseppe Aurilio)</div>
						</div>
					</div>
				</div>	

				<div class="competizione">
					<div class="descrizione">Aggregate - Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">I NANI</div>
							<div class="allenatore">(Peppino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2° </div>
							<div class="squadra">Salsino Forever</div>
							<div class="allenatore">(Filippo Pagliarella)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Nuova  Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Aggregate - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="far fa-futbol"></i></div>
							<div class="titolo">1° </div>
							<div class="squadra">Organizzazione Zero</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">I NANI</div>
							<div class="allenatore">(Peppino)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Apertura - Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">I NANI</div>
							<div class="allenatore">(Peppino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2° </div>
							<div class="squadra">Atletico ero na volta</div>
							<div class="allenatore">(Antonio & Michela)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Prosut!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Apertura - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="far fa-futbol"></i></div>
							<div class="titolo">1° </div>
							<div class="squadra">I NANI</div>
							<div class="allenatore">(Peppino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Salsino Forever</div>
							<div class="allenatore">(Filippo)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Chiusura - Campionato</div>
					<div class="vincitori">
						
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">Organizzazione Zero</div>
							<div class="allenatore">(Figurino)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Salsino Forever</div>
							<div class="allenatore">(Filippo Pagliarella)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Chiusura - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="far fa-futbol"></i></div>
							<div class="titolo">1° </div>
							<div class="squadra">Salsino Forever</div>
							<div class="allenatore">(Filippo Pagliarella)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Azienda PAAM</div>
							<div class="allenatore">(Andrea Cuggino)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2017/2018</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">AS Valle S. Andrea</div>
							<div class="allenatore">(Andrea Rotondo)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">PROSUT!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
					</div>
				</div>	

				<div class="competizione">
					<div class="descrizione">Aggregate - Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">Nuova  Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2° </div>
							<div class="squadra">Prosut!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Ronie Merda</div>
							<div class="allenatore">(Carletto Sciandrone)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Aggregate - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="far fa-futbol"></i></div>
							<div class="titolo">1° </div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Prosut!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Apertura - Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2° </div>
							<div class="squadra">Prosut!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">AS Fidanken</div>
							<div class="allenatore">(Filippo Pagliarella)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Apertura - Cannonieri</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2° </div>
							<div class="squadra">Prosut!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Chiusura - Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">1°</div>
							<div class="squadra">Ronie Merda</div>
							<div class="allenatore">(Carletto Sciandrone)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">AS Valle S Andrea</div>
							<div class="allenatore">(Andrea rotondo)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Bar Limpido</div>
							<div class="allenatore">(Daniele Rotondo)</div>
						</div>
					</div>
				</div>
				<div class="competizione">
					<div class="descrizione">Chiusura - Cannonieri</div>
					<div class="vincitori">
						<div class="secondo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">AS Valle S Andrea</div>
							<div class="allenatore">(Andrea rotondo)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-award"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Bar Limpido</div>
							<div class="allenatore">(Daniele Rotondo)</div>
						</div>
					</div>
				</div>			
			</div>
			<div class="anno">2016/2017</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">DEJAVU</div>
							<div class="allenatore">(Filippo Pagliarella)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Botafiga</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Nuova Romanina</div>
							<div class="allenatore">(Arky)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2015/2016</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">AS Soreta</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">MILANDruccolo</div>
							<div class="allenatore">(Vezio Malandruccolo)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">Azienda Paam</div>
							<div class="allenatore">(Giorgio Cuggino)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2014/2015</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">FICA Junior</div>
							<div class="allenatore">(Giorgio Gasbarrini)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">X-Team</div>
							<div class="allenatore">(Marco Mauti)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">PROSUT!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2013/2014</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">PROSUT!</div>
							<div class="allenatore">(Gianluca Pupparo)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">X-Team</div>
							<div class="allenatore">(Marco Mauti)</div>
						</div>
						<div class="terzo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">3°</div>
							<div class="squadra">MILANDruccolo</div>
							<div class="allenatore">(Vezio Malandruccolo)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2012/2013</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">MILANDruccolo</div>
							<div class="allenatore">(Vezio Malandruccolo)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">BAR da Ancesco</div>
							<div class="allenatore">(Daniele Rotondo)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2011/2012</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">Real WC Mbrenator</div>
							<div class="allenatore">(Filippo Pagliarella)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Arcky C&C</div>
							<div class="allenatore">(Arcangelo Perciballi)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2010/2011</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">BAR Garibaldi</div>
							<div class="allenatore">(Daniele Rotondo)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">FC Daje De Tacco</div>
							<div class="allenatore">(Giuseppe Aurilio)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2009/2010</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">A.S.3:32</div>
							<div class="allenatore">(Giuseppe Aurilio)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Centro Tim</div>
							<div class="allenatore">(Andrea Rotondo)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2008/2009</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">T.K.M.</div>
							<div class="allenatore">(Nicola Fazi)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">La Capolista</div>
							<div class="allenatore">(Flavio & Marco)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2007/2008</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<span class="note">Questi dati sono nella memoria di chi li ha vissuti</span>
					</div>
				</div>				
			</div>
			<div class="anno">2006/2007</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">Bar Fabio dal 1396</div>
							<div class="allenatore">(Daniele Rotondo)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">Atletico Collasso</div>
							<div class="allenatore">(Giuseppe Aurilio)</div>
						</div>
					</div>
				</div>				
			</div>
			<div class="anno">2005/2006</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato </div>
					<div class="vincitori">
						<span class="note">Questi dati sono persi come lacrime nella pioggia</span>
						<span class="note">(*ultima stagione gir. Unico)</span>
					</div>
				</div>				
			</div>
			<div class="anno">2004/2005</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato</div>
					<div class="vincitori">
						<span class="note">Questi dati sono persi nella memoria del tempo</span>
					</div>
				</div>				
			</div>
			<div class="anno">2003/2004</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div class="titolo">1°</div>
							<div class="squadra">S.C.A.P.P.E.T.</div>
							<div class="allenatore">(Giuseppe Aurilio)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">As 433</div>
							<div class="allenatore">(Fernando Fiorini)</div>
						</div>
					</div>
				</div>
			</div>

			<div class="anno">2002/2003</div>
			<div class="campionato">
				<div class="competizione">
					<div class="descrizione">Campionato</div>
					<div class="vincitori">
						<div class="primo">
							<div><i class="fas fa-shield-alt"></i> </div>
							<div 0class="titolo">1°</div>
							<div class="squadra">Real Baucao</div>
							<div class="allenatore">(Carlo Perciballi)</div>
						</div>
						<div class="secondo">
							<div><i class="fas fa-medal"></i></div>
							<div class="titolo">2°</div>
							<div class="squadra">As 433</div>
							<div class="allenatore">(Fernando Fiorini)</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<div id="tabs-2">
		<h3>Coppa delle Coppe <span class="note"> (*prima edizione 2012)</span></h3>
		<div class="content">
			<div class="anno">2020</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">Bar Fabio dal 1936</div>
						<div class="allenatore">(Daniele Rotondo)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">I NANI</div>
						<div class="allenatore">(Peppino)</div>
					</div>
				</div>
			</div>
			<div class="anno">2019</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">Nuova ROmanina</div>
						<div class="allenatore">(Arky)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">I NANI</div>
						<div class="allenatore">(Peppino)</div>
					</div>
				</div>
			</div>
			<div class="anno">2018</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">PROSUT!</div>
						<div class="allenatore">(Gianluca Pupparo)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">I NANI</div>
						<div class="allenatore">(Peppino)</div>
					</div>
				</div>
			</div>	
			<div class="anno">2017</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">OLIVA</div>
						<div class="allenatore">(Figurinp)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">I NANI</div>
						<div class="allenatore">(Peppino)</div>
					</div>
				</div>
			</div>	
			<div class="anno">2016</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">I NANI</div>
						<div class="allenatore">(Peppino)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">Nuova Romanina</div>
						<div class="allenatore">(Arky)</div>
					</div>
				</div>
			</div>	
			<div class="anno">2015</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">Fica Junion</div>
						<div class="allenatore">(Giorgio Gasbarrini)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">FC Daje de tacco</div>
						<div class="allenatore">Peppino</div>
					</div>
				</div>
			</div>	
			<div class="anno">2014</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">Atletico ero na volta</div>
						<div class="allenatore">(Antonio Palombizio)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">FC Daje de tacco</div>
						<div class="allenatore">Peppino</div>
					</div>
				</div>
			</div>	
			<div class="anno">2013</div>
			<div class="coppacoppe">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">Wiskey & Benny</div>
						<div class="allenatore">(Marco & Flavio)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">FC Daje de tacco</div>
						<div class="allenatore">Peppino</div>
					</div>
				</div>
			</div>
			<div class="anno">2012</div>
			<div class="coppacoppe">
				
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">Atletico ci sarai tu</div>
						<div class="allenatore">(Antonio Palombizio)</div>
					</div>
					<div class="secondo">
						<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">FC Daje de tacco</div>
						<div class="allenatore">(Peppino)</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="tabs-3">
		<h3>Coppa Italia<span class="note"> (*prima edizione 2019/20)</span></h3>
		<div class="content">
			<div class="anno">2019/20</div>
			<div class="coppaitalia">
				<div class="vincitori competizione2">
					<div class="primo">
						<div><i class="fas fa-trophy"></i> </div>
						<div class="titolo">1°</div>
						<div class="squadra">SC Valle S. Andrea</div>
						<div class="allenatore">(Andrea Rotondo)</div>
					</div>
					<div class="secondo">
					<div><i class="fas fa-medal"></i> </div>
						<div class="titolo">2°</div>
						<div class="squadra">I NANI</div>
						<div class="allenatore">(Peppino)</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="tabs-4">
		<h3>Supercoppa<span class="note"> (*prima edizione 2020/21)</span></h3>
		<div class="content">
			<div class="anno">2020/21</div>
			<div class="supercoppa">
				<div class="vincitori competizione2">
					
				</div>
			</div>
		</div>
	</div>
	<div id="tabs-5">
		<h3>Fustometro<span class="note"> (*prima edizione 2019/20)</span></h3>
		<div class="content">
			<div class="anno">2019/20</div>
			<div class="Fustometro">
				<div class="vincitori competizione2">
				<div> <i class="fas fa-beer"></i> Arky: il fantacalcio non si abbandona mai!!!</div>
				<div> <i class="fas fa-beer"></i> Filippo: perche è il presidente vi vuole bene</div>
				<div> <i class="fas fa-beer"></i> Presidente: perche è il presidente vi vuole bene</div>
				<div> <i class="fas fa-beer"></i> Daniele "Simpatia" Rontondo</div>
				<div> <i class="fas fa-beer"></i> Salsino uccellino canterino</div>
				<div> <i class="fas fa-beer"></i> Arky</div>
				<div> <i class="fas fa-beer"></i> Daniele Rotondo</div>
				<div> <i class="fas fa-beer"></i> Andrea rotondo (3)</div>
				<div> <i class="fas fa-beer"></i> Filippo pagliarella</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <div id="tabs-6">
		<h3>Sanzioni<span class="note"> </span></h3>
		<div class="content">
			<div class="anno">2019/20</div>
			<div class="Sanzioni">
				<div class="vincitori competizione2">
					
				</div>
			</div>
		</div>
	</div> -->
</div>
<?php 
include("footer.php");
?>