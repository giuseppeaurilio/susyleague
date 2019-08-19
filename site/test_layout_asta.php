<!DOCTYPE html>
<html>
<head>
<style>
.nome_giocatore {
    display: inline-block;
    width: 75%;
    height: 45%;
    color:white;
    text-align: center;
    background-color:salmon;
    font-size: 500%;
        border-style: solid;
    border-width: 5px;
    border-color: black;
}


.squadra_giocatore {
    display: inline-block;
    width: 18%;
    height: 45%;
    color:white;
        background-color:lightsalmon;

    font-size: 500%; 
        text-align: center;
            border-style: solid;
    border-width: 5px;
    border-color: black;
}

.squadra_offerta {
    display: inline-block;
    width: 75%;
    height: 45%;
    color:white;
    text-align: center;
    background-color:blue;
    font-size: 500%;
        border-style: solid;
    border-width: 5px;
    border-color: black;
}


.prezzo_offerta {
    display: inline-block;
    width: 18%;
    height: 45%;
    color:white;
        background-color:lightblue;

    font-size: 500%; 
        text-align: center;
            border-style: solid;
    border-width: 5px;
    border-color: black;
}







.top_giocatore {
height: 300px;

}


.top_buttons {
height: 700px;
background-color:lightyellow;
}



.button_plus{
	width:49%;
	height:49%;
	font-size:1000%;
	}
	

.text_plus{
	width:49%;
	height:49%;
	font-size:1000%;
	text-align: center;
	background-color:lightgreen;
	}
	
.top_chat {
height: 400px;
text-align:center;
}


.text_chat{
	width:98%;
	height:70%;
	background-color:lightgray;
	font-size:100%;
	}
	
.text_chat_input{
	width:80%;
	height:20%;
    display: block-inline;
    font-size:300%;
    background-color:lightgreen;
	}

.button_send_message{
	width:18%;
	height:20%;
	display:block-inline;
	font-size:300%;
	}

.title_paragraph
{font-size:300%;
 text-align:center;}



</style>
</head>
<body>
<h1 class="title_paragraph">ATTACCANTI</h1>
<div class="top_giocatore">
	<div class="nome_giocatore">Higuain</div>
	<div class="squadra_giocatore">JUV</div>
	<div class="squadra_offerta">MILANdruccolo</div>
	<div class="prezzo_offerta">100</div>
</div>


<div class="top_buttons">
<button type="button" class="button_plus">+1</button>
<button type="button" class="button_plus">+5</button>

<button type="button" class="button_plus">+</button>

<input type="text" class="text_plus"></input>

</div>

<div class="top_chat">
<textarea class="text_chat">11:30:23 Higuain - Milandruccolo - 30 &#13;&#10;11:30:28 Higuain - Prosut - 31&#13;&#10;11:30:40 Higuain - Milandruccolo - 33 &#13;&#10;11:30:50 Higuain - Milandruccolo - 34 &#13;&#10;11:31:10 Higuain - Prosut - 35&#13;&#10;11:31:23 Higuain - Milandruccolo - 36 &#13;&#10;11:31:37 Higuain - Prosut - 37&#13;&#10;11:31:43 Higuain - Milandruccolo - 38 &#13;&#10;11:31:53 Higuain - Prosut - 39&#13;&#10;11:32:10 Higuain - Milandruccolo - 40 &#13;&#10;11:32:18 Higuain - Prosut - 41&#13;&#10;</textarea>
<input type="text" class="text_chat_input"></input>
<button type="button" class="button_send_message" >Invia</button>
</div>

</body>
</html>
